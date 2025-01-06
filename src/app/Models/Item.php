<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'img_url',
        'user_id',
        'condition_id',
    ];

    public function category_items() {
        return $this->hasMany(CategoryItem::class);
    }

    public function likes() {
        return $this->hasMany(LIke::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function sold_items() {
        return $this->hasMany(SoldItem::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function condition() {
        return $this->belongsTo(Condition::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'category_items');
    }

    public function subcategories() {
        return $this->belongsToMany(Subcategory::class, 'category_items');
    }
}
