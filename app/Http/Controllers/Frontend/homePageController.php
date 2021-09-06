<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\category;

class homePageController extends Controller
{
    // get Latest category api starts here
    public function getSingleLatestCategory(){
        $latest_category = category::latest()->first();
        return response()->json([
            'published_by' => $latest_category->published_by,
            'category_title' => $latest_category->title,
        ]);
    }
    // get Latest category api ends here
}
