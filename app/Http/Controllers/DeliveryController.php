<?php

namespace App\Http\Controllers;

use App\AcceptDelivery;
use App\DeliveryCollection;
use App\Helpers\TranslationHelper;
use App\Order;
use App\Orderitem;
use App\PushNotify;
use App\RestaurantEarning;
use App\User;
use App\Rating;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use JWTAuth;
use JWTAuthException;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class DeliveryController extends Controller
{

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
    }
  

    /**
     * @param $email
     * @param $password
     * @return mixed
     */
    private function getToken($email, $password)
    {
        $token = null;
        try {
            if (!$token = JWTAuth::attempt(['email' => $email, 'password' => $password])) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'Password or email is invalid..',
                    'token' => $token,
                ]);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'Token creation failed',
            ]);
        }
        return $token;
    }

    /**
     * @param Request $request
     */
    public function login(Request $request)
    {
        $user = \App\User::where('email', $request->email)->get()->first();
        if ($user && \Hash::check($request->password, $user->password)) {

            if ($user->hasRole('Delivery Guy')) {
                $token = self::getToken($request->email, $request->password);
                $user->auth_token = $token;
                $user->save();

                $onGoingDeliveriesCount = AcceptDelivery::whereHas('order', function ($query) {
                    $query->whereIn('orderstatus_id', ['3', '4']);
                })->where('user_id', $user->id)->where('is_complete', 0)->count();

                $completedDeliveriesCount = AcceptDelivery::whereHas('order', function ($query) {
                    $query->whereIn('orderstatus_id', ['5']);
                })->where('user_id', $user->id)->where('is_complete', 1)->count();

                $response = [
                    'success' => true,
                    'data' => [
                        'id' => $user->id,
                        'auth_token' => $user->auth_token,
                        'name' => $user->name,
                        'email' => $user->email,
                        'avatar'=>$user->avatar,
                        'wallet_balance' => $user->balanceFloat,
                        'onGoingCount' => $onGoingDeliveriesCount,
                        'completedCount' => $completedDeliveriesCount,
                    ],
                ];
            } else {
                $response = ['success' => false, 'data' => 'Record doesnt exists'];
            }
        } else {
            $response = ['success' => false, 'data' => 'Record doesnt exists...'];
        }
        return response()->json($response, 201);
    }

    /**
     * @param Request $request
     */
    public function updateDeliveryUserInfo(Request $request)
    {
        $deliveryUser = auth()->user();

        if ($deliveryUser && $deliveryUser->hasRole('Delivery Guy')) {

            $onGoingDeliveriesCount = AcceptDelivery::whereHas('order', function ($query) {
                $query->whereIn('orderstatus_id', ['3', '4']);
            })->where('user_id', $deliveryUser->id)->where('is_complete', 0)->count();

            $completedDeliveriesCount = AcceptDelivery::whereHas('order', function ($query) {
                $query->whereIn('orderstatus_id', ['5']);
            })->where('user_id', $deliveryUser->id)->where('is_complete', 1)->count();

            $orders = AcceptDelivery::whereHas('order', function ($query) {
                $query->whereIn('orderstatus_id', ['3', '4', '5']);
            })->where('user_id', $deliveryUser->id)
                ->with(array('order' => function ($q) {
                    $q->select('id', 'orderstatus_id', 'unique_order_id', 'address', 'payment_mode', 'payable');
                }))->orderBy('created_at', 'DESC')->get();

            $earnings = $deliveryUser->transactions()->orderBy('id', 'DESC')->get();
            $totalEarnings = 0;
            foreach ($deliveryUser->transactions->reverse() as $transaction) {
                if ($transaction->type === 'deposit') {
                    $totalEarnings += $transaction->amount / 100;
                }
            }

            $deliveryCollection = DeliveryCollection::where('user_id', $deliveryUser->id)->first();
            if (!$deliveryCollection) {
                $deliveryCollectionAmount = 0;
            } else {
                $deliveryCollectionAmount = $deliveryCollection->amount;
            }

            $dateRange = Carbon::today()->subDays(7);
            $earningData = DB::table('transactions')
                ->where('payable_id', $deliveryUser->id)
                ->where('created_at', '>=', $dateRange)
                ->where('type', 'deposit')
                ->select(DB::raw('sum(amount) as total'), DB::raw('date(created_at) as dates'))
                ->groupBy('dates')
                ->orderBy('dates', 'desc')
                ->get();

            for ($i = 0; $i <= 6; $i++) {
                if (!isset($earningData[$i])) {
                    $amount[] = 0;
                } else {
                    $amount[] = $earningData[$i]->total / 100;
                }
            }

            for ($i = 0; $i <= 6; $i++) {
                $days[] = Carbon::now()->subDays($i)->format('D');
            }

            foreach ($amount as $amt) {
                $amtArr[] = [
                    'y' => $amt,
                ];
            }
            $amtArr = array_reverse($amtArr);
            foreach ($days as $key => $day) {
                $dayArr[] = [
                    'x' => $day,
                ];
            }
            $dayArr = array_reverse($dayArr);
            $chartData = [];
            for ($i = 0; $i <= 6; $i++) {
                array_push($chartData, ($amtArr[$i] + $dayArr[$i]));
            }

            $response = [
                'success' => true,
                'data' => [
                    'id' => $deliveryUser->id,
                    'auth_token' => $deliveryUser->auth_token,
                    'name' => $deliveryUser->name,
                    'email' => $deliveryUser->email,
                    'wallet_balance' => $deliveryUser->balanceFloat,
                    'onGoingCount' => $onGoingDeliveriesCount,
                    'completedCount' => $completedDeliveriesCount,
                    'orders' => $orders,
                    'earnings' => $earnings,
                    'totalEarnings' => $totalEarnings,
                    'deliveryCollection' => $deliveryCollectionAmount,
                ],
                'chart' => [
                    'chartData' => $chartData,
                ],
            ];
            return response()->json($response, 201);

        }

        $response = ['success' => false, 'data' => 'Record doesnt exists'];
    }

 /**
     * @param Request $request
     */
    public function getDeliveryOrders(Request $request)

    {
        $deliveryUser = Auth::user();
        $userRestaurants = $deliveryUser->restaurants;

        $deliveryGuyCommissionRate = $deliveryUser->delivery_guy_detail->commission_rate;
        $type = $request->type;
        $user = auth()->user();
        if ($user) {

            if($type=='new'){
                $orders_running = Order::where('orderstatus_id', '2')->where('delivery_type', '2')->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
                $orders_finished = Order::whereIn('orderstatus_id', ['5','6','10'])->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
                
                $running=array();


               
                
               // dd($orders_running);
                foreach ($orders_running as $order){

                    $user_order=User::where('id',$order->user_id)->first();
                               
                    if($user_order){
                        $running_order = $order;
                        $running_order['user_name']= $user_order->name;
                        $running_order['user_phone']=$user_order->phone;
                        $running_order['user_avatar']=$user_order->avatar;
                    }else{
                        $running_order = $order;
                        $running_order['user_name']= 'Desconhecido';//$user_order->name;
                        $running_order['user_phone']='';//$user_order->phone;
                        $running_order['user_avatar']='';//$user_order->avatar;
                    }

        
                    $delivery_details = null;
                    if ($running_order) {
                        if ($running_order->orderstatus_id == 3 || $running_order->orderstatus_id == 4 ) {
                            //get assigned delivery guy and get the details to show to customers
                            $delivery_guy = AcceptDelivery::where('order_id', $running_order->id)->first();
                            if ($delivery_guy) {
                                $delivery_user = User::where('id', $delivery_guy->user_id)->first();
                                $delivery_details = $delivery_user->delivery_guy_detail;
                                if (!empty($delivery_details)) {
                                    $delivery_details = $delivery_details->toArray();
                                    $delivery_details['phone'] = $delivery_user->phone;
                                }
                            }
                        }
                    }
                    //ALTERADO daqui pra baixo
                    $previsao_entrega=null;
                    $message =null;
                    
                    $rating = Rating::where('order_id', $running_order->id)->get();
                if ($rating->isEmpty()) {
                    $running_order['rating']=null;  
                } else {
                    $running_order['rating']=$rating;
                }
                    $location=json_decode($running_order->location);
                    $running_order['location']=$location;


                    $commission = 0;
                    if (config('settings.deliveryGuyCommissionFrom') == 'FULLORDER') {
                        $commission = $deliveryGuyCommissionRate / 100 * $order->total;
                    }
                    if (config('settings.deliveryGuyCommissionFrom') == 'DELIVERYCHARGE') {
                        $commission = $deliveryGuyCommissionRate / 100 * $order->delivery_charge;
                    }
                    $running_order['commission'] = number_format((float) $commission, 2, '.', '');
        /* 
                    foreach ($userRestaurants as $ur) {
                        //checking if delivery guy is assigned to that restaurant
                        if ($order->restaurant->id == $ur->id) {
                            $deliveryGuyNewOrders->push($order);
                        }
                    } */

                    $running[] = [
                        'success' => true,
                        'data' => [
                            'id' => $user->id,
                            'auth_token' => $user->auth_token,
                        ],
                        
                        'previsao_entrega'=> $previsao_entrega,//ALTERADO
                        'message' => $message,//ALTERADO
                        'running_order' => $running_order,
                        'delivery_details' => $delivery_details,
                    ];
    
    
                };
            }
          
            if($type=='running'){
                $orders_running = Order::whereIn('orderstatus_id', ['2'])->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
                $orders_finished = Order::whereIn('orderstatus_id', ['5','6','10'])->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
         
                $running=array();


               
                $acceptDeliveries = AcceptDelivery::where('user_id', Auth::user()->id)->where('is_complete', 0)->get();
               // dd($orders_running);

               foreach ($acceptDeliveries as $ad) {
                $order = Order::where('id', $ad->order_id)->whereIn('orderstatus_id', ['3'])->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->first();
    
                if ($order) {
                    $commission = 0;
                    if (config('settings.deliveryGuyCommissionFrom') == 'FULLORDER') {
                        $commission = $deliveryGuyCommissionRate / 100 * $order->total;
                    }
                    if (config('settings.deliveryGuyCommissionFrom') == 'DELIVERYCHARGE') {
                        $commission = $deliveryGuyCommissionRate / 100 * $order->delivery_charge;
                    }
                
    
  

                    $user_order=User::where('id',$order->user_id)->first();
                               
                    if($user_order){
                        $running_order = $order;
                        $running_order['user_name']= $user_order->name;
                        $running_order['user_phone']=$user_order->phone;
                        $running_order['user_avatar']=$user_order->avatar;
                    }else{
                        $running_order = $order;
                        $running_order['user_name']= 'Desconhecido';//$user_order->name;
                        $running_order['user_phone']='';//$user_order->phone;
                        $running_order['user_avatar']='';//$user_order->avatar;
                    }
                   
                    $running_order['commission'] = number_format((float) $commission, 2, '.', '');
        
                    $delivery_details = null;
                    if ($running_order) {
                        if ($running_order->orderstatus_id == 3 || $running_order->orderstatus_id == 4 ) {
                            //get assigned delivery guy and get the details to show to customers
                            $delivery_guy = AcceptDelivery::where('order_id', $running_order->id)->first();
                            if ($delivery_guy) {
                                $delivery_user = User::where('id', $delivery_guy->user_id)->first();
                                $delivery_details = $delivery_user->delivery_guy_detail;
                                if (!empty($delivery_details)) {
                                    $delivery_details = $delivery_details->toArray();
                                    $delivery_details['phone'] = $delivery_user->phone;
                                }
                            }
                        }
                    }
                    //ALTERADO daqui pra baixo
                    $previsao_entrega=null;
                    $message =null;
                    
                    $rating = Rating::where('order_id', $running_order->id)->get();
                if ($rating->isEmpty()) {
                    $running_order['rating']=null;  
                } else {
                    $running_order['rating']=$rating;
                }
                    $location=json_decode($running_order->location);
                    $running_order['location']=$location;
                    $running[] = [
                        'success' => true,
                        'data' => [
                            'id' => $user->id,
                            'auth_token' => $user->auth_token,
                        ],
                        
                        'previsao_entrega'=> $previsao_entrega,//ALTERADO
                        'message' => $message,//ALTERADO
                        'running_order' => $running_order,
                        'delivery_details' => $delivery_details,
                    ];
    
    
                };
            }
        }
           if ($type=='finished'){
            $orders_finished = Order::whereIn('orderstatus_id', ['2'])->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
            $orders_running = Order::whereIn('orderstatus_id', ['2'])->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->orderBy('id', 'DESC')->get();
            
            $finished=array();

            $acceptDeliveries = AcceptDelivery::where('user_id', Auth::user()->id)->where('is_complete', 0)->get();
            foreach ($acceptDeliveries as $ad) {
                $order = Order::where('id', $ad->order_id)->whereIn('orderstatus_id', ['4'])->with('orderitems', 'orderitems.order_item_addons', 'restaurant')->first();
    
                if ($order) {
                    $commission = 0;
                    if (config('settings.deliveryGuyCommissionFrom') == 'FULLORDER') {
                        $commission = $deliveryGuyCommissionRate / 100 * $order->total;
                    }
                    if (config('settings.deliveryGuyCommissionFrom') == 'DELIVERYCHARGE') {
                        $commission = $deliveryGuyCommissionRate / 100 * $order->delivery_charge;
                    }
                   
    
                

                $user_order=User::where('id',$order->user_id)->first();
                           
                if($user_order){
                    $running_order = $order;
                    $running_order['user_name']= $user_order->name;
                    $running_order['user_phone']=$user_order->phone;
                    $running_order['user_avatar']=$user_order->avatar;
                }else{
                    $running_order = $order;
                    $running_order['user_name']= 'Desconhecido';//$user_order->name;
                    $running_order['user_phone']='';//$user_order->phone;
                    $running_order['user_avatar']='';//$user_order->avatar;
                }
    
                $running_order['commission'] = number_format((float) $commission, 2, '.', '');

                $delivery_details = null;
                if ($running_order) {
                    if ($running_order->orderstatus_id == 3 || $running_order->orderstatus_id == 4 || $running_order->orderstatus_id == 5) {
                        //get assigned delivery guy and get the details to show to customers
                        $delivery_guy = AcceptDelivery::where('order_id', $running_order->id)->first();
                        if ($delivery_guy) {
                            $delivery_user = User::where('id', $delivery_guy->user_id)->first();
                            $delivery_details = $delivery_user->delivery_guy_detail;
                            if (!empty($delivery_details)) {
                                $delivery_details = $delivery_details->toArray();
                                $delivery_details['phone'] = $delivery_user->phone;
                            }
                        }
                    }
                }
                //ALTERADO daqui pra baixo
                $previsao_entrega=null;
                $message =null;
                
                $rating_order = Rating::where('order_id', $running_order->id)->where('rateable_type','App\Restaurant')->get();
                if ($rating_order->isEmpty()) {
                    $running_order['rating_order']=null;  
                } else {
                    $running_order['rating_order']=$rating_order;
                }

                $rating_delivery = Rating::where('order_id', $running_order->id)->where('rateable_type','App\User')->get();
                if ($rating_delivery->isEmpty()) {
                    $running_order['rating_delivery']=null;  
                } else {
                    $running_order['rating_delivery']=$rating_delivery;
                }
                $location=json_decode($running_order->location);
                
                $running_order['location']=$location;
                $finished[] = [
                    'success' => true,
                    'data' => [
                        'id' => $user->id,
                        'auth_token' => $user->auth_token,
                       
                    ],
                    
                    'previsao_entrega'=> $previsao_entrega,//ALTERADO
                    'message' => $message,//ALTERADO
                    'running_order' => $running_order,
                    'delivery_details' => $delivery_details,
                ];
            

            }
            $running=$finished;
           }
        }
            
                        
            $response=$this->paginate($running);
           // $response[0]['running_total']=count($orders_running);
            //$response[0]['finished_total']=count($orders_finished);

           
            return response()->json($response);
        }
        return response()->json(['success' => false], 401);
    }


    /**
     * @param Request $request
     */
    public function getDeliveryOrders2(Request $request)
    {
        $deliveryUser = Auth::user();
        $userRestaurants = $deliveryUser->restaurants;

        $deliveryGuyCommissionRate = $deliveryUser->delivery_guy_detail->commission_rate;
        $type = $request->type;
       

        $orders = Order::where('orderstatus_id', '2')
            ->where('delivery_type', '1')
            ->with('orderitems', 'orderitems.order_item_addons', 'restaurant')
            ->orderBy('id', 'DESC')
            ->get();
        
        if($type=='new'){
        $deliveryGuyNewOrders = collect();
        foreach ($orders as $order) {

            $commission = 0;
            if (config('settings.deliveryGuyCommissionFrom') == 'FULLORDER') {
                $commission = $deliveryGuyCommissionRate / 100 * $order->total;
            }
            if (config('settings.deliveryGuyCommissionFrom') == 'DELIVERYCHARGE') {
                $commission = $deliveryGuyCommissionRate / 100 * $order->delivery_charge;
            }
            $order->commission = number_format((float) $commission, 2, '.', '');

            foreach ($userRestaurants as $ur) {
                //checking if delivery guy is assigned to that restaurant
                if ($order->restaurant->id == $ur->id) {
                    $deliveryGuyNewOrders->push($order);
                }
            }
        }
        $respon=[
            'success'=>true,
            'running_order'=>$deliveryGuyNewOrders,
        ];
        $response=$this->paginate($respon);
    }
    if($type=='running'){

        $alreadyAcceptedDeliveries = collect();
        $acceptDeliveries = AcceptDelivery::where('user_id', Auth::user()->id)->where('is_complete', 0)->get();
        foreach ($acceptDeliveries as $ad) {
            $order = Order::where('id', $ad->order_id)->whereIn('orderstatus_id', ['3'])->with('restaurant')->first();

            if ($order) {
                $commission = 0;
                if (config('settings.deliveryGuyCommissionFrom') == 'FULLORDER') {
                    $commission = $deliveryGuyCommissionRate / 100 * $order->total;
                }
                if (config('settings.deliveryGuyCommissionFrom') == 'DELIVERYCHARGE') {
                    $commission = $deliveryGuyCommissionRate / 100 * $order->delivery_charge;
                }
                $order->commission = number_format((float) $commission, 2, '.', '');

                $alreadyAcceptedDeliveries->push($order);
            }
        }
        $respon=[
            'success'=>true,
            'running_order'=>$alreadyAcceptedDeliveries,
        ];
        $response=$this->paginate($respon);
       
    }
    if($type=='finished'){

        $pickedupOrders = collect();
        $acceptDeliveries = AcceptDelivery::where('user_id', Auth::user()->id)->where('is_complete', 0)->get();
        foreach ($acceptDeliveries as $ad) {
            $order = Order::where('id', $ad->order_id)->whereIn('orderstatus_id', ['4'])->with('restaurant')->first();

            if ($order) {
                $commission = 0;
                if (config('settings.deliveryGuyCommissionFrom') == 'FULLORDER') {
                    $commission = $deliveryGuyCommissionRate / 100 * $order->total;
                }
                if (config('settings.deliveryGuyCommissionFrom') == 'DELIVERYCHARGE') {
                    $commission = $deliveryGuyCommissionRate / 100 * $order->delivery_charge;
                }
                $order->commission = number_format((float) $commission, 2, '.', '');

                $pickedupOrders->push($order);
            }
        }
        $respon=[
            'success'=>true,
            'running_order'=>$pickedupOrders,
        ];
        $response=$this->paginate($respon);
    }

        

        return response()->json($response);
    }

    /**
     * @param Request $request
     */
    public function getSingleDeliveryOrder(Request $request)
    {
        //find the order
        $singleOrder = Order::where('unique_order_id', $request->unique_order_id)->first();

        //get order id and delivery boy id
        $singleOrderId = $singleOrder->id;
        $deliveryUser = Auth::user();

        $checkOrder = AcceptDelivery::where('order_id', $singleOrderId)
            ->where('user_id', $deliveryUser->id)
            ->first();

        $deliveryGuyCommissionRate = $deliveryUser->delivery_guy_detail->commission_rate;

        $commission = 0;
        if (config('settings.deliveryGuyCommissionFrom') == 'FULLORDER') {
            $commission = $deliveryGuyCommissionRate / 100 * $singleOrder->total;
        }
        if (config('settings.deliveryGuyCommissionFrom') == 'DELIVERYCHARGE') {
            $commission = $deliveryGuyCommissionRate / 100 * $singleOrder->delivery_charge;
        }

        //check if the loggedin delivery boy has accepted the order
        if ($checkOrder) {
            //this order was already accepted by this delivery boy
            //so send the order to him
            $singleOrder = Order::where('unique_order_id', $request->unique_order_id)
                ->with('restaurant')
                ->with('orderitems.order_item_addons')
                ->with(array('user' => function ($query) {
                    $query->select('id', 'name', 'phone');
                }))
                ->first();

            $singleOrder->commission = number_format((float) $commission, 2, '.', '');

            // sleep(3);
            return response()->json($singleOrder);
        }

        //else other can view the order
        $singleOrder = Order::where('unique_order_id', $request->unique_order_id)
            ->where('orderstatus_id', 2)
            ->with('restaurant')
            ->with('orderitems.order_item_addons')
            ->with(array('user' => function ($query) {
                $query->select('id', 'name', 'phone');
            }))
            ->first();
        $singleOrder->commission = number_format((float) $commission, 2, '.', '');

        // sleep(3);
        return response()->json($singleOrder);
    }

    /**
     * @param Request $request
     */
    public function setDeliveryGuyGpsLocation(Request $request)
    {

        $deliveryUser = auth()->user();

        if ($deliveryUser->hasRole('Delivery Guy')) {

            //update the lat, lng and heading of delivery guy
            $deliveryUser->delivery_guy_detail->delivery_lat = $request->delivery_lat;
            $deliveryUser->delivery_guy_detail->delivery_long = $request->delivery_long;
            $deliveryUser->delivery_guy_detail->heading = $request->heading;
            $deliveryUser->delivery_guy_detail->save();

            $success = true;
            return response()->json($success);
        }

    }

    /**
     * @param Request $request
     */
    public function getDeliveryGuyGpsLocation(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();

        if ($order) {
            $deliveryUserId = $order->accept_delivery->user->id;
            $deliveryUser = User::where('id', $deliveryUserId)->first();
            $deliveryUserDetails = $deliveryUser->delivery_guy_detail;
        }

        if ($deliveryUserDetails) {
            return response()->json($deliveryUserDetails);
        }
    }

    /**
     * @param Request $request
     */
    public function acceptToDeliver(Request $request)
    {
        $deliveryUser = auth()->user();

        if ($deliveryUser && $deliveryUser->hasRole('Delivery Guy')) {

            $max_accept_delivery_limit = $deliveryUser->delivery_guy_detail->max_accept_delivery_limit;

            $order = Order::where('id', $request->order_id)->first();

            if ($order) {

                $deliveryGuyCommissionRate = $deliveryUser->delivery_guy_detail->commission_rate;
                $commission = 0;
                if (config('settings.deliveryGuyCommissionFrom') == 'FULLORDER') {
                    $commission = $deliveryGuyCommissionRate / 100 * $order->total;
                }
                if (config('settings.deliveryGuyCommissionFrom') == 'DELIVERYCHARGE') {
                    $commission = $deliveryGuyCommissionRate / 100 * $order->delivery_charge;
                }

                $checkOrder = AcceptDelivery::where('order_id', $order->id)->first();

                if (!$checkOrder) {
                    //check the max_accept_delivery_limit
                    $nonCompleteOrders = AcceptDelivery::where('user_id', $deliveryUser->id)->where('is_complete', 0)->with('order')->get();
                    // dd($nonCompleteOrders->count());

                    $countNonCompleteOrders = 0;
                    if ($nonCompleteOrders) {
                        foreach ($nonCompleteOrders as $nonCompleteOrder) {
                            if ($nonCompleteOrder->order && $nonCompleteOrder->order->orderstatus_id != 6) {
                                $countNonCompleteOrders++;
                            }
                        }
                    }

                    if ($countNonCompleteOrders < $max_accept_delivery_limit) {

                        try {
                            $order->orderstatus_id = '3'; //Accepted by delivery boy (Deliery Boy Assigned)
                            $order->save();

                            $acceptDelivery = new AcceptDelivery();
                            $acceptDelivery->order_id = $order->id;
                            $acceptDelivery->user_id = $deliveryUser->id;
                            $acceptDelivery->customer_id = $order->user->id;
                            $acceptDelivery->save();

                            $singleOrder = Order::where('id', $request->order_id)
                                ->with('restaurant')
                                ->with('orderitems.order_item_addons')
                                ->with(array('user' => function ($query) {
                                    $query->select('id', 'name', 'phone');
                                }))
                                ->first();
                            // sleep(3);
                            //ALTERADO - desabilitei envio de push para status 3
                           // if (config('settings.enablePushNotificationOrders') == 'true') {
                             //   $notify = new PushNotify();
                            //    $notify->sendPushNotification('3', $order->user_id, $order->unique_order_id);
                           // }

                        } catch (Illuminate\Database\QueryException $e) {
                            $errorCode = $e->errorInfo[1];
                            if ($errorCode == 1062) {
                                $singleOrder->already_accepted = true;
                            }
                        }
                        $singleOrder->commission = number_format((float) $commission, 2, '.', '');
                        return response()->json($singleOrder);
                    } else {
                        $singleOrder = Order::where('id', $request->order_id)
                            ->with('restaurant')
                            ->with('orderitems.order_item_addons')
                            ->with(array('user' => function ($query) {
                                $query->select('id', 'name', 'phone');
                            }))
                            ->first();
                        $singleOrder->max_order = true;
                        $singleOrder->commission = number_format((float) $commission, 2, '.', '');
                        return response()->json($singleOrder);
                    }
                } else {
                    $singleOrder = Order::where('id', $request->order_id)
                        ->with('restaurant')
                        ->with('orderitems.order_item_addons')
                        ->with(array('user' => function ($query) {
                            $query->select('id', 'name', 'phone');
                        }))
                        ->first();
                    $singleOrder->already_accepted = true;
                    $singleOrder->commission = number_format((float) $commission, 2, '.', '');
                    return response()->json($singleOrder);
                }
            }
        }

    }

    /**
     * @param Request $request
     */
    public function pickedupOrder(Request $request)
    {

        $deliveryUser = auth()->user();

        if ($deliveryUser->hasRole('Delivery Guy')) {

            $order = Order::where('id', $request->order_id)->first();

            if ($order) {

                $deliveryGuyCommissionRate = $deliveryUser->delivery_guy_detail->commission_rate;
                $commission = 0;
                if (config('settings.deliveryGuyCommissionFrom') == 'FULLORDER') {
                    $commission = $deliveryGuyCommissionRate / 100 * $order->total;
                }
                if (config('settings.deliveryGuyCommissionFrom') == 'DELIVERYCHARGE') {
                    $commission = $deliveryGuyCommissionRate / 100 * $order->delivery_charge;
                }

                $order->orderstatus_id = '4'; //Accepted by delivery boy (Deliery Boy Assigned)
                $order->save();

                $singleOrder = Order::where('id', $request->order_id)
                    ->with('restaurant')
                    ->with('orderitems.order_item_addons')
                    ->with(array('user' => function ($query) {
                        $query->select('id', 'name', 'phone');
                    }))
                    ->first();

                if (config('settings.enablePushNotificationOrders') == 'true') {
                    $notify = new PushNotify();  
                    $notify->sendPushNotification('4', $order->user_id, $order->unique_order_id);
                }

                $singleOrder->commission = number_format((float) $commission, 2, '.', '');

                return response()->json($singleOrder);
            }
        }
    }

    /**
     * @param Request $request
     */
    public function deliverOrder(Request $request, TranslationHelper $translationHelper)
    {

        $keys = ['deliveryCommissionMessage', 'deliveryTipTransactionMessage'];

        $translationData = $translationHelper->getDefaultLanguageValuesForKeys($keys);

        $deliveryUser = auth()->user();

        if ($deliveryUser->hasRole('Delivery Guy')) {

            $order = Order::where('id', $request->order_id)->first();
            $user = $order->user;

            if ($order) {

                $deliveryGuyCommissionRate = $deliveryUser->delivery_guy_detail->commission_rate;
                $commission = 0;
                if (config('settings.deliveryGuyCommissionFrom') == 'FULLORDER') {
                    $commission = $deliveryGuyCommissionRate / 100 * $order->total;
                }
                if (config('settings.deliveryGuyCommissionFrom') == 'DELIVERYCHARGE') {
                    $commission = $deliveryGuyCommissionRate / 100 * $order->delivery_charge;
                }

                if (config('settings.enableDeliveryPin') == 'true') {
                    if ($user->delivery_pin == strtoupper($request->delivery_pin)) {
                        $order->orderstatus_id = '5'; //Accepted by delivery boy (Deliery Boy Assigned)
//ALTERADO---
                        $order->delivered_at = date('Y-m-d H:i:s'); 
                        $order->is_delivered = '1'; 
//ALTERADO---

                        $order->save();

                        $completeDelivery = AcceptDelivery::where('order_id', $order->id)->first();
                        $completeDelivery->is_complete = true;
                        $completeDelivery->save();

                        $singleOrder = Order::where('id', $request->order_id)
                            ->with('restaurant')
                            ->with('orderitems.order_item_addons')
                            ->with(array('user' => function ($query) {
                                $query->select('id', 'name', 'phone');
                            }))
                            ->first();

                        if (config('settings.enablePushNotificationOrders') == 'true') {
                            $notify = new PushNotify();
                            $notify->sendPushNotification('5', $order->user_id, $order->unique_order_id);
                        }

                        //Update restautant earnings...
                        $restaurant_earning = RestaurantEarning::where('restaurant_id', $order->restaurant->id)
                            ->where('is_requested', 0)
                            ->first();
                        if ($restaurant_earning) {
                            // $restaurant_earning->amount += $order->total - $order->delivery_charge;
                            $restaurant_earning->amount += $order->total - ($order->delivery_charge + $order->tip_amount);
                            $restaurant_earning->save();
                        } else {
                            $restaurant_earning = new RestaurantEarning();
                            $restaurant_earning->restaurant_id = $order->restaurant->id;
                            // $restaurant_earning->amount = $order->total - $order->delivery_charge;
                            $restaurant_earning->amount = $order->total - ($order->delivery_charge + $order->tip_amount);
                            $restaurant_earning->save();
                        }

                        //Update delivery guy collection
                        if ($order->payment_mode == 'COD') {
                            $delivery_collection = DeliveryCollection::where('user_id', $completeDelivery->user_id)->first();
                            if ($delivery_collection) {
                                $delivery_collection->amount += $order->payable;
                                $delivery_collection->save();
                            } else {
                                $delivery_collection = new DeliveryCollection();
                                $delivery_collection->user_id = $completeDelivery->user_id;
                                $delivery_collection->amount = $order->payable;
                                $delivery_collection->save();
                            }
                        }

                        //Update delivery guy's earnings...
                        if (config('settings.enableDeliveryGuyEarning') == 'true') {
                            //if enabled, then check based on which value the commision will be calculated
                            $deliveryUser = AcceptDelivery::where('order_id', $order->id)->first();
                            if ($deliveryUser->user) {
                                if (config('settings.deliveryGuyCommissionFrom') == 'FULLORDER') {
                                    //get order total and delivery guy's commission rate and transfer to wallet
                                    // $commission = $deliveryUser->user->delivery_guy_detail->commission_rate / 100 * $order->total;
                                    $commission = $deliveryUser->user->delivery_guy_detail->commission_rate / 100 * ($order->total - $order->tip_amount);
                                    $deliveryUser->user->deposit($commission * 100, ['description' => $translationData->deliveryCommissionMessage . $order->unique_order_id]);
                                }
                                if (config('settings.deliveryGuyCommissionFrom') == 'DELIVERYCHARGE') {
                                    //get order delivery charge and delivery guy's commission rate and transfer to wallet
                                    $commission = $deliveryUser->user->delivery_guy_detail->commission_rate / 100 * $order->delivery_charge;
                                    $deliveryUser->user->deposit($commission * 100, ['description' => $translationData->deliveryCommissionMessage . $order->unique_order_id]);
                                }
                            }
                        }
                        $singleOrder->commission = number_format((float) $commission, 2, '.', '');
                        return response()->json($singleOrder);
                    } else {
                        $singleOrder = Order::where('id', $request->order_id)
                            ->whereIn('orderstatus_id', ['2', '3', '4'])
                            ->with('restaurant')
                            ->with('orderitems.order_item_addons')
                            ->with(array('user' => function ($query) {
                                $query->select('id', 'name', 'phone');
                            }))
                            ->first();

                        $singleOrder->delivery_pin_error = true;
                        $singleOrder->commission = number_format((float) $commission, 2, '.', '');
                        // sleep(3);
                        return response()->json($singleOrder);
                    }
                } else {
                    $order->orderstatus_id = '5'; //Accepted by delivery boy (Deliery Boy Assigned)
                    $order->save();

                    $completeDelivery = AcceptDelivery::where('order_id', $order->id)->first();
                    $completeDelivery->is_complete = true;
                    $completeDelivery->save();

                    $singleOrder = Order::where('id', $request->order_id)
                        ->with('restaurant')
                        ->with('orderitems.order_item_addons')
                        ->with(array('user' => function ($query) {
                            $query->select('id', 'name', 'phone');
                        }))
                        ->first();

                    if (config('settings.enablePushNotificationOrders') == 'true') {
                        $notify = new PushNotify();
                        $notify->sendPushNotification('5', $order->user_id, $order->unique_order_id);
                    }

                    $restaurant_earning = RestaurantEarning::where('restaurant_id', $order->restaurant->id)
                        ->where('is_requested', 0)
                        ->first();
                    if ($restaurant_earning) {
                        // $restaurant_earning->amount += $order->total - $order->delivery_charge;
                        $restaurant_earning->amount += $order->total - ($order->delivery_charge + $order->tip_amount);
                        $restaurant_earning->save();
                    } else {
                        $restaurant_earning = new RestaurantEarning();
                        $restaurant_earning->restaurant_id = $order->restaurant->id;
                        // $restaurant_earning->amount = $order->total - $order->delivery_charge;
                        $restaurant_earning->amount = $order->total - ($order->delivery_charge + $order->tip_amount);
                        $restaurant_earning->save();
                    }

                    //Update delivery guy collection
                    if ($order->payment_mode == 'COD') {
                        $delivery_collection = DeliveryCollection::where('user_id', $completeDelivery->user_id)->first();
                        if ($delivery_collection) {
                            $delivery_collection->amount += $order->payable;
                            $delivery_collection->save();
                        } else {
                            $delivery_collection = new DeliveryCollection();
                            $delivery_collection->user_id = $completeDelivery->user_id;
                            $delivery_collection->amount = $order->payable;
                            $delivery_collection->save();
                        }
                    }

                    //Update delivery guy's earnings...
                    if (config('settings.enableDeliveryGuyEarning') == 'true') {
                        //if enabled, then check based on which value the commision will be calculated
                        $deliveryUser = AcceptDelivery::where('order_id', $order->id)->first();
                        if ($deliveryUser->user) {
                            if (config('settings.deliveryGuyCommissionFrom') == 'FULLORDER') {
                                //get order total and delivery guy's commission rate and transfer to wallet
                                // $commission = $deliveryUser->user->delivery_guy_detail->commission_rate / 100 * $order->total;
                                $commission = $deliveryUser->user->delivery_guy_detail->commission_rate / 100 * ($order->total - $order->tip_amount);
                                $deliveryUser->user->deposit($commission * 100, ['description' => $translationData->deliveryCommissionMessage . $order->unique_order_id]);
                            }
                            if (config('settings.deliveryGuyCommissionFrom') == 'DELIVERYCHARGE') {
                                //get order delivery charge and delivery guy's commission rate and transfer to wallet
                                $commission = $deliveryUser->user->delivery_guy_detail->commission_rate / 100 * $order->delivery_charge;
                                $deliveryUser->user->deposit($commission * 100, ['description' => $translationData->deliveryCommissionMessage . $order->unique_order_id]);
                            }
                        }
                    }
                    // update tip amount charges
                    if ($deliveryUser->user) {
                        if ($deliveryUser->user->delivery_guy_detail->tip_commission_rate && !is_null($deliveryUser->user->delivery_guy_detail->tip_commission_rate)) {
                            $commission = $deliveryUser->user->delivery_guy_detail->tip_commission_rate / 100 * $order->tip_amount;
                            $deliveryUser->user->deposit($commission * 100, ['description' => $translationData->deliveryTipTransactionMessage . ' : ' . $order->unique_order_id]);
                        }
                    }
                    return response()->json($singleOrder);
                }
            }
        }
    }

}
