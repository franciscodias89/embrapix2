<?php
namespace App;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Interfaces\WalletFloat;
use ChristianKuri\LaravelFavorite\Traits\Favoriteability;
use Bavix\Wallet\Traits\HasWalletFloat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Services\ImpersonateManager;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use willvincent\Rateable\Rateable;


class User extends Authenticatable implements JWTSubject, Wallet, WalletFloat
{
    use Notifiable, HasRoles, HasWalletFloat, Rateable, Impersonate, Favoriteability;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'auth_token', 'phone', 'user_type', 'customer_id', 'restaurant_id', 'usercode_referral', 'user_type','usercode', 'default_address_id', 'delivery_pin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function addresses()
    {
        return $this->hasMany('App\Address');
    }

    /**
     * @return mixed
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * @return mixed
     */
    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class);
    }

    
    /**
     * @return mixed
     */
    public function delivery_guy_detail()
    {
        return $this->belongsTo('App\DeliveryGuyDetail');  
    }

    /**
     * @return mixed
     */
    public function toggleActive()
    {
        $this->is_active = !$this->is_active;
        return $this;
    }
 /**
     * @return mixed
     */
    public function favorite_list($user_id)
    {
        $user = User::where('id', $user_id)->first();
        
        $list=$user->favorite(Restaurant::class);
        return $list;
        
    }

    public function isImpersonated()
    {
        return app(ImpersonateManager::class)->isImpersonating();
    }

}
