<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Friend;
use App\Profile;
use App\Push;
use App\SendMail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FriendController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	
    /**
     * フレンド一覧
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Friend::whereUserId(auth()->user()->id)->with('User')->paginate(10);
        return view('friend.index', compact('datas'));
    }

    /**
     * フレンド招待
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function invite(Request $request)
    {
        // 送信データセット
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $data['name'] = auth()->user()->name;
        $data['token'] = auth()->user()->profile->token;
        
        // エラーチェック
        $validator = Validator::make($data, Friend::$rules);
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        // 招待メール送信
        SendMail::sendTo(Lang::get('messages.send_invite'), 'emails.invite', $data);
        Session::flash('message', Lang::get('messages.send_invite_mail'));

        return redirect('friend');
    }

    /**
     * フレンド登録認証
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm($token)
    {
        $message = '';
        // ユーザデータ取得
        $user = Profile::whereToken($token)->first();
        
        // ユーザの存在確認
        if ($user) {
            
            // データ取得
            $data['user_id'] = auth()->user()->id;
            $data['friend_id'] = $user->user_id;
            $friend = Friend::whereUserId($data['user_id'])->whereFriendId($data['friend_id'])->first();
            
            // 登録済みかチェック
            if (!$friend && $data['user_id'] != $data['friend_id']) {
                
                // フレンド登録
                $data['confirmed_at'] = Carbon::now();
                Friend::create($data);
                
                // 相手も登録
                $data['user_id'] = $user->user_id;
                $data['friend_id'] = auth()->user()->id;
                Friend::create($data);
                
                // 完了メッセージ
                $message = Lang::get('messages.friend_success');
                Push::sendPush([$user->user_id], Lang::get('messages.friend_push_title'), Lang::get('messages.friend_push_message'), url('friend'));
            } else {
                // 既に当特済み
                $message = Lang::get('messages.friend_already_error');
            }
        } else {
            // ユーザが存在しない
            $message = Lang::get('messages.friend_notfind_error');
        }
        Session::flash('message', $message);
        return redirect('friend');
    }

    /**
     * フレンド解除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Friend::find($id);
        if ($data) {
            Friend::whereUserId($data->user_id)->whereFriendId($data->friend_id)->delete();
            Friend::whereUserId($data->friend_id)->whereFriendId($data->user_id)->delete();
        }
        return redirect('friend');
    }
}
