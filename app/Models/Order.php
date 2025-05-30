<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // +++++++++++++++++++++++
    protected $fillable = [
        'user_id', 'billing_email', 'billing_name', 'billing_address', 'billing_city',
        'billing_province', 'billing_postalcode', 'billing_phone', 'billing_name_on_card', 'billing_discount', 'billing_discount_code', 'billing_subtotal', 'billing_tax', 'billing_total', 'payment_gateway', 'error',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // علاقة اوردر ب برودكت علاقة ماني تو ماني 
    // علاقة ماني تو ماني بنحط سجل اضافي بجدول الكسر ولنسميه كواتتيتي الكمية 
    // لان بالحالة الافتراضية جدول الكسر مافيه الا  عمودين هني الايديات هك بتضيف عمود تضافي 
    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity');
    }

    // ++++++++++++++++++++++
}
