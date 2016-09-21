<?php

namespace App\Http\Middleware;

use Closure;

use File;
use Storage;
use App\FileManager;

class DeleteOldFiles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $datas = FileManager::get();
        if($datas)
        {
            foreach($datas as $data)
            {
                $now = date('YmdHis');
                $next_week = date("YmdHis", strtotime("+1 week" ,strtotime($data->created_at)));
                if($next_week < $now)
                {
                    FileManager::destroy($data->id);
                    File::delete(storage_path('app/') . $data->file_path);
                }
            }
        }
        return $next($request);
    }
}
