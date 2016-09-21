<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Weather;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller
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
        return view('weather.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lat, $lng)
    {
        // 1時間単位で取得
        $datas = Weather::get('hourly', $lat, $lng);
        $hourly = $datas['hourly_forecast'];
        
        // 10日単位で取得
        $datas = Weather::get('forecast10day', $lat, $lng);
        $weekly = $datas['forecast']['txt_forecast']['forecastday'];
        
        if (count($hourly) > 0 && count($weekly) > 0) {
            // グラフ用データ作成
            foreach ($hourly as $hour) {
                $ary_date[] = $hour['FCTTIME']['mday'] . '日 ' . $hour['FCTTIME']['hour'] . '時';
                $ary_temp[] = $hour['temp']['metric'];
                $ary_pop[]  = $hour['pop'];
            }
            $chart['date'] = implode('","', $ary_date);
            $chart['temp'] = implode('","', $ary_temp);
            $chart['pop']  = implode('","', $ary_pop);
            // 表示
            return view('weather.show', compact('hourly', 'weekly', 'chart'));
        } else {
            // 取得できなかった場合
            Session::flash('message', Lang::get('messages.weather_error'));
            return redirect('weather');
        }
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
    public function update(Request $request, $id)
    {
        //
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
}
