<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Validator;
use App\category;
use App\articles;

class homePageController extends Controller
{
    // get Latest category api starts here
    public function getSingleLatestCategory(){
        $latest_category = category::select('categories.title', 'categories.created_at', 'users.full_name')
        ->join('users', 'categories.published_by', '=', 'users.id')
        ->orderBy('created_at', 'DESC')
        ->first();
        if($latest_category)
        {
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $latest_category,
            ]);
        }
        else
        {
            return response()->json([
                'status' => 400,
                'message' => 'Data Not Found',
            ]);
        }
        
    }
    // get Latest category api ends here
    //---------------------------------------------------------------------------------------/
    // get getLatestSevenCategories api starts here
    public function getLatestSevenCategories(){
        $latest_categories = category::select('categories.id','categories.title', 'categories.created_at', 
        'users.full_name')
        ->join('users', 'categories.published_by', '=', 'users.id')
        ->orderBy('created_at', 'DESC')
        ->take(7)->get();
        // dd($latest_categories);
        if($latest_categories)
        {
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $latest_categories,
            ]);
        }
        else
        {
            return response()->json([
                'status' => 400,
                'message' => 'Data Not Found',
            ]);
        }
    }
    // get getLatestSevenCategories api ends here
    //---------------------------------------------------------------------------------------/
    // get getSingleCategoryArticles api starts here
    public function getSingleCategoryArticles(){
        $latest_categories = category::select('categories.id','categories.title', 'categories.created_at', 
        'users.full_name')
        ->join('users', 'categories.published_by', '=', 'users.id')
        ->orderBy('created_at', 'DESC')
        ->take(7)->get();
        // dd($latest_categories);
        if($latest_categories)
        {
            foreach ($latest_categories as $single_category)
            { 
                $single_category_articles = articles::where('category_id', '=', $single_category->id)
                ->take(3)->get();
                $single_category->single_category_articles = $single_category_articles;
                // dd($single_category_articles);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $latest_categories,
            ]);
        }
        else
        {
            return response()->json([
                'status' => 400,
                'message' => 'Data Not Found',
            ]);
        }
    }
    // get getSingleCategoryArticles api ends here
    //---------------------------------------------------------------------------------------/
    
}
