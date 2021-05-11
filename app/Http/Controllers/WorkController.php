<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function get(Request $rec)
    {
    	dd($rec->input('subject'));
    	dd($rec);
		return "ok";
    }
}
