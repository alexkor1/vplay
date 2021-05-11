<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
	if (Auth::check())
	{
		$devnum = DB::table('device')->where('userid', Auth::id())->get();
//		dd($devnum);
		return view('work', compact('devnum'));
	}
	else
		return view('home');

});


Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');


Route::post('/web', function (Request $request) 
{
	$dev = DB::table('device')->where('number', $request->input('dev'))->get();
	DB::table('ring')->insert(['devid' => $dev[0]->id, 'url' => $request->input('url')]);
	return "ok".$dev[0]->id.$request->input('url');
});

Route::post('/getring', function (Request $request) 
{
	$dev = DB::table('device')->where('number', $request->input('dev'))->get();
	$ring = DB::table('ring')->where('devid', $dev[0]->id)->get();
	return json_encode($ring);
});

Route::post('/delring', function (Request $request) 
{
	$ring = DB::table('ring')->where('id', $request->input('id'))->get();
	$dev = DB::table('device')->where('id', $ring[0]->devid)->get();
	if ($dev[0]->id == Auth::id())
		DB::table('ring')->where('id', $request->input('id'))->delete();
	return "ok";
});


Route::post('/getupload', function (Request $request) 
{
	$dev = DB::table('device')->where('number', $request->input('dev'))->get();
	$upload = DB::table('upload')->where('devid', $dev[0]->id)->get();
	return json_encode($upload);
});


Route::post('/delupload', function (Request $request) 
{
	$upload = DB::table('upload')->where('id', $request->input('id'))->first();
	$dev = DB::table('device')->where('id', $upload->devid)->first();
	if ($dev->userid == Auth::id())
	{
		$tul = DB::table('upload')->where('id', $request->input('id'))->first();
		DB::table('upload')->where('id', $request->input('id'))->update(['status' => !$tul->status]);
	}
	return "ok";
});

//debug


Route::get('/db/{id}', function ($id) {
//	$data = DB::table('ring')->find($id);
	printf("%s\n", $id);
	dd($data);
	return "ok";//view('work', compact('data'));

	$users = DB::select('select * from users');
	foreach ($users as $user) {
	    echo $user->name;
	}
});

Route::get('/users', function () {
	$data = DB::table('users')->get();
	dd($data);
});

Route::get('/device', function () {
	$data = DB::table('device')->get();
	dd($data);
});

Route::get('/ring', function () {
	$data = DB::table('ring')->get();
	dd($data);
});

Route::get('/upload', function () {
	$data = DB::table('upload')->get();
	dd($data);
});

