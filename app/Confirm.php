<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Confirm extends Model
{
    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'confirm';

    /**
     * 書き換え可能なカラム設定
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'token',
    ];

    /**
     * リレーション
     *
     * @var Model
     */
    public function User()
    {
        return $this->belongsTo('App\User', 'email', 'email');
    }
}
