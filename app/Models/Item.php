<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'nama',
        'total',
        'warna',
        'harga'
    ];

    public function items(){
        return $this->belongsToMany(Category::class, 'items_categories', 'category_id', 'item_id');
    }

    use HasFactory;
}
