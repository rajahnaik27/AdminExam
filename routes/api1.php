<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/get',function(){
    return 'SHREE SWAMI SAMARTH';
});

Route::get('/test',function(){
    $data = [ '<p>SHREE SWAMI SAMARTH<br>
    DIGAMBERA DIGAMBERA SRIPAD VALLABH DIGAMBERA<br>
    AVDHOOTH CHINTAN SHREE GURUDEV DATTA </p>'];
     return response()->json($data);
});

Route::get('/Swami',function(){
    $data = [
        //'name' => 'Swami Samarth'
        'Swami Samarth'

    ];

    return response()->json($data);

});
