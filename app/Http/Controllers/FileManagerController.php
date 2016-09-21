<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Hash;
use Storage;
use ZipArchive;
use App\FileManager;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FileManagerController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth', ['except' => ['getDownload', 'postDownload', 'download']]);
		$this->middleware('dof');
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = FileManager::whereUserId(auth()->user()->id)->paginate(10);
        return view('fm.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = new FileManager;
        return view('fm.create', compact('data'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // エラーチェック
        $validator = Validator::make($data = $request->all(), FileManager::$rules);
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
        
        // 検証用ファイルアップロード
        $file = $request->file('file');
        $dir_path = 'tmp/' . auth()->user()->id;
        $tmp_path = $dir_path . '/' . str_random(16) . '.' . $file->getClientOriginalExtension();
        Storage::put($tmp_path, file_get_contents($file->getRealPath()));
        
        // パスワード付きか判定
        if ($this->checkZipPassword($tmp_path) == false) {
            File::deleteDirectory(storage_path('app/') . $dir_path, true);
            return back()->withInput($request->all())->withErrors(['file' => trans('validation.zip_without_password')]);
        }
        
        // ファイルを移動して検証用を削除
        $file_path = str_replace('tmp/', 'files/', $tmp_path);
        Storage::move($tmp_path, $file_path);
        File::deleteDirectory(storage_path('app/') . $dir_path, true);
        
        // データ作成、登録
        $data['user_id'] = auth()->user()->id;
        $data['file_path'] = $file_path;
        $data['token'] = str_random(32);
        $data['password'] = bcrypt($data['password']);
        $fm = FileManager::create($data);
        
        // アップロード失敗
        if (!$fm) {
            File::delete($file_path);
            return back()->withInput($request->all())->withErrors(['file' => trans('messages.file_upload_error')]);
        }
        
        // 確認ページヘリダイレクト
        Session::flash('message', Lang::get('messages.file_upload_success'));
        return redirect('fm/show/' . $fm->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = FileManager::whereUserId(auth()->user()->id)->find($id);
        return view('fm.show', compact('data'));
    }

    /**
     * Download the file.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function getDownload($token)
    {
        $data = FileManager::whereToken($token)->first();
        return view('fm.download', compact('data'));
    }
    
    /**
     * Download the file.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function postDownload(Request $request)
    {
        // データ取得
        $data = FileManager::whereToken($request->token)->first();
        
        // データとパスワードチェック
        if ($data && Hash::check($request->password, $data->password)) {
            // ダウンロード成功
            Session::put('download_data', $request->all());
            Session::flash('message', Lang::get('messages.file_download_success'));
            Session::flash('download', '/download');
            return view('fm.download', compact('data'));
        }
        
        // 失敗したらリダイレクト
        return back()->withInput($request->all())->withErrors(['download' => trans('messages.file_download_error')]);
    }

    /**
     * Download the file.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function download()
    {
        // データ取得
        $request = Session::get('download_data');
        Session::forget('download_data');
        $data = FileManager::whereToken($request['token'])->first();
        
        // ダウンロード失敗
        if (!$data) {
            return back()->withErrors(['download' => trans('messages.file_download_error')]);
        }
        
        // ダウンロード成功
        $headers = ['Content-Type' => 'application/zip'];
        return response()->download(storage_path('app/') . $data->file_path, 'dl_' . date('YmdHis') . '.zip', $headers);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = FileManager::whereUserId(auth()->user()->id)->find($id);
        if ($data) {
            File::delete(storage_path('app/') . $data->file_path);
            $data->delete();
        }
        return redirect('fm');
    }
    
    /**
     * Check the zip file with password.
     *
     * @param  int  $file_path
     * @return bool true or false
     */
    public function checkZipPassword($file_path)
    {
        $check = true;
        
        // 通常展開する
        $zip_path = storage_path('app/') . $file_path;
        $zip = new ZipArchive();
        $ret = $zip->open($zip_path);
        if ($ret === true) {
            // 展開できてしまったらアウト
            if ($zip->extractTo(storage_path('app/tmp/') . auth()->user()->id)) {
                $check = false;
            }
        } else {
            $check = false;
        }
        $zip->close();
        
        // ダメなら消す
        if ($check == false) {
            File::delete($zip_path);
        }
        return $check;
    }
}
