<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
      'id_category',
      'category'
    ];

    public function categories(){
      return $this->belongToMany(Item::class, 'items_categories', 'item_id', 'category_id');
    }
    use HasFactory;
}
