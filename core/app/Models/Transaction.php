<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
   use HasFactory;
    protected $guarded = ['id'];

    public function customers(){
        return $this->belongsTo(User::class,'customer');
    }
    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }

    public function status(){
        switch ($this->status) {
            case 1:
                return "<span style='color:#2D9596'>WAIT FOR PAYMENT</span>";
                break;
            case 2:
                return "<span style='color:#1640D6'>PAYMENT APPROVE</span>";
                break;
            case 3:
                return "<span style='color:#FF8F8F'>PAYMENT REJECT</span>";
                break;
            case 4:
               return "<span style='color:#2D9596'>WAIT FOR FULL PAYMENT</span>";
                break;
            case 5:
                return "<span style='color:#1640D6'>COMPLETED</span>";
                break;
            default:
                return "<span style='color:#FF8F8F'>INVALID</span>";
                break;
        }
    }
    public function shipment(){
        switch ($this->shipment) {
            case 1:
                return "<span style='color:#2D9596'>SEND</span>";
                break;
            case 0:
                return "<span style='color:#FF8F8F'>WAITING</span>";
                break;
            default:
                return "<span style='color:#FF8F8F'>INVALID</span>";
                break;
        }
    }

}
