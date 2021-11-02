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
use App\categoryTag;
use Illuminate\Support\Str;
class HomePageController extends Controller
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
    // get getLatest9Categories api starts here
    public function getLatest9Categories(){
        $latest_categories = category::select('categories.id','categories.title','categories.picture',
        'categories.description' ,'categories.created_at', 
        'users.full_name')
        ->join('users', 'categories.published_by', '=', 'users.id')
        ->orderBy('id', 'DESC')
        ->take(9)->get();
        // dd($latest_categories);
        if($latest_categories)
        {
            
            foreach($latest_categories as $single_latest_category)
            {
                $short_des = Str::limit($single_latest_category->description, 150);
                // Str::words($this->$single_latest_category->description, '25');
                $single_latest_category->short_des = $short_des;
                // dd($short_des);
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
    // get getLatest9Categories api ends here
    //---------------------------------------------------------------------------------------/
    // get getAllArticles api starts here
    public function getAllArticles(){
        $latest_articles = articles::select('articles.id','categories.id as cat_id','articles.title as article_title', 
        'articles.description', 'articles.image','category_tags.tag', 
        'categories.title as category_title','users.full_name', 'articles.created_at')
        ->join('users', 'articles.published_by', '=', 'users.id')
        ->join('categories', 'articles.category_id', '=', 'categories.id')
        ->Leftjoin('category_tags', 'articles.category_id', '=', 'category_tags.category_id')
        ->orderby('articles.id', 'desc')
        ->paginate(4);
        // dd($latest_articles);
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
    // get getAllArticles api ends here
    //---------------------------------------------------------------------------------------/
    // get getLatestSevenCategories api starts here
    public function getSingleArticle(request $request){
        $validator = Validator::make($request->all(), [
            'slug' => 'required',
            
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        //getting article according to the slug
        $article = articles::where('slug',$request->slug)
        ->first();
        if($article)
        {
            // getting articles of the same category as the main article
            $category_articles = articles::select('articles.id','articles.title','articles.slug','articles.image',
            'articles.description' ,'articles.created_at')
            ->where('category_id', $article->category_id)
            ->take(5)->get();
            //getting latest 6 categories
            $latest_categories = category::select('categories.id','categories.title')
            ->orderBy('id', 'DESC')
            ->take(6)->get();
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'article_detail' => $article,
                'related_articles' => $category_articles,
                'latest_categories' => $latest_categories,
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
}
