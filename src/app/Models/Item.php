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
        return $this->hasMany(Category_item::class);
    }

    public function likes() {
        return $this->hasMany(LIke::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function sold_items() {
        return $this->hasMany(Sold_item::class);
    }

    public function user() {
        return $this->BelongsTo(User::class);
    }

    public function condition() {
        return $this->BelongsTo(Condition::class);
    }
}
