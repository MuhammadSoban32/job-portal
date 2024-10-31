<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Job_Type;
use App\Models\Job;
use App\Models\User;
use App\Models\JobApplication;
use App\Models\Saved_Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobNotificationEmail;

class JobController extends Controller
{
    // This  method will show job page
    public  function index(Request $request){
        $categories = Category::where('status',1)->get();
        $jobTypes = Job_Type::where('status',1)->get();
         
        $jobs = Job::where(['status' => 1]);

        // Searching using Keywords and title
        if (!empty($request->keyword)) {
            $jobs = $jobs->where(function($query) use ($request) {
                $query->orWhere([['title','like','%'.$request->keyword.'%']]);
                $query->orWhere([['keywords','like','%'.$request->keyword.'%']]);
            });
        }

        // Searching using Location
        if (!empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }

        // Searching using Category
        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        // Searching using Job Type
        if (!empty($request->job_type)) {
            $jobTypeArray = explode(",", $request->job_type);
            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }

        
        // Searching using Experiance
        if (!empty($request->experience)) {
            $jobs = $jobs->where('experiance', $request->experience);
        }
        
        $jobs = $jobs->with(['category','job_type']);

        if ($request->sort == 0) {
            $jobs = $jobs->orderBy('created_at', 'Asc');
        }else{
            $jobs = $jobs->orderBy('created_at', 'DESC');
        }
        
        $jobs = $jobs->paginate(9);

        return view('front.jobs ',['categories' => $categories, 'jobTypes' => $jobTypes, 'jobs' => $jobs]);
    }

    // This method will show job detail page
    public function detail($id){
        $job = Job::where(['id'=> $id, 'status' => 1])->with(['job_type','category'])->first();

        if ($job == null) {
            abort(404);
        }

        $count = 0;
        if (Auth::user()) {
            $count = Saved_Job::where(['job_id' => $id, 'user_id' => Auth::user()->id])->count();
        }        

        // fetch applications

        $job_applications = JobApplication::with('user')->where('job_id', $id)->get();
        
        return view('front.jobDetail',['job' => $job, 'count' => $count, 'job_applications' => $job_applications]);
        // ['one' => 1, 'two' => 2]
        // [['one',1],['two',2]]
    }

    public function applyJob(Request $request){
        $id = $request->id;

        $job = Job::where('id', $id)->first();
        
        // if job not found in db
        if ($job == null) {
            $message = "Job does not exist!";
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        // You can not apply on your own job 
        $employer_id = $job->user_id;
        if ($employer_id == Auth::User()->id) {
            $message = "You can not apply on your own job!";
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        // You can not apply job twice
        $jobApplicationCount = JobApplication::where(['job_id' => $id, 'user_id' => Auth::User()->id])->count();
        if ($jobApplicationCount > 0) {
            $message = "You can not applied for this job twice";
            session()->flash('success', $message);
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        }


        // Now you can apply for this job 
        $application = new JobApplication();
        $application->job_id = $id;
        $application->user_id = Auth::User()->id;
        $application->employer_id = $job->user_id;
        $application->applied_date = now();
        $application->save();

        // Send notification email to employer
        $employer = User::where('id', $employer_id)->first();
        
        $mailData = [
            'employer' => $employer,
            'user' => Auth::user(),
            'job' => $job,
        ];
        
        Mail::to($employer->email)->send(new JobNotificationEmail($mailData));
        
        $message = "You have successfuly applied to this job!";
        session()->flash('success', $message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);

    }

    public function saveJob(Request $request){

        $saved_Job_count = Saved_Job::where(['job_id' => $request->id,'user_id' => Auth::user()->id])->count();

        if ($saved_Job_count > 0) {
            session()->flash('error', 'Job already Saved.');
            return response()->json([
                'status' => false,
            ]);
        }
        
        $job = Job::where('id', $request->id)->first();

        if ($job != null) {
            $saved_Job = new Saved_Job();
            $saved_Job->job_id = $request->id;
            $saved_Job->user_id = Auth::user()->id;
            $saved_Job->save();

            session()->flash('success', 'Job saved successfuly');
            return response()->json([
                'status' => true,
            ]);
        }

        session()->flash('error', 'Job not saved');
        return response()->json([
            'status' => false,
        ]);

    }
}
