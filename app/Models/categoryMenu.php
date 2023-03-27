<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categoryMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoryLogo',
        'categoryName'
    ];

    public function menus()
    {
        return $this->hasMany(menu::class, 'categoryID', 'id');
    }
}
