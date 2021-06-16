<?php


namespace App\Services\Facades;

class BreadcrumbService
{

    private $index = 0;
    private $codeString = '';

    private $array = [];

    public function push($name, $code) {
        self::init();
        $name = trim($name);
        $code = trim($code, " \n\r\t\v\0\\/");
        if(!$name or !$code) {
            throw new \Error('wrong name or code in breadcrumb');
        }
        $this->array[] = [
            'name' => $name,
            'code' => $code,
            ];
    }


    public function getNext() {
        $i = $this->index;

        if(!isset($this->array[$i])) {
            $this->refresh();
            return false;
        }

        $breadcrumb = $this->array[$i];

        $this->codeString .= $breadcrumb['code'];


        if($breadcrumb['code'] != '/') $this->codeString .= '/';
        if(!isset($this->array[$i + 1])) $this->codeString = false;

        $this->index++;

        return  (object)[
            'name' => $breadcrumb['name'],
            'code' => $this->codeString,
        ];
    }


    private function init() {
        if($this->array == []) {
            $this->array[] = [
                'name' => 'Главная',
                'code' => '/',
            ];
        }
    }

    private function refresh() {
        $this->index = 0;
        $this->codeString = '';
    }
}
