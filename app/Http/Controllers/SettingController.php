<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Push;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
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
     * 設定画面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * 通知状態のチェック
     *
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        $msg = 'faild';
        
        // エラーチェック
        $validator = Validator::make($data = $request->all(), Push::$rules);
        if ($validator->fails()) {
            return response()->json(['msg'=> 'faild']);
        }
        
        // 登録確認
        if (strlen($data['subscriber']) > 0) {
            $push = Push::whereUserId(auth()->user()->id)->whereSubscriber($data['subscriber'])->first();
            if (!$push) {
                // データ作成
                $data['user_id'] = auth()->user()->id;
                // 登録確認
                if (Push::create($data)) {
                    $msg = 'success';
                }
            } else {
                $msg = 'checked';
            }
        }
        return response()->json(['msg'=> $msg]);
    }

    /**
     * プッシュ通知登録
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $msg = 'faild';
        
        // エラーチェック
        $validator = Validator::make($data = $request->all(), Push::$rules);
        if ($validator->fails()) {
            return response()->json(['msg'=> 'faild']);
        }
        
        // 登録済み確認
        $push = Push::whereUserId(auth()->user()->id)->whereSubscriber($data['subscriber'])->first();
        if (!$push) {
            // データ作成
            $data['user_id'] = auth()->user()->id;
            // 登録確認
            if (Push::create($data)) {
                $msg = 'succsess';
            }
        } else {
            $msg = 'checked';
        }
        return response()->json(['msg'=> $msg]);
    }

    /**
     * プッシュ通知解除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = Push::whereUserId(auth()->user()->id)->whereSubscriber($request->subscriber)->first();
        if ($data) {
            $data->delete();
            return response()->json(['msg'=> 'success']);
        }
        return response()->json(['msg'=> 'faild']);
    }
}
