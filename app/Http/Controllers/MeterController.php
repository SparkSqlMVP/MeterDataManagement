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
        $MeterData = DB::table('gasdevice_model750_rundata')->get();
        return  $MeterData;
    }
}
