<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileManager extends Model
{
    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'file_manager';

    /**
     * 書き換え可能なカラム設定
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'file_path',
        'token',
        'password',
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
        'file' => 'required|mimes:zip|max:100000',
        'title' => 'required|max:255',
        'password' => 'required|min:6|max:255',
    ];
}
