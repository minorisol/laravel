<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PasswordManager;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PasswordManagerController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = PasswordManager::whereUserId(auth()->user()->id)->paginate(10);
        return view('pm.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = new PasswordManager;
        return view('pm.edit', compact('data'));
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
        $validator = Validator::make($data = $request->all(), PasswordManager::$rules);
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
        
        // データ登録
        $data['user_id'] = auth()->user()->id;
        PasswordManager::create($data);

        return redirect('pm');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = PasswordManager::whereUserId(auth()->user()->id)->find($id);
        return view('pm.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PasswordManager::whereUserId(auth()->user()->id)->find($id);
        return view('pm.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // エラーチェック
        $validator = Validator::make($data = $request->all(), PasswordManager::$rules);
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
        
        // ユーザーチェック
        $pm = PasswordManager::whereUserId(auth()->user()->id)->find($data['id']);
        if (!$pm) {
            Session::flash('message', Lang::get('messages.failed'));
            return redirect('pm');
        }
        
        // データ登録
        $pm->fill($data);
        $pm->save();

        return redirect('pm');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = PasswordManager::whereUserId(auth()->user()->id)->find($id);
        if ($data) {
            $data->delete();
        }
        return redirect('pm');
    }
}
