<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';
    
    protected $fillable = [
        'name', 'category_id', 'status', 
    ];
    
    // この備品のカテゴリー（多）(Categoryモデルとの関係を定義)
    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    // この備品を予約中のユーザ(多対多)(Userモデルとの関係を定義)
    public function reserve_users(){
        return $this->belongsToMany(User::class, 'reservations', 'equipment_id', 'user_id')->withTimestamps();
    }
    
    // このカテゴリーに関係するモデルの件数をロードする。
    public function loadRelationshipCounts(){
        $this->loadCount(['reserve_users',]);
    }
}
