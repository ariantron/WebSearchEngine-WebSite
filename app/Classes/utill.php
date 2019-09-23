<?php


namespace App\Classes;


class utill
{
    static function getURLTitle($url){
            $data = file_get_contents($url);
            $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $data, $matches) ? $matches[1] : null;
            return $title;
    }

}
