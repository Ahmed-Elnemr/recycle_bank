<?php

namespace App\Models;

use App\Models\User;
use App\Models\Orders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrdersStatus extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'order_id',
        'state',
    ];

    public function user(){
        return $this->belongsTo(User::class ,'user_id','id'  );
    }
    public function order(){
        return $this->belongsTo(Orders::class,'order_id','id'  );
    }
}