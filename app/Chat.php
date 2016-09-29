<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'chat';

    /**
     * 書き換え可能なカラム設定
     *
     * @var array
     */
    protected $fillable = [
        'subscriber',
    ];
    
    /**
     * リレーション
     *
     * @var Model
     */
    public function ChatGroup()
    {
        return $this->hasMany('App\ChatGroup', 'chat_id', 'id');
    }
    
    public function ChatMessage()
    {
        return $this->hasMany('App\ChatMessage', 'chat_id', 'id');
    }
}
