<?php

namespace App\Http\Controllers\Home;

use App\Http\Models\Article;
use App\Http\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use DB;

class IndexController extends CommonController {
    public function __construct() {
        parent::__construct();
    }

    public function index(Tag $tag, Request $request) {
        $s = $request->input('s');

        $query = Article::where('status', 2)->select('id','name','category_id','thumb','publish_time', 'content');
        if($s){
            $query->where(DB::raw("(name like '%{$s}%' or content like '%{$s}%')"));
        }
        $data = $query->orderBy('publish_time', 'desc')->paginate(10);

        $hotArticle = $this->getHotArticle();

        //推荐文章
        $recommendArticle = $this->getRecommendArticle();

        //查询热门标签
        $hotTags = $tag->getHotTags();

        $allTags = $tag->getAllTags();

        if($s){
            $page = $data->appends(array('s' => $s))->render();
        }else{
            $page = $data->render();
        }

        return Response::render('index.index', compact('data', 'page', 's', 'hotArticle', 'recommendArticle', 'hotTags', 'allTags'));
    }
}