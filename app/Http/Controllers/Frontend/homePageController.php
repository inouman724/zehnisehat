<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Validator;
use App\category;
use App\articles;
use App\therapistReview;
use App\User;
use Illuminate\Support\Str;
class homePageController extends Controller
{
    // get Latest category api starts here
    public function getSingleLatestCategory(){
        $latest_category = category::select('categories.id','categories.title', 'categories.created_at', 'users.full_name')
        ->join('users', 'categories.published_by', '=', 'users.id')
        ->orderBy('categories.id', 'DESC')
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
        ->orderBy('id', 'DESC')
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
    // get getLatestcategoriesArticles api starts here
    public function getLatestcategoriesArticles(){
        $latest_categories = category::select('categories.id','categories.title', 'categories.created_at', 
        'users.full_name')
        ->join('users', 'categories.published_by', '=', 'users.id')
        ->orderBy('id', 'DESC')
        ->take(7)->get();
        if($latest_categories)
        {
            foreach ($latest_categories as $single_category)
            { 
                $single_category_articles = articles::where('category_id', '=', $single_category->id)
                ->take(3)->get();
                $count = count($single_category_articles);
                if($count>0)
                {
                   $single_category->check_articles = true;
                   $single_category->single_category_articles = $single_category_articles;
                }
                else
                {
                    $single_category->check_articles = false;
                    $single_category->single_category_articles = $single_category_articles;
                }
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
    // get getLatestcategoriesArticles api ends here
    //---------------------------------------------------------------------------------------/
    // get getLatestEightArticles api starts here
    public function getLatestEightArticles(){
        $latest_articles = articles::select('id','title','description')
        ->orderBy('id', 'DESC')
        ->take(8)->get();
        if($latest_articles)
        {
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $latest_articles,
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
    // get getLatestEightArticles api ends here
    //---------------------------------------------------------------------------------------//
    // get getAllCategoriesArticles api starts here
    public function getAllCategoriesArticles(){
        $latest_articles = articles::select('id','title', 'category_id','description')
        ->groupBy('category_id')->orderby('id', 'desc')->take(6)
        ->get();
        $count = count($latest_articles);
        if($count>0)
        {       
            foreach($latest_articles as $single_article)
            {
                $short_des = Str::limit($single_article->description, 150);
                // Str::words($this->$single_article->description, '25');
                $single_article->short_des = $short_des;
                // dd($short_des);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $latest_articles,
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
    // get getAllCategoriesArticles api ends here
    //---------------------------------------------------------------------------------------/
    // get getRandomArticles api starts here
    public function getRandomArticles(){
        $latest_articles = articles::inRandomOrder()
        ->join('users', 'articles.published_by', '=', 'users.id')
        ->join('categories', 'articles.category_id', '=', 'categories.id')
        ->select('articles.id','articles.title as article_title', 'articles.description', 'articles.image', 
        'categories.title as category_title','users.full_name')
        ->groupBy('category_id')->orderby('articles.id', 'desc')->take(3)
        ->get();
        $count = count($latest_articles);
        if($count>0)
        {       
            foreach($latest_articles as $single_article)
            {
                $short_des = Str::limit($single_article->description, 150);
                $single_article->short_des = $short_des;
                // dd($short_des);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $latest_articles,
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
    // get getRandomArticles api ends here
    //---------------------------------------------------------------------------------------/
    // get getUserReviews api starts here
    public function getUserReviews(){
        $latest_reviews = therapistReview::select('therapist_reviews.id','therapist_reviews.feedback',
        'users.full_name','users.image')
        ->where('rating' , '>=','4')
        ->join('users', 'therapist_reviews.patient_id', '=', 'users.id')
        ->orderby('therapist_reviews.id', 'desc')->take(9)
        ->get();
        if($latest_reviews)
        {       
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $latest_reviews,
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
    // get getUserReviews api ends here
    //---------------------------------------------------------------------------------------/
    // get getAllTherapists api starts here
    public function getAllTherapists(){
        $therapists = User::select('users.id','users.full_name','users.image',
        'categories.title as category_title','therapist_details.profession','therapist_details.specialization')
        ->join('therapist_details', 'users.id', '=', 'therapist_details.therapist_id')
        ->join('categories', 'therapist_details.category_id', '=', 'categories.id')
        ->where('users.is_therapist', true)
        ->get();

        if($therapists)
        {     
            foreach($therapists as $single_therapist)
            {
                $t_reviws = therapistReview::where('therapist_id',$single_therapist->id)
                ->get();
                $count = count($t_reviws);
                if($count>0)
                {
                    // dd($count);
                    $rating_raw = therapistReview::where('therapist_id', $single_therapist->id)
                    ->avg('rating');
                    $rating = round($rating_raw, 2);
                    $single_therapist->rating = $rating;
                    $single_therapist->reviews = $count;
                    
                }
                else
                {
                    $single_therapist->rating = 'not rated yet';
                    $single_therapist->reviews = '0';
                }
            }  
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $therapists,
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
    // get getAllTherapists api ends here
    //---------------------------------------------------------------------------------------/
    
    
}
