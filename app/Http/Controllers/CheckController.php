<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    	$keyword = $doc->createElement("keyword");
    	$foo->appendChild($keyword);
 		
    	if($request->txtCategory == ''){

    		//<span class='col-md-4 col-md-offset-4' style='color:red'>Vui lòng chọn chủ đề</span>
           $messages->appendChild($doc->createTextNode("1"));
           echo $doc->saveHTML($doc->documentElement);
	       return;
        }

        if(Input::hasFile('file')) {
        	$file = Input::file('file');
        	$extension = $file->getClientOriginalExtension(); 

        	$fileSize = round($file->getSize()/1024, 1) . " KB";
	        if($extension !== 'docx') {
	        	if($extension !== 'doc') {
	        		$messages->appendChild($doc->createTextNode("2"));
	        		echo $doc->saveHTML($doc->documentElement);
	        		return;
	        	}
	        }

	        $fileInfo = new FileInfo();
	        $fileInfo->setFileName($file->getClientOriginalName());
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
	        $keyword->appendChild($doc->createTextNode(change($request->txtCategory)));
	        echo $doc->saveHTML($doc->documentElement);
	        return;

        } else {
	        $messages->appendChild($doc->createTextNode("3"));
	        echo $doc->saveHTML($doc->documentElement);
	        return;
        }
    }

    public function ajaxRead(Request $request) {
       $xml = new ConvertXml($request->keyword, $request->fileName);
        $xml->writerKeyWord();

    }

    public function ajaxRead1(Request $request) {
        $p = $this->kmp_compute_prefix("abc");
        var_dump($p);
    }


    function kmp_compute_prefix($P) {
        $m = strlen($P);
        $pi = array();
        $pi[1] = 0;
        $k = 0;
        for ($q = 1; $q < $m; $q++) {
            while ($k > 0 && $P[$k] != $P[$q]) {
                $k = $pi[$k];
            }
            if ($P[$k] == $P[$q]) {
                $k++;
            }
            $pi[$q+1] = $k;
        }
        return $pi;
    }
    function kmp_search_prefix($T, KMPPrefix $prefix)
    {
        $matches = array();
        $P = $prefix->getStr();
        $m = $prefix->getLen();
        $pi = $prefix->getP();
        $n = strlen($T);
        $q = 0;
        $l = 0;
        for ($i = 0; $i < $n; $i++) {
            while ($q > 0 && $P[$q] != $T[$i]) {
                $q = $pi[$q];
            }
            if ($P[$q] == $T[$i]) {
                $q = $q + 1;
            }
            if ($q == $m) {
                $matches[] = $i - $m + 1;
                $l = $i;
                $q = $pi[$q];
            }
        }
        return $matches;
    }

    /**
     * @param $T
     * @param $P
     * @return array
     */
    function kmp_search($T, $P) {
        $prefix = new KMPPrefix();
        $prefix->setP($this->kmp_compute_prefix($P));
        $prefix->setStr($P);
        $prefix->setLen(strlen($P));
        return $this->kmp_search_prefix($T, $prefix);
    }
}
