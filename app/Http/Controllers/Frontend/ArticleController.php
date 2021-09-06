<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\articles;

class ArticleController extends Controller
{
    //
    public function getallarticles(){
        $articles = articles::latest()->first();
        return response()->json([
            'articles' => $articles,
            // 'name' => 'Abigail',
            // 'state' => 'CA',
        ]);
    }
    
}
