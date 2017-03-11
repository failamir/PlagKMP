<?php

namespace App\Http\Controllers;

class ConvertXml
{
    private $fileKeyWord;
    private $fileName;

    private $dom;
    private $contentParam;


    public function __construct($fileKeyWord, $fileName)
    {
        $this->fileKeyWord = "sample/keywords/" . $fileKeyWord . ".txt";
        $this->fileName = $fileName;

        $this->dom = new \DOMDocument();
        $this->dom->version  = "1.0";
        $this->dom->encoding = "utf-8";


        $this->contentParam = $this->dom->createElement('context');
        $this->dom->appendChild($this->contentParam);



    }
    public function getContent() {
        $numberStr = 0;
        $str = "";
        $wordInfo = new Convert("uploads/" . $this->fileName);
        $result = $wordInfo->removeNode($wordInfo->convertToText(), 'instrText');
        $content = $wordInfo->removeNode($result, 'hyperlink');
        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);

        $pieces = explode(PHP_EOL, strip_tags($content));
        for($i =0 ; $i<count($pieces); $i++) {
            if(trim(strip_tags($pieces[$i])) !== ''){
                $str = $str .  trim( strip_tags($pieces[$i])) . PHP_EOL;
                $numberStr = $numberStr + str_word_count(trim(mb_strtolower(strip_tags($pieces[$i])))); // str_word_count: tong so tu co trong chuoi
            }
        }
        return mb_strtolower(html_entity_decode($str));
    }

    public function writerKeyWord() {
        $keywords = '';
        $file = fopen($this->fileKeyWord, "r") or die("Cannot open file");
        while(!feof($file)) {
            $keywords = $keywords . fgets($file);
        }
        fclose($file);

        $str = explode(PHP_EOL, $this->getContent());
        $keywords = explode(PHP_EOL, $keywords);

        foreach ($str as $value) {
            $param = $this->dom->createElement('para');
            $this->contentParam->appendChild($param);
            $key = $this->dom->createElement('keywords');
            $content = $this->dom->createElement('content');
            $param->appendChild($key);
            $param->appendChild($content);
            foreach ($keywords as $keyword) {
                 $value = str_replace(trim(html_entity_decode($keyword)), str_replace(" ", "_", trim(html_entity_decode($keyword))), $value);
            }
            $content->appendChild($this->dom->createTextNode($value));
        }


        echo $this->dom->saveXML($this->dom->documentElement);
     //   $this->dom->save('sample/keywords/sitemap.xml');
        /*$this->dom->save('sample/keywords/sitemap.xml');
        $xml=simplexml_load_file("sample/keywords/sitemap.xml");
        print_r($xml);*/

    }


}
