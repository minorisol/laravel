<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatGroup extends Model
{
    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'chat_group';

    /**
     * 書き換え可能なカラム設定
     *
     * @var array
     */
    protected $fillable = [
        'chat_id',
        'user_id',
    ];
    
    /**
     * リレーション
     *
     * @var Model
     */
    public function User()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    
    public function Chat()
    {
        return $this->belongsTo('App\Chat', 'id', 'chat_id');
    }
}
