<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordManager extends Model
{
    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'password_manager';

    /**
     * 書き換え可能なカラム設定
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'account',
        'password',
        'url',
        'remark',
    ];

    /**
     * 隠しカラムの設定
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    
    /**
     * エラーチェック
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|max:255',
        'account' => 'max:255',
        'password' => 'max:255',
        'url' => 'url|max:255',
    ];
}
