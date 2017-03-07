<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FileInfo;
use Input;

class CheckController extends Controller
{
    public function index() {
    	return view('home.check.index');
    }

    public function ajaxUpload(Request $request) {
    	$doc = new \DOMDocument('1.0', 'UTF-8');
    	$doc->version  = "1.0";
		$doc->encoding = "utf-8";

    	$foo = $doc->createElement("foo");
    	$doc->appendChild($foo);
    	$messages = $doc->createElement("messages");
    	$foo->appendChild($messages);

    	



    	$success = $doc->createElement("success");
    	$foo->appendChild($success);
 		
    	if($request->txtCategory == ''){

    		//<span class='col-md-4 col-md-offset-4' style='color:red'>Vui lòng chọn chủ đề</span>
           $messages->appendChild($doc->createTextNode("1"));
           echo $doc->saveHTML($doc->documentElement);
	       return;
        }

        if(Input::hasFile('file')) {
        	$file = Input::file('file');
        	$extension = $file->getClientOriginalExtension(); 
        	$fileName = $file->getClientOriginalName();
        	$fileSize = round($file->getSize()/1024, 1) . " KB";
	        if($extension !== 'docx') {
	        	$messages->appendChild($doc->createTextNode("2"));
	        	echo $doc->saveHTML($doc->documentElement);
	        	return;
	        }

	        $fileInfo = new FileInfo($request->file);
	        $fileInfo->setFileSize($fileSize);
	        $fileInfo->setFileType($extension);
	        

	        $dir = 'uploads/';
	        $name_upload = uniqid() . '_' . time() . '.' . $extension;
	        $file->move($dir, $name_upload);

	        $fileName = $doc->createElement("fileName");
	    	$messages->appendChild($fileName);
	    	$fileSize = $doc->createElement("fileSize");
	    	$messages->appendChild($fileSize);
	    	$fileType = $doc->createElement("fileType");
	    	$messages->appendChild($fileType);

			$fileName->appendChild($doc->createTextNode($fileInfo->getFileName()));
			$fileSize->appendChild($doc->createTextNode($fileInfo->getFileSize()));
			$fileType->appendChild($doc->createTextNode($fileInfo->getFileType()));


	        $success->appendChild($doc->createTextNode($name_upload));
	        echo $doc->saveHTML($doc->documentElement);
	        return;

        } else {
        	/*echo "<span class='col-md-4 col-md-offset-4' style='color:red'>Vui lòng chọn file</span>";
	        return;*/
	        $messages->appendChild($doc->createTextNode("3"));
	        echo $doc->saveHTML($doc->documentElement);
	        return;
        }
    }

    public function ajaxRead(Request $request) {
    	$docObj = new Convert("uploads/" .$request->fileName);
		$txt = $docObj->convertToText();
		$pieces = explode('</w:r></w:p>', $txt);
		$striped_content = '';
		for($i = 0; $i < count($pieces); $i++) {
			$striped_content = $striped_content . '<br />' . strip_tags($pieces[$i]);
		} 
		echo $striped_content;
    } 
}
