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

Route::get('/{any}', 'SpaController@index')->where('any', '.*');

// Route::get('test', function () {
//     $collection = collect([
//         [ 'name' => 'esdwin' ],
//         [ 'name' => 'edwin' ],
//         [ 'name' => 'edwin' ]
//     ]);

//     // return $collection;
//     $filtered = $collection->filter(function ($value, $key) {
//         return $value['name'] == 'edwin';
//     })->all();

//     foreach ($filtered as $key => $value) {
//         echo $value['name'];
//     }
    
// });