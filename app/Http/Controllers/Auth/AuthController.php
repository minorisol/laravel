<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\User;
use App\Confirm;
use App\SendMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    
    protected $redirectTo = '/home';
    protected $redirectAfterLogout = 'auth/login';
    
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->middleware('confirm', ['only' => 'postLogin']);
    }
    
    /**
     * ユーザ登録（オーバーライド）
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        // エラーチェック
        $validator = Validator::make($data = $request->all(), User::$rules);
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
        
        // ユーザ登録
        $data['password'] = bcrypt($data['password']);
        $data['role'] = 'user';
        $user = User::create($data);
        
        // 認証用のトークン生成
        $user->token = Str::random(32);
        $user->Confirm()->create(['token' => $user->token]);
        
        // メール送信
        SendMail::sendTo(Lang::get('auth.send_confirm'), 'emails.confirm', $user->toArray());
        Session::flash('message', Lang::get('auth.send_confirm_mail'));
        return redirect('auth/login');
    }
    
    /**
     * ユーザー認証処理
     *
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getConfirm($token)
    {
        // エラーチェック
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }
        
        // トークンチェック
        $confirm = Confirm::whereToken($token)->first();
        if (!$confirm) {
            Session::flash('message', Lang::get('auth.token_failed'));
            return redirect('auth/login');
        }

        // ユーザーチェック
        $user = $confirm->User;
        if (!$user) {
            Session::flash('message', Lang::get('auth.not_exists_user'));
            return redirect('auth/login');
        }
        
        // 認証登録
        $user->Confirm()->delete();
        $user->confirmed_at = Carbon::now();
        $user->save();
        
        // プロフィール登録
        $user->Profile()->create(['user_id' => $user->id, 'token' => Str::random(32)]);
        
        Session::flash('message', Lang::get('auth.register_complete'));
        return redirect('auth/login');
    }


    /**
     * 確認メール再送画面を表示する
     *
     * @return \Illuminate\View\View
     */
    public function getResend()
    {
        return view('auth.resend');
    }
    
    /**
     * 確認メールの再送信する
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postResend(Request $request)
    {
        // エラーチェック
        $validator = Validator::make($request->all(), ['email' => 'required|email']);
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
        
        // 存在確認
        $confirm = Confirm::whereEmail($request->input('email'))->first();
        if (!$confirm) {
            return back()->withInput($request->only('email'))->withErrors(['email' => trans('passwords.user')]);
        }
        
        // メール送信
        $confirm->name = $confirm->User->name;
        SendMail::sendTo(Lang::get('auth.resend_confirm'), 'emails.confirm', $confirm->toArray());
        Session::flash('message', Lang::get('auth.resend_confirm_mail'));
        return redirect()->guest('auth/login');
    }
    
}
