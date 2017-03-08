<?php

namespace App\Http\Controllers;

use PhpOffice\PhpWord\Element\ListItem;
use PhpOffice\PhpWord\Element\PreserveText;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Element\TextBreak;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\Title;
use PhpOffice\PhpWord\Element\TOC;
use PhpOffice\PhpWord\IOFactory;

class WordInfo
{
    private $path;
    private $numberTable;
    private $phpWord;
    private $sections;

    public function __construct($path)
    {
        $this->path = $path;
        $this->phpWord = IOFactory::load($this->path);
        $this->sections = $this->phpWord->getSections();
    }

    public function setNumberTable($numberTable) {
        $this->numberTable = $numberTable;
    }

    public function getNumberTable(){
        return $this->numberTable;
    }

    public function getTable() {
        $str = '';
        $number = 0;
        foreach ($this->sections as $section) {
            foreach ($section->getElements() as $el) {
                if ($el instanceof Table) {
                    $number++;
                    foreach ($el->getRows() as $row) {
                        foreach ($row->getCells() as $cell) {
                            foreach ($cell->getElements() as $cEl) {
                                if ($cEl instanceof Text) {
                                    $str = $str . $cEl->getText() . ' ';
                                } else if ($cEl instanceof TextRun) {
                                    if (count($cEl->getElements()) > 0 and $cEl->getElements()[0] instanceof Text) {
                                        $str = $str . $cEl->getElements()[0]->getText() . ' ';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $str;
    }

    public function getContentText() {
        $str = '';
        foreach ($this->sections as $section) {
            foreach ($section->getElements() as $el)
            {
                if ($el instanceof Text)
                {
                    $str = $str . $el->getText() . ' ';
                }

                if ($el instanceof TextRun)
                {
                    if(count($el->getElements()) > 0  and $el->getElements()[0] instanceof Text) {
                        $str = $str . $el->getElements()[0]->getText(). ' ';
                    }
                }

                if ($el instanceof ListItem) {
                    if($el->getDepth() == 0) {
                        $str = $str . $el->getText() . ' ';
                    }
                }
            }
        }
        return $str;
    }

    public function getTitle() { // lay chuong
        $str = '';
        foreach ($this->sections as $section) {
            foreach ($section->getElements() as $el) {
                if ($el instanceof Title) {
                    $str = $str . $el->getText() . ' ';
                }
            }
        }
        return $str;
    }

    public function getTableContent() {
        $str = '';
        $i = 1;
        foreach ($this->sections as $section) {
            foreach ($section->getElements() as $el) {

                if ($el instanceof ListItem) {

                    if($el->getDepth() != 0) {
                        if($el->getDepth() != 1) {
                            $str = $str . $el->getDepth() . ' - '. $el->getText() . '<br />';
                        }else if($el->getDepth() != 2) {
                            $str = $str . $el->getDepth() . ' - '. $el->getText() . '<br />';
                        }else if($el->getDepth() != 3) {
                            $str = $str . $el->getDepth() . ' - '. $el->getText() . '<br />';
                        }
                    }
                }
            }
        }
        return $str;
    }

    public function getPageSize() {
        $str = '';
        $titles = $this->phpWord->getTitles()->getItems();
        foreach ($titles as $i => $title) {
            /** @var \PhpOffice\PhpWord\Element\Title $title Type hint */
            $depth = $title->getDepth();

        }
        foreach ($this->sections as $section) {
            foreach ($section->getElements() as $el) {
                if ($el instanceof PreserveText)
                {

                    foreach ($el->getText() as $item) {
                        //dd(explode('\h \z \u', $item));
                        echo $item;
                    }


                }
            }
        }
        return $str;
    }

}
