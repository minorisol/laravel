<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'profile';

    /**
     * 書き換え可能なカラム設定
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'avatar',
        'message',
        'tel',
        'zip',
        'address',
        'lat',
        'lon',
        'token',
    ];

    /**
     * 隠しカラムの設定
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
        'token',
    ];
    
    /**
     * エラーチェック
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:255',
        'avatar' => 'max:255',
        'message' => 'max:255',
        'tel' => 'alpha_dash|max:16',
        'zip' => 'alpha_dash|max:12',
        'address' => 'max:255',
        'lat' => 'numeric|max:255',
        'lon' => 'numeric|max:255',
    ];
    
    public static $rules_photo = [
        'photo' => 'required|image|max:5000'
    ];
    
    /**
     * リレーション
     *
     * @var Model
     */
    public function User()
    {
        return $this->belongsTo('App\User', 'id', 'user_id');
    }
}
