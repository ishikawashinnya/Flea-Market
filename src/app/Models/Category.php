<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function category_items() {
        return $this->hasMany(Category_item::class);
    }

    public function subcategories() {
        return $this->hasMany(Subcategory::class);
    }

    public function items() {
        return $this->belongsToMany(Item::class, 'category_items');
    }
}
