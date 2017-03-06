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

Route::get('/', function () {
    $docObj = new Doc2Txt("abc.docx");
	$txt = $docObj->convertToText();
	$pieces = explode('</w:r></w:p>', $txt);
	$striped_content = strip_tags($pieces[0]);
	echo $striped_content;
});
