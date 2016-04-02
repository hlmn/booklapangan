<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('test', function () {
$data=[];
Mail::send('babi', $data ,function ($m) {
           $m->from('no-reply@booklapangan.com', 'Your Application');

           $m->to('aufarr@gmail.com', 'hlmn')->subject('test!');
        });

$to      = 'hlmn.hg@gmail.com';

	return view('babi');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

//http://localhost/cari?kota=dsfsdf&tgl=03-10-2016&jam=fdsfsd&lapangan=Futsal



/*Route::get('test', function()
{
	$jenis=App\jenislap::get();

	//return view('index',['jenis' => $jenis]);
	foreach ($jenis as $jeniss){
		echo $jeniss->NAMA_JENIS_LAP;
		echo '<br>';
	}
});*/



Route::get('/cari', 'FindController@CariFasor');
Route::get('/', 'FindController@Index');
Route::get('/showlap/{id_fasor}/{tgl}/{start}/{end}', 'FindController@ShowLap');


Route::group(['middleware' => ['web']], function () {
    //
});
