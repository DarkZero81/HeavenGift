<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string|null $image
 * @property bool $is_active
 */
class Category extends Model
{
    protected $fillable = ['name', 'image', 'is_active'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
