<?php

namespace App\Http\Controllers;

use App\Classes\Stemmer;
use App\Models\Pagerank;
use App\Models\TfIdf;
use App\Models\Word;
use App\Models\WordDoc;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $s = "";
        $show_results = false;
        $results = [];
        $search_method = 1;//1:tf_idf 2:page rank
        $word_id = 0;
        if ($request->search) {
            $s = $request->search;
            $s2 = Stemmer::stem($s);
            try {
                $word_id = $this->findWordId($s2)->id;
                //page rank method
                $urls = $this->findWordIdUrls($word_id);
                $page_rank_array = $this->findPageRankUrls($urls);
                //tf idf
                $tf_idf_array = $this->findTfIdfUrls($word_id);

                if ($search_method == 1) {
                    $results = $tf_idf_array;
                } else {
                    $results = $page_rank_array;
                }
                $show_results = true;
            } catch (\Exception $e) {
                $show_results = true;
            }
        }
        return view('index', compact('s', 'show_results', 'search_method', 'results'));
    }

    public function findWordId($word)
    {
        return Word::where("word", "=", $word)->first();
    }

    public function findTfIdfUrls($word_id)
    {
        return TfIdf::select("doc_url_id", "score")->where("word_id", "=", $word_id)->orderBy("score", "DESC")->distinct()->get();
    }

    public function findWordIdUrls($word_id)
    {
        return WordDoc::where("word_id", "=", $word_id)->get();
    }

    public function findPageRankUrls($urls)
    {
        $a = [];
        if (!empty($urls)) {
            $a = Pagerank::where("doc_url_id", "=", $urls[0]->doc_url_id);
            $size = sizeof($urls);
            for ($i = 1; $i < $size; $i++) {
                $a = $a->orWhere("doc_url_id", "=", $urls[$i]->doc_url_id);
            }
            return $a->orderBy("pagerank", "DESC")->distinct()->get();
        }
        return $a;
    }
}
