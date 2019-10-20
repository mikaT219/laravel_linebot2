<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    //debugbar
    public function __construct()
       {

   //        キャッシュが残るので 毎回 view ファイルを削除する
           $success = \File::cleanDirectory(storage_path()."/framework/views/");

           if(\Request::ip() == "124.222.4224.121"){

               //デバッグモード

           } else {
               \Debugbar::disable();
           }


       }


}
