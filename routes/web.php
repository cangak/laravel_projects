<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

 //home
Route::get('/', function() {
	return view('welcome');
});

//about
Route::get('/about','PagesController@about');

//navbar
Route::get('/contact','PagesController@contact');

//weeekly timetable
Route::get('/weekly','PagesController@weekly');


//church details
Route::get('/churchdet','PagesController@churchdet');


//
Auth::routes();

//for registrations
Route::get('users/register', 'Auth\RegisterController@showRegistrationForm');

Route::post('users/register', 'Auth\RegisterController@register');

//for login
Route::get('users/login', 'Auth\LoginController@showLoginForm');

Route::post('users/login', 'Auth\LoginController@login');

Route::get('home', 'HomeController@index');

Route::get('email-verification/error', 'Auth\RegisterController@getVerificationError')->name('email-verification.error');
Route::get('email-verification/check/{token}', 'Auth\RegisterController@getVerification')->name('email-verification.check');

Route::resource('churches', 'ChurchController');

Route::resource('regions', 'RegionController');

Route::resource('districts', 'DistrictController');

Route::resource('categories', 'CategoryController');

Route::get('events', 'EventController@index');
Route::get('events/{id}/{slug}', 'EventController@show');
Route::post('events', 'EventController@store');

Route::get('account/profile', 'UserController@show');

Route::get('new', 'ChurchController@new');
Route::post('new', 'ChurchController@nameStore');

Route::get('church/region', 'ChurchController@region');
Route::post('church/region', 'ChurchController@regionStore');

Route::get('church/district', 'ChurchController@district');
Route::post('church/district', 'ChurchController@districtStore');

Route::get('church/about', 'ChurchController@about');
Route::post('church/about', 'ChurchController@aboutStore');

Route::get('church/contact', 'ChurchController@contact');
Route::post('church/contact', 'ChurchController@contactStore');

Route::get('church/category', 'ChurchController@category');
Route::post('church/category', 'ChurchController@categoryStore');

Route::get('church/address', 'ChurchController@address');
Route::post('church/address', 'ChurchController@addressStore');

Route::get('church/other-name', 'ChurchController@otherName');
Route::post('church/other-name', 'ChurchController@otherNameStore');

Route::resource('periods', 'PeriodController');

Route::resource('phones', 'PhoneController');

Route::resource('emails', 'EmailController');

Route::get('/maps', function() {
	$church = App\Church::find(41);
	$center_lat = $church->lat;
	$center_lng = $church->lng;
	$radius = '';

	// Start XML file, create parent node
	$dom = new DOMDocument("1.0");
	$node = $dom->createElement("markers");
	$parnode = $dom->appendChild($node);
	

	$query = sprintf("SELECT address, name, lat, lng, ( 3959 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM churches/* HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20*/",
	  $center_lat,
	  $center_lng,
	  $center_lat,
	  $radius);
	$results = DB::select($query);
	
	header("Content-type: text/xml");
	
	// Iterate through the rows, adding XML nodes for each
	$i = 0;
	while($i < count($results))
	{
		$node = $dom->createElement("marker");
		$newnode = $parnode->appendChild($node);
		$newnode->setAttribute("name", $results[0]->name);
		$newnode->setAttribute("address", $results[0]->address);
		$newnode->setAttribute("lat", $results[0]->lat);
		$newnode->setAttribute("lng", $results[0]->lng);
		$newnode->setAttribute("distance", $results[0]->distance);
		$i++;
	}

	echo $dom->saveXML();

});