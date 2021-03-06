<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Restaurant;
use Auth;




class GeneralInformationsController extends Controller
{
      /**
      * @param $request
     * @return mixed
     */
    public function GeneralInformations(Request $request)
    {
          
        $link_url=$request->link_url;
        $link_username=$request->link_username;

        $restaurant=Restaurant::where('id',1)->with('categories')->first();

        if($link_url != null){
            $dynamic_link_open=[
                'screen'=> 'ShopPage',
                'id'=> $restaurant->id,
                'data'=>$restaurant,
            ];
        }else{
            $dynamic_link_open=[
                'screen'=> null,
                'id'=> null,
                'data'=>null,
            ];
        };

        if($link_url== null){
            $dynamic_link_usercode=null;
        }else{
            $dynamic_link_usercode='TESTE134';
        }
        

        $versao_android_atual='2.0.8';
        $versao_ios_atual='2.0.7';

        $versao_minima_android='2.0.8';
        $versao_minima_ios='2.0.7';
        $link_android='https://play.google.com/store/apps/details?id=com.comprabakana';
        $link_ios='https://apps.apple.com/us/app/compra-bakana/id1498707340?ls=1';
        
        $version=[
            'versao_android_atual' =>  $versao_android_atual,
            'versao_ios_atual' =>  $versao_ios_atual,
            'versao_minima_android' =>  $versao_minima_android,
            'versao_minima_ios' =>$versao_minima_ios,
            'link_android'=>$link_android,
            'link_ios'=>$link_ios,
            'link_termos_de_uso'=>'https://comprabakana.com.br/termos-de-uso-app',
            'link_politicas_de_privacidade'=> 'https://comprabakana.com.br/politicas-de-privacidade-app'
        ];

        $convidaramigos=[
            'usercode'=>null,
            'text_top'=> 'Convide seus amigos para usar o App Compra Bakana, e ganhe 0,1% de todas as compras que eles fizerem no app (atrav??s de Cart??o de Cr??dito, D??bito ou PIX), todos os meses, para SEMPRE!',
            'text_whatsapp' =>'Ol??, Como vai? Voc?? j?? conhece o aplicativo Compra Bakana que chegou nesta cidade? Com ele voc?? pode fazer compras em restaurantes, supermercados, farm??cias, petshops, e quaisquer outras lojas da sua cidade e receber em sua casa. Al??m disso, em cada compra voc?? acumula CashBack (dinheiro de volta) que pode ser usado em outras compras. Visualize ofertas, folhetos, compare pre??os, ganhe cupons de desconto e participe de sorteios. Tudo isso em um ??nico aplicativo! J?? viu algo assim? O Compra Bakana ?? o melhor aplicativo de Compras do Brasil! Baixe agora mesmo!',
            'text_others'=> 'Ol??, Como vai? Voc?? j?? conhece o aplicativo Compra Bakana que chegou nesta cidade? Com ele voc?? pode fazer compras em restaurantes, supermercados, farm??cias, petshops, e quaisquer outras lojas da sua cidade e receber em sua casa. Al??m disso, em cada compra voc?? acumula CashBack (dinheiro de volta) que pode ser usado em outras compras. Visualize ofertas, folhetos, compare pre??os, ganhe cupons de desconto e participe de sorteios. Tudo isso em um ??nico aplicativo! J?? viu algo assim? O Compra Bakana ?? o melhor aplicativo de Compras do Brasil! Baixe agora mesmo! ',
  
                   
        ];

        $promotions=[
            [
                'id'=>01,
                'title'=> 'Ofertas',
                'image'=> 'https://app.comprabakana.com.br/assets/img/promotions/Ofertas.png',
            ],
            [
                'id'=>02,
                'title'=> 'Folhetos',
                'image'=> 'https://app.comprabakana.com.br/assets/img/promotions/Folhetos.png',
            ],
            [
                'id'=>03,
                'title'=> 'CashBack',
                'image'=> 'https://app.comprabakana.com.br/assets/img/promotions/CashBack.png',
            ],
            [
                'id'=>04,
                'title'=> 'Cupons de Desconto',
                'image'=> 'https://app.comprabakana.com.br/assets/img/promotions/Cupons.png',
            ],
            [
                'id'=>05,
                'title'=> 'Entrega Gr??tis',
                'image'=> 'https://app.comprabakana.com.br/assets/img/promotions/Delivery.png',
            ],
            [
                'id'=>06,
                'title'=> 'Sorteios',
                'image'=> 'https://app.comprabakana.com.br/assets/img/promotions/Sorteios.png',
            ],
            
           
        ];

        $cashbakana=1;

        $text_recommend_restaurant='N??o encontrou alguma loja ou restaurante no App? Voc?? pode indic??-los preenchendo o formul??rio abaixo!';
        $text_apply_restaurant='Sua empresa ainda n??o est?? no CompraBakana? N??o perca tempo, voc?? est?? perdendo vendas! Preencha o formul??rio abaixo, e nossa equipe entrar?? em contato com voc??!';


        $account_id_iugu_mestre='';
        $keys=[
            'account_id'=> $account_id_iugu_mestre,
        ];

        $cidades_app=[
            ['Itajub??-MG'],['S??o Jo??o del Rei-MG'],['Pedro Leopoldo-MG'],['Santo Ant??nio do Monte-MG']
        ];
        $cidades_app_text='Confira abaixo as cidades onde estamos chegando:';


        $response=[
            'version'=>$version,
            'keys'=> $keys,
            'convidaramigosguest'=> $convidaramigos,
            'promotions'=> $promotions,
            'cashbakana'=>$cashbakana,
            'usercode'=>$dynamic_link_usercode,
            'dynamic_link_open'=> $dynamic_link_open,
            'text_recommend_restaurant'=>$text_recommend_restaurant,
            'text_apply_restaurant'=>$text_apply_restaurant,
            'show_home_no_stores_buttons'=>false,
            'cidades_app'=>$cidades_app,
            'cidades_app_text'=>$cidades_app_text,


        ];
        
      
        return response()->json($response);
    }


    
};
