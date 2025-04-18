<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{

    use HasFactory;

    // هالمودل نحن منا بحاجتو بس عمناه مشان الداش بورد الخرا 


    protected $table = 'category_product';

    protected $fillable = ['product_id', 'category_id'];
}
