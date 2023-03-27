<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    use HasFactory;


    protected $fillable = [
        'menuBanner',
        'menuName',
        'menuPrice',
        'menuStock',
        'categoryID',
    ];

    public function categorys()
    {
        return $this->belongsTo(categoryMenu::class, 'categoryID', 'id');
    }
}
