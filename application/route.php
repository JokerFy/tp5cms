<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

Route::post('api/:version/token/app', 'api/:version.Token/getAppToken');

//Image
Route::post('api/:version/image/toupload', 'api/:version.Image/upload');
Route::post('api/:version/image/kindupload', 'api/:version.Image/kindupload');

