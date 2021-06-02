<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];
    
    // このカテゴリーに属する備品（1）(Equipmentモデルとの関係を定義)
    public function equipments(){
        return $this->hasMany(Equipment::class);
    }
    
    // このカテゴリーに関係するモデルの件数をロードする。
    public function loadRelationshipCounts(){
        $this->loadCount(['equipments',]);
    }
}
