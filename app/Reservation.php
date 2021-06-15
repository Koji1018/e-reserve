<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id', 'equipment_id', 'lending_end', 'lending_end', 'status',
    ];
    
    // この予約に属するユーザー（多）(userモデルとの関係を定義)
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    // この予約に属する備品（多）(Equipmentモデルとの関係を定義)
    public function equipment(){
        return $this->belongsTo(Equipment::class);
    }
    
    // このカテゴリーに関係するモデルの件数をロードする。
    public function loadRelationshipCounts(){
        $this->loadCount(['user', 'equipment',]);
    }
}
