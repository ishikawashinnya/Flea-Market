<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_item extends Model
{
    use HasFactory;

    public function item() {
        return $this->BelongsTo(Item::class);
    }

    public function category() {
        return $this->BelongsTo(Category::class);
    }
}
