<?php

namespace App;

use Illuminate\Database\QueryException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed id_customers
 */
class Customer extends Authenticatable
{
    use Notifiable;

    protected $attributes = ['CustomerShoppingVolume'];
    protected $appends = ['CustomerShoppingVolume'];
    protected $table = 'customers';
    protected $primaryKey = 'id_customers';
    //
    protected $fillable = [
        'name', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getCustomerShoppingVolumeAttribute()
    {
        $shoppingVolume = 0.00;
        try {
            $shoppingVolume = DB::table('v_getCustomerShoppingVolume')
                ->where('id_customer', '=', $this->id_customers)
                ->get('volume');
            if (count($shoppingVolume) > 0) {
                $shoppingVolume = $shoppingVolume[0]->volume;
            }
        } catch (QueryException   $e) {
            error_log($e->getMessage());
        }
        return $shoppingVolume;
    }
}
