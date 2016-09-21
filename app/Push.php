<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Push extends Model
{
    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'push';

    /**
     * 書き換え可能なカラム設定
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'subscriber',
    ];

    /**
     * 隠しカラムの設定
     *
     * @var array
     */
    protected $hidden = [];
    
    /**
     * エラーチェック
     *
     * @var array
     */
    public static $rules = [
        'subscriber' => 'required|alpha_num|max:255'
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
    
    /**
     * プッシュ通知送信
     *
     * @var array
     */
    public static function sendPush($user_ids, $title, $message, $url)
    {
        // ユーザ取得
        foreach($user_ids as $user_id) {
            $user = User::find($user_id);
            if ($user) {
                // プッシュ設定取得
                $pushes = $user->push;
                if ($pushes) {
                    // プッシュ通知リスト作成
                    $subscriberList = Array();
                    foreach ($pushes as $push) {
                        $subscriberList[] = $push['subscriber'];
                    }
                    $subscriberListArray = Array();
                    $subscriberListArray['subscriber_list'] = $subscriberList;
                    
                    // jsonエンコード
                    $subscriberListJsonString = json_encode($subscriberListArray);
                    
                    // APIのURL
                    $curlUrl = 'https://pushcrew.com/api/v1/send/list';
                    
                    // 通知をセット
                    $fields = array(
                        'title' => $title,
                        'message' => $message,
                        'url' => $url,
                        'subscriber_list' => $subscriberListJsonString
                    );
                    
                    // ヘッダをセット
                    $httpHeadersArray = Array();
                    $httpHeadersArray[] = 'Authorization: key='.env('API_PUSH');
                
                    // 通知開始
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $curlUrl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeadersArray);
                
                    // 結果を取得してjsonデコード
                    $result = curl_exec($ch);
                    $resultArray[] = json_decode($result, true);
                } else {
                    $resultArray[]['status'] = 'failure';
                }
            } else {
                $resultArray[]['status'] = 'failure';
            }
        }
        
        /* 
        if ($resultArray['status'] == 'success') {
            //success
            //echo $resultArray['request_id']; //ID of Notification Request
        } else if($resultArray['status'] == 'failure') {
            //failure
        } else {
            //failure
        }
         */
    
        return $resultArray;
    }

}
