<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Models\Category;
use App\Models\Job_Type;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Saved_Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Mail;


class AccountController extends Controller
{
    // This method will shoe user registration form
    public function registration(){
        return view('front.account.registration');
    }

    // This method will save user registration 
    public function processRegistration(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        if ($validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            
            session()->flash('success','you have registerd successfully');
            
            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

    }

    // This method will shoe user login form
    public function login(){
        return view('front.account.login');
    }

    // This method will shoe user login form
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email,'password' => $request->password])) {
                return redirect()->route('account.profile');
            }else{
                return redirect()->route('account.login')->with('error','Either Email or Password is Incorrect');
            }
        }else{
            return redirect()->route("account.login")
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }

        return view('front.account.login');
    }

    public function profile(){
        $id = Auth::user()->id;
        $user = User::where('id',$id)->first();
        // dd($user);
        return view('front.account.profile',['user' => $user]);
    }

    public function updateProfile(Request $request){
        $id = Auth::user()->id;
        $validator =  Validator::make($request->all(),[
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,'.$id.',id',
        ]);

        if ($validator->passes()) {

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->save();
            Session()->flash('success','Profile Updated Successfuly');
            return response()->json([
                'status' => true,
                'status' => true,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
      
    }
    public function updateProfilePic(Request $request){
        // dd($request->all());
        $id = Auth::user()->id;
        $validator =  Validator::make($request->all(),[
            'image' => 'required|image',
        ]);

        if ($validator->passes()) {
            // dd($request->image); 
            // dd(Str::random(5));
            $image = $request->image;
            $extension = $image->getClientOriginalExtension();
            $imageName = Str::random(5) . "." . $extension;
            $image->move(public_path("profile_pic"), $imageName);

            // create new image instance (800 x 600)
            // $sourcePath = public_path("profile_pic/".$imageName);
            // $manager = new ImageManager(Driver::class);
            // $image = $manager->read($sourcePath);

            // // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
            // $image->cover(150, 150);
            // $image->toPng()->save(public_path("profile_pic/thumbnail/".$imageName));

            // Delete Old Profile pic
            File::delete(public_path("profile_pic/".Auth::user()->image));
            
            $user = User::find($id);
            $user->image = $imageName;
            $user->update();
            Session()->flash('success','Profile Picture Uploaded Successfuly');
            return response()->json([
                'status' => true,
                'status' => true,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
      
    }
    
    
    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function createJob(){
        $category = Category::orderBy('name', 'asc')->where('status', 1)->get();
        $jobType = Job_Type::orderBy('name', 'asc')->where('status', 1)->get();
        return view('front.account.job.create', compact(['category', 'jobType']));
    }

    public function saveJob(Request $request){

        $validator = Validator::make($request->all(),[
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'job_type' => 'required',
            'vacancy' => 'required|integer',
            'salary' => 'nullable',
            'location' => 'required|min:5|max:50',
            'description' => 'required|min:5',
            'benifits' => 'nullable',
            'responsibilities' => 'nullable',
            'qualification' => 'nullable',
            'experiance' => 'nullable',
            'keyword' => 'nullable',
            'company_name' => 'required|min:3|max:75',
            'company_location' => 'nullable',
            'company_website' => 'nullable',
        ]);
    
            if ($validator->passes()) {
                $job = new Job();
                
                $job->title = $request->title;
                $job->category_id = $request->category;
                $job->job_type_id = $request->job_type;
                $job->user_id = Auth::user()->id;
                $job->vacancy = $request->vacancy;
                $job->salary = $request->salary;
                $job->location = $request->location;
                $job->description = $request->description;
                $job->benifits = $request->benifits;
                $job->responsibility = $request->responsibilities;
                $job->qualification = $request->qualification;
                $job->experiance = $request->experiance;
                $job->keywords = $request->keyword;
                $job->company_name = $request->company_name;
                $job->company_location = $request->company_location;
                $job->company_website = $request->company_website;
                $job->save();

                session()->flash('success','Job Created Successfuly');
                return response()->json([
                    'status' => true,
                ]);

            }else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }
    
        return view('front.account.job.create', compact(['category', 'jobType']));
    }

    public function myJob(){
        $jobs = Job::with('job_type')->where('user_id', Auth::user()->id)->orderBy('created_at','DESC')->paginate(10);
        // dd($jobs->toArray());
        return view('front.account.job.my-jobs',['jobs' => $jobs]);
    }

    public function editJob($id){
        $category = Category::orderBy('name', 'asc')->where('status', 1)->get();
        $jobType = Job_Type::orderBy('name', 'asc')->where('status', 1)->get();

        $job = Job::where(['user_id' => Auth::user()->id, 'id' => $id])->first();
        // dd($job->toArray());
        if ($job == null) {
            abort(404);
        }

        return view('front.account.job.edit',["category" => $category, "jobType" => $jobType, "job" => $job]);
    }
    

    public function updateJob(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'job_type' => 'required',
            'vacancy' => 'required|integer',
            'salary' => 'nullable',
            'location' => 'required|min:5|max:50',
            'description' => 'required|min:5|max:50',
            'benifits' => 'nullable',
            'responsibilities' => 'nullable',
            'qualification' => 'nullable',
            'experiance' => 'nullable',
            'keyword' => 'nullable',
            'company_name' => 'required|min:3|max:75',
            'company_location' => 'nullable',
            'company_website' => 'nullable',
        ]);
    
            if ($validator->passes()) {
                $job = Job::find($id);
                
                $job->title = $request->title;
                $job->category_id = $request->category;
                $job->job_type_id = $request->job_type;
                $job->user_id = Auth::user()->id;
                $job->vacancy = $request->vacancy;
                $job->salary = $request->salary;
                $job->location = $request->location;
                $job->description = $request->description;
                $job->benifits = $request->benifits;
                $job->responsibility = $request->responsibilities;
                $job->qualification = $request->qualification;
                $job->experiance = $request->experiance;
                $job->keywords = $request->keyword;
                $job->company_name = $request->company_name;
                $job->company_location = $request->company_location;
                $job->company_website = $request->company_website;
                $job->save();

                session()->flash('success','Job Updated Successfuly');
                return response()->json([
                    'status' => true,
                ]);

            }else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }
    
        return view('front.account.job.create', compact(['category', 'jobType']));
    }

    public function deleteJob(Request $request){
        // dd($request->jobID);
        $job = Job::where(['user_id' => Auth::user()->id, 'id' => $request->jobID])->first();

        if ($job == null) {
            session()->flash("error", "Either Job deleted or not found.");
            return response()->json([
                'status' => true,
            ]);
        }
        
        $job->delete();
        session()->flash("success", "Job deleted Successfuly.");

        return response()->json([
            'status' => true,
        ]);
    }

    public function myJobApplication(){
        $jobApplied = JobApplication::with(['job','job.job_type','job.application'])->where('user_id', Auth::User()->id)->paginate(10);
        // dd($jobApplied->toArray());
        return view('front.account.job.my-job-applications', ['jobApplied' => $jobApplied]);
    }

    public function removeJobs(Request $request){
        $jobs = JobApplication::where([['id', $request->id], ['user_id', Auth::user()->id]])->first();

        if ($jobs == null) {
            session()->flash('error','Job Application not found');
            return response()->json([
                'status' => false,
            ]);
        }

        JobApplication::where('id', $request->id)->delete();
        session()->flash('success','Job Application remove Successfuly');
        return response()->json([
            'status' => true,
        ]);
        
    }

    public function savedJobs(){
        $saved_jobs = Saved_Job::with(['jobs', 'jobs.job_type', 'jobs.jobApplication'])->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        // dd($saved_jobs->toArray());
        return view('front.account.job.saved-jobs', ['saved_jobs' => $saved_jobs]);
    }
    
    public function removeSavedJobs(Request $request){
        $saved_jobs = Saved_Job::where([['id', $request->id], ['user_id', Auth::user()->id]])->first();

        if ($saved_jobs == null) {
            session()->flash('error','Job not found');
            return response()->json([
                'status' => false,
            ]);
        }

        Saved_Job::where([['id', $request->id], ['user_id', Auth::user()->id]])->delete();
        session()->flash('success','Job remove Successfuly');
        return response()->json([
            'status' => true,
        ]);
        
    }

    public function updatePassword(Request $request){
        // dd("change password");
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        if (Hash::check($request->old_password, Auth::user()->password) == false) {
            session()->flash('error', 'Your old Password is Incorrect');
            return response()->json([
                'status' => true,
            ]);
        }else{
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->new_password);
            $user->save();

            session()->flash('success', 'Password updated Successfuly');
            return response()->json([
                'status' => true,
            ]);
        }
        
    }

    public function forgotPassword(){
        return view('front.account.forgot-password');
    }


    public function processForgotPassword(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.forgot-password')->withInput()->withErrors($validator);
        }
        
        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        
        $token = Str::random(10);
        
        \DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Send Email Here
        $user = User::where('email', $request->email)->first();
        $mailData = [
            'token' => $token,
            'user' => $user,
            'subject' => 'You have requested to change your password'
        ];
        
        Mail::to($request->email)->send(new ResetPasswordMail($mailData));

        // session()->flash('success', '');
        
        return redirect()->route('account.forgot-password')->with('success' , 'Reset Password link send to your email');
    }

    public function resetPassword(Request $request, $token){
        $token = \DB::table('password_reset_tokens')->where('token', $token)->first();

        if ($token == null) {
             return redirect()->route('account.forgot-password')->with('error' , 'Invallid token');
        }

        return view('front.account.reset-password',[
            'token' => $token
        ]);
    }

    public function processResetPassword(Request $request){
        $token = \DB::table('password_reset_tokens')->where('token', $request->token)->first();
        // dd("lora",$token,$request->token);

        if ($token == null) {
             return redirect()->route('account.forgot-password')->with('error' , 'Invallid token');
        }

        $validator = Validator::make($request->all(),[
            'new_password' => 'required|min:6',
            'password_confirmation' => 'required|same:new_password'
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.resetPassword', $request->token)->withErrors($validator);
        }

        User::where('email', $token->email)->update([
            'password'=> Hash::make($request->new_password)
        ]);

        return redirect()->route('account.login')->with('success', 'You have successfuly changed your password');
       
    }
}

