<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];
    
    // このカテゴリーに属する備品（1）(Equipmentモデルとの関係を定義)
    public function equipment(){
        return $this->hasMany(Equipment::class);
    }
}
