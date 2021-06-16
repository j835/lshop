<?php


namespace App\Services\Facades;


class SeoService
{
    private $description;
    private $keywords;
    private $title;



    public function __construct()
    {
        $this->description = config('seo.description');
        $this->title = config('seo.title');
        $this->keywords = config('seo.keywords');
    }


    public function setTitle($title) {
        $title = trim($title);
        if($title) {
            $this->title = $title;
        }
    }

    public function getTitle() {
        return $this->title;
    }

    public function setDescription($description) {
        $description = trim($description);
        if($description) {
            $this->description = $description;
        }
    }

    public function getDescription() {
        return $this->description;
    }


    public function setKeywords($keywords) {
        $keywords = trim($keywords);
        if($keywords) {
            $this->keywords = $keywords;
        }
    }

    public function getKeywords() {
        return $this->keywords;
    }


}

