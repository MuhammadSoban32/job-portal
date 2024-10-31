@extends('front.layouts.app')

@section('main')
<section class="section-4 bg-2">    
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url()->previous() }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                    </ol>
                </nav>
                @include('front.message')
            </div>
        </div> 
    </div>
    <div class="container job_details_area">
        <div class="row pb-5">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                
                                <div class="jobs_conetent">
                                    <a href="#">
                                        <h4>{{ $job->title }}</h4>
                                    </a>
                                    <div class="links_locat d-flex align-items-center">
                                        <div class="location">
                                            <p> <i class="fa fa-map-marker"></i> {{ $job->location }}</p>
                                        </div>
                                        <div class="location">
                                            <p> <i class="fa fa-clock-o"></i> {{ $job->job_type->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="jobs_right">
                                <div class="apply_now">
                                    <a class="heart_mark  {{ ($count == 1) ? 'saved-job' : '' }}" href="javascript:void(0)" onclick="saveJob({{ $job->id }})">  <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                        <div class="single_wrap">
                            <h4>Job description</h4>
                            {!! nL2br($job->description) !!}
                        </div>
                        @if (!empty($job->responsibility))
                            <div class="single_wrap">
                                <h4>Responsibility</h4>
                                {!! nL2br($job->responsibility) !!}
                            </div>
                        @endif
                        @if (!empty($job->qualification))
                            <div class="single_wrap">
                                <h4>Qualifications</h4>
                                {!! nL2br($job->qualification) !!}
                            </div>
                        @endif
                        @if (!empty($job->benefits))
                            <div class="single_wrap">
                                <h4>Benefits</h4>
                                {!! nL2br($job->benifits) !!}
                            </div>
                        @endif
                        <div class="border-bottom"></div>
                        <div class="pt-3 text-end">

                            @if (Auth::check())
                                <a href="javascript:void(0)" onclick="saveJob('{{ $job->id }}')"  class="btn btn-secondary">Save</a>
                            @else
                                <a href="javascript:void(0)" class="btn btn-secondary" disabled>Login to Save</a>
                            @endif
                            
                            @if (Auth::check())
                                <a href="javascript:void(0)" onclick="applyJob('{{$job->id}}')" class="btn btn-primary">Apply</a>
                            @else
                                <a href="javascript:void(0)" class="btn btn-primary" disabled>Login to Apply</a>
                            @endif
                        </div>
                    </div>
                </div>

                

                @if (Auth::user() && Auth::user()->id == $job->user_id) 
                    <div class="card shadow border-0 mt-4">
                        <div class="job_details_header">
                            <div class="single_jobs white-bg d-flex justify-content-between">
                                <div class="jobs_left d-flex align-items-center">
                                    
                                    <div class="jobs_conetent">
                                            <h4>Applications</h4>
                                    </div>
                                </div>
                                <div class="jobs_right"></div>
                            </div>
                        </div>
                        <div class="descript_wrap white-bg">
                            <table class="table table-striped">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Applied Date</th>
                            </tr>
                                {{-- @if ($job_applications->isNotEmpty()) --}}
                                    @forelse ($job_applications as $job_application)
                                        <tr>
                                            <td>{{ $job_application->user->name }}</td>
                                            <td>{{ $job_application->user->email }}</td>
                                            <td>{{ \Carbon\Carbon::parse($job_application->applied_date)->format('d m-y') }}</td>
                                        </tr>
                                    @empty
                                    <tr>
                                        <td>No applications found</td>
                                    </tr>
                                    @endforelse
                                {{-- @endif --}}
                            </table>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Job Summery</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Published on: <span>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</span></li>
                                <li>Vacancy: <span>{{ $job->vacancy }}</span></li>
                                @if (!empty($job->salary))
                                    <li>Salary: <span>{{ $job->salary }}</span></li>
                                @endif
                                @if (!empty($job->location))
                                    <li>Location: <span>{{ $job->location }}</span></li>
                                @endif
                                <li>Job Nature: <span>{{ $job->job_type->name }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 my-4">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Company Details</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                @if (!empty($job->company_name))
                                    <li>Name: <span>{{ $job->company_name }}</span></li>
                                @endif
                                @if (!empty($job->company_location))
                                    <li>Locaion: <span>{{ $job->company_location }}</span></li>
                                @endif
                                @if (!empty($job->company_website))
                                    <li>Webite: <span><a href="{{ $job->company_website }}" target="_blank">{{ $job->company_website }}</a></span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="image"  name="image">
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mx-3">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('customJs')
    <script>

        function applyJob(id){
            if (confirm("Are you sure you want to apply for this job")) {
                    $.ajax({
                        url: '{{ route('applyJob') }}',
                        type: 'post',
                        dataType: 'json',
                        data: {id:id},
                        success: function(response){
                            window.location.href="{{ url()->current() }}";
                        }
                    });
            }   
        }

        function saveJob(id){
                    $.ajax({
                        url: '{{ route('saveJob') }}',
                        type: 'post',
                        dataType: 'json',
                        data: {id:id},
                        success: function(response){
                            window.location.href="{{ url()->current() }}";
                        }
                    });
        }
        
    </script>
@endsection