<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public static function getCategories()
    {
        return ['D09', 'D14', 'D18', 'D24', 'CH09', 'CH14', 'CH18', 'CH24'];
    }
}
