<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Category;
use App\Models\Job_Type;
use Illuminate\Support\Facades\Validator;


class JobController extends Controller
{
    public function index(){
        $jobs = Job::with('users')->paginate(10);
        return view('admin.jobs.list',[
            'jobs' => $jobs,
        ]);
    }

    public function edit($id){
        $job = Job::findOrFail($id);
        $category  = Category::orderBy('name', 'ASC')->get(); 
        $jobType = Job_Type::orderBy('name', 'ASC')->get(); 
        return view('admin.jobs.edit',[
            'job' => $job,
            'category' => $category,
            'jobType' => $jobType,
        ]);
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'job_type' => 'required',
            'vacancy' => 'required|integer',
            'salary' => 'nullable',
            'location' => 'required|min:5|max:50',
            'description' => 'required|min:5|max:300',
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
                // $job->user_id = Auth::user()->id;
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

                $job->status = $request->status;
                $job->isFeatured = ($request->isFeatured != null) ? 1 : 0;
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
    }

    public function destroy(Request $request){
        $id = $request->id;
        $job = Job::find($id);

        if ($job == null) {
            session()->flash('error','Either job deleted or not found');
                return response()->json([
                    'status' => false,
                ]);
        }

        $job->delete();

        session()->flash('error','Job deleted successfuly');
        return response()->json([
            'status' => true,
        ]); 
    }

}
