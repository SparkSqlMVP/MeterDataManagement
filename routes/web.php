<?php

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

use App\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/meter', 'MeterController@index');
Route::post('/editItem', function(Request $request){
    $rules = array (
            'Meter' => 'required'
    );
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails())
        return Response::json(array(             
            'errors' => $validator->getMessageBag()->toArray() 
        ));
    else {
         DB::table('gasdevice_model750_rundata')
            ->where('id',$request->id)
            ->update(['MeterValue' => $request->Meter]);

        $data = DB::select('select * from gasdevice_model750_rundata where id = :id', ['id' => $request->id]);
        return response()->json($data);
    }
});


Route::post('/deleteItem', function (Request $request) {
    DB::table('gasdevice_model750_rundata')->where('id', $request->id)->delete();
    return response()->json();
   } );