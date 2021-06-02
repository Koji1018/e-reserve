<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_group',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    // このユーザが予約中の備品(多対多)(Equipmentモデルとの関係を定義)
    public function reservations(){
        return $this->belongsToMany(Equipment::class, 'reservations', 'user_id', 'equipment_id');
    }
    
    // このユーザがチェックしているカテゴリー(多対多)(Categoryモデルとの関係を定義)
    public function category_checks(){
        return $this->belongsToMany(Category::class, 'category_user', 'user_id', 'category_id');
    }
}