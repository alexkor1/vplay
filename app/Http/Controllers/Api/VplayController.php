<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use DB;

//use Validator;

class VplayController extends Controller
{
	//test
	public function get(Request $request){
		try {$user = auth()->userOrFail();} 
		catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
			return response()->json(['error' => true, 'message' => $e->getMessage()], 401);}
		$creds = $request->only(['email','password']);
		return response()->json($request);
		return response()->json($creds);
	}

	//ring get
	public function getring(Request $request){
		try {$user = auth()->userOrFail();}
		catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
			return response()->json(['error' => true, 'message' => $e->getMessage()], 401);}
		$user = auth()->user();
		$dev = DB::table('device')->where('number', $user->email)->first();
		$ring = DB::table('ring')->where('devid', $dev->id)->get();
		foreach ($ring as $elem)
			if ($elem->status != 101)
				return response()->json(['id' => $elem->id,'url' => $elem->url]);
		return response()->json();
	}

	//ring set
	public function setring(Request $request){
		try {$user = auth()->userOrFail();} 
		catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
			return response()->json(['error' => true, 'message' => $e->getMessage()], 401);}
		$user = auth()->user();
		$dev = DB::table('device')->where('number', $user->email)->first();
		$ring = DB::table('ring')->where('id', $request->input('id'))->first();
		if ($ring->devid == $dev->id)
			DB::table('ring')->where('id', $ring->id)->update(['status' => $request->input('status')]);
		return response()->json();
	}

	//ring delete
	public function delring(Request $request){
		try {$user = auth()->userOrFail();} 
		catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
			return response()->json(['error' => true, 'message' => $e->getMessage()], 401);}
		$user = auth()->user();
		$dev = DB::table('device')->where('number', $user->email)->first();
		$ring = DB::table('ring')->where('id', $request->input('id'))->first();
		if ($ring->devid == $dev->id)
			DB::table('ring')->where('id', $ring->id)->delete();
		return response()->json();
	}

	//upload add
	public function addupload(Request $request){
		try {$user = auth()->userOrFail();}
		catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
			return response()->json(['error' => true, 'message' => $e->getMessage()], 401);}
		$user = auth()->user();
		$dev = DB::table('device')->where('number', $user->email)->first();
		$id = DB::table('upload')->insertGetId(['devid' => $dev->id, 'url' => $request->input('url'), 'status' => 0]);
 		return response()->json(['id' => $id]);
	}

	//upload get
	public function getupload(Request $request){
		try {$user = auth()->userOrFail();}
		catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
			return response()->json(['error' => true, 'message' => $e->getMessage()], 401);}
		$user = auth()->user();
		$dev = DB::table('device')->where('number', $user->email)->first();
//		$id = DB::table('upload')->where('devid', $dev->id)->where('status', 1)->first()->value('id');
		$upload = DB::table('upload')->where('devid', $dev->id)->where('status', 1)->first();
		$upload = json_decode(json_encode($upload), true);
		unset($upload['devid']);
		unset($upload['url']);
		unset($upload['created_at']);
		unset($upload['updated_at']);
//		return response()->json(['id', $id]);
		return response()->json($upload);
	}

	//upload delete
	public function delupload(Request $request){
		try {$user = auth()->userOrFail();} 
		catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
			return response()->json(['error' => true, 'message' => $e->getMessage()], 401);}
		$user = auth()->user();
		$dev = DB::table('device')->where('number', $user->email)->first();
		$upload = DB::table('upload')->where('id', $request->input('id'))->first();
		if ($upload->devid == $dev->id)
			DB::table('upload')->where('id', $upload->id)->delete();
		return response()->json();
	}


}
