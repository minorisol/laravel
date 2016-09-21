<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'friend';

    /**
     * 書き換え可能なカラム設定
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'friend_id',
        'email',
        'token',
        'confirmed_at',
    ];
    
    /**
     * エラーチェック
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required|integer|exists:users,id',
        'name' => 'required|max:255',
        'email' => 'required|email|max:255',
        'token' => 'required|alpha_num|size:32',
    ];
    
    /**
     * リレーション
     *
     * @var Model
     */
    public function User()
    {
        return $this->hasOne('App\User', 'id', 'friend_id');
    }
}
