<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;
    // هاد التريل من باكج السيرش نيكولا 
    use SearchableTrait;
// هذا لاستيراد   لارفل سكاوت المرحلة الاولة لاستخدام  الغوليا 
    use Searchable;
    protected $fillable = ['quantity'];


    // ++++++++++++++++++++++++++++++++++++++++++++++++
      /**
     * Searchable rules.
     *
     * @var array
     */
    // ها التابع من باكج السرش نيكولا 
    // اول باكج بحث بحيث تعطي وزن ثقل لافضلية البحث 
    
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.name' => 10,
            'products.details' => 5,
            'products.description' => 2,
        ],
       
    ];
    
    //  هاد التابع منشان يستخدم السكاوت يلي هوي المرحلة الاولى قبل  الغوليا 
    // يلي فيها بنستخدم السرش
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

   

    // +++++++++++++++++++++++++++++++++++++++++++++++++++


    public function presentPrice()
    {
        return '$' . number_format($this->price / 100, 2);
    }
    // هذا لوكال سكوب Local Query Scope
    public function scopeMightAlsoLike($query)
    {
        return $query->inRandomOrder()->take(4);
    }

    public function categories()
    {
        return $this->belongsToMany('App\models\Category');
    }

    // * تحديد الفهرس الذي سيتم استخدامه في Algolia
//   انا اضفت هذا التابع في هذا التطبيق الجديد حصرا لياشر ع الاندكس في الغولبا نفسو تبع هداك التطبيق
// صراحة لهلا ماجربت فائدتو من عدما 
   public function searchableAs()
   {
       return 'products_index'; // استخدم نفس اسم الفهرس في التطبيق السابق
   }

}
