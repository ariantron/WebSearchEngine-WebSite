<?php

namespace App\Http\Controllers;

use App\Models\Pagerank;
use App\Models\TfIdf;
use App\Models\Word;
use App\Models\WordDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index(){
        $word=$this->findWordId("univers");
        $p= $this->findPageRankUrls($this->findWordIdUrls($word->id));
        $f=$this->findTfIdfUrls($word->id);
        return $f;
    }

    public function findWordId($word){
        return Word::where("word","=",$word)->first();
    }

    public function findTfIdfUrls($word_id){
        return TfIdf::where("word_id","=",$word_id)->orderBy("score","DESC")->get(["doc_url_id",DB::raw("avg(score)")]);
    }

    public function findWordIdUrls($word_id){
        return WordDoc::where("word_id","=",$word_id)->get();
    }

    public function findPageRankUrls($urls){
        $a=[];
        if(!empty($urls)){
            $a=Pagerank::where("doc_url_id","=",$urls[0]->doc_url_id);
            $size=sizeof($urls);
            for ($i=1;$i<$size;$i++){
                $a=$a->orWhere("doc_url_id","=",$urls[$i]->doc_url_id);
            }
            return $a->orderBy("pagerank","DESC")->get();
        }
        return $a;
    }
}
