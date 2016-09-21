<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

use App\User;
use App\Profile;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
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
     * 編集画面表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::find(auth()->user()->id);
        return view('profile.index', compact('data'));
    }

    /**
     * ユーザー情報を更新
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // エラーチェック
        $validator = Validator::make($data = $request->all(), Profile::$rules);
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
        
        // ユーザ登録確認
        $user = User::find(auth()->user()->id);
        
        // プロフィール登録
        if ($user) {
            $user->update(['name' => $data['name']]);
            $user->Profile()->update($request->except('name', 'photo', '_token'));
        } else {
            return back()->withInput($request->all())->withErrors(['message' => trans('messages.profile_upload_error')]);
        }
        Session::flash('message', Lang::get('messages.profile_upload_success'));
        return redirect('profile');
    }

    /**
     * ユーザーを削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $data = User::find(auth()->user()->id);
        $data->delete();
        return redirect('auth/logout');
    }
    
    /**
     * 画像ファイルをアップロード
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        // エラーチェック
        $validator = Validator::make($data = $request->all(), Profile::$rules);
        if ($validator->fails()) {
            return ['response' => 'error'];
        }
        
        // ファイルを保存
        $file = $request->file('photo');
        $dir_path = public_path('img/' . auth()->user()->id . '/');
        $file_name = str_random(16) . '.' . $file->getClientOriginalExtension();
        $request->file('photo')->move($dir_path, $file_name);
        
        return ['response' => true, 'img' => '/img/' . auth()->user()->id . '/' .$file_name];
    }

    /**
     * 画像のトリミング
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trim(Request $request)
    {
        // データ、ファイル情報取得
        $data = $request->all();
        $thumb = public_path(ltrim($data['thumb'], '/'));
        $path_parts = pathinfo($thumb);
        
        // 保存用と表示用パス
        $save_path = str_replace($path_parts['filename'], str_random(16), $thumb);
        $link_path = str_replace(public_path(), '', $save_path);
        
        // 画像加工
        $image = Image::make($thumb)
        ->crop(
            $data['width'],
            $data['height'],
            $data['x'],
            $data['y']
        )
        ->resize(128, 128)
        ->save($save_path);
        
        // 成功・失敗
        if ($image) {
            File::delete($thumb);
            return ['response' => true, 'img' => $link_path];
        } else {
            return ['response' => false];
        }
    }
    
    /**
     * 画像を削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
        $data = $request->all();
        $user = User::find(auth()->user()->id);
        if ($user) {
            File::delete(public_path(ltrim($data['avatar'], '/')));
            $user->update(['avatar' => '']);
            return ['response' => true];
        }
        return ['response' => false];
    }
}
