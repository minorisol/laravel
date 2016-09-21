<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, SoftDeletes;

    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * 書き換え可能なカラム設定
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * 隠しカラムの設定
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'confirmed_at',
    ];
    
    /**
     * 日付により変更を起こすべき属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * エラーチェック
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|confirmed|min:6',
    ];
    
    /*
    public static $rules_update = [
        'name' => 'required|alpha_num|max:255',
        'email' => 'required|email|max:255',
    ];
    */
    
    /**
     * リレーション
     *
     * @var Model
     */
    public function Confirm()
    {
        return $this->hasOne('App\Confirm', 'email', 'email');
    }
    
    public function Profile()
    {
        return $this->hasOne('App\Profile', 'user_id', 'id');
    }
    
    public function Friend()
    {
        return $this->belongsTo('App\Friend', 'friend_id', 'id');
    }
    
    public function Push()
    {
        return $this->hasMany('App\Push', 'user_id', 'id');
    }
}
