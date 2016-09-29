<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Chat;
use App\ChatGroup;
use App\ChatMessage;
use App\Friend;
use App\Profile;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ChatController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
		$this->chat = new Chat;
	}
	
    /**
     * チャット画面表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Chat $chat)
    {
        $groups = $chat->ChatGroup()->whereUserId(auth()->user()->id)->with('User')->paginate(10);
        $friends = Friend::whereUserId(auth()->user()->id)->with('User')->paginate(10);
        return view('chat.index', compact('groups', 'friends'));
    }
    
    /**
     * グループ作成
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // データ取得
        $input = $request->only('user_id');
        $ids = $input['user_id'];
        if (count($ids) > 0) {
            // フレンド判定
            if ($this->isFriend($ids)) {
                // 自分を含めてグループ検索
                $ids[] = auth()->user()->id;
                $chat = $this->isGroup($ids);
                // グループ存在確認
                if (!$chat) {
                    // マスタ作成
                    $data['subscriber'] = Str::random(32);
                    $chat = Chat::create($data);
                    $data['chat_id'] = $chat->id;
                    // グループ作成
                    foreach ($ids as $id) {
                        $data['user_id'] = $id;
                        ChatGroup::create($data);
                    }
                }
            } else {
                return back()->withInput($request->only('user_id'))->withErrors(['user_id' => trans('messages.chat_group_error')]);
            }
        } else {
            return back();
        }
        return redirect('/chat/show/' . $chat->subscriber);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $message = new ChatMessage;
            $message->user_id = auth()->user()->id;
            $message->message = $data["message"];
            $message->save();
            
            pusher()->trigger('test_channel', 'my_event', ['message' => 'hello world']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("chat.show", compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $chat = Chat::whereSubscriber($id)->first();
        return response()->json($chat->ChatMessage()->orderBy("created_at", "DESC")->take(5)->get());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    /**
     * 登録済みのフレンドかチェック
     *
     * @param  array  $ids
     * @return \Illuminate\Http\Response
     */
    public function isFriend($ids)
    {
        $bool = true;
        foreach ($ids as $id) {
            $friend = Friend::whereUserId(auth()->user()->id)->whereFriendId($id)->first();
            if (!$friend) {
                $bool = false;
                break;
            }
        }
        return $bool;
    }
    
    /**
     * 作成済みのグループかチェック
     *
     * @param  array  $ids
     * @return \Illuminate\Http\Response
     */
    public function isGroup($ids)
    {
        $group = $this->chat->ChatGroup()->whereIn('user_id', $ids)->get();
        if (count($ids) == count($group)) {
            $res = $group;
        } else {
            $res = false;
        }
        return $res;
    }
}
