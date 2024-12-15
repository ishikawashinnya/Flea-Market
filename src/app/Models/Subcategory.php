<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'category_id'
    ];

    public function category_items() {
        return $this->hasMany(Category_item::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function items() {
        return $this->belongsToMany(Item::class, 'category_items');
    }
}
