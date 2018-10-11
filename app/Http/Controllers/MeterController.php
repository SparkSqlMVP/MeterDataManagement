<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Meter;
use App\Http\Resources\Meter as MeterResource;

class MeterController extends Controller
{
    //
    public function Index()
    {
        # code...
        $data = DB::table('gasdevice_model750_rundata')
               // ->orderBy('id', 'desc')
                ->get();
        return view('meter/index')->withData($data);
    }
}
