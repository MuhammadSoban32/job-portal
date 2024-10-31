<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Job;

class HomeController extends Controller
{
    public function index(){
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->take(8)->get();
        $all_categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        $featuredJobs = Job::with('job_type')->where(['status' => 1, 'isFeatured' => 1])->orderBy('created_at', 'DESC')->take(6)->get();
        $latestJobs = Job::with('job_type')->where(['status' => 1])->orderBy('created_at', 'DESC')->take(6)->get();

        // dd($categories);
        return view('front.home',['categories' => $categories, 'featuredJobs' => $featuredJobs, 'latestJobs' => $latestJobs, 'all_categories' => $all_categories]);
    }
}
