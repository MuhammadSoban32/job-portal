@extends('front.layouts.app')

@section('main')

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
             @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Saved Jobs</h3>
                            </div>
                            <div style="margin-top: -10px;">
                                <a href="{{ route('account.createJob') }}" class="btn btn-primary">Post a Job</a>
                            </div>
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        {{-- <th scope="col">Job Created</th> --}}
                                        <th scope="col">Applicants</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @forelse ($saved_jobs as $saved_job)
                                    <tr class="active">
                                        <td>
                                            <div class="job-name fw-500">{{ $saved_job->jobs->title }}</div>
                                            <div class="info1">{{ $saved_job->jobs->job_type->name }} . {{ $saved_job->jobs->location }}</div>
                                        </td>
                                        {{-- <td>{{ \Carbon\Carbon::parse($saved_job->jobs->created_at)->format("d-M-Y") }}</td> --}}
                                        <td>{{ $saved_job->jobs->jobApplication->count() }} Applications</td>
                                        <td>
                                            @if ($saved_job->status == 1)
                                                <div class="job-status text-capitalize">active</div>
                                            @else
                                                <div class="job-status text-capitalize">Block</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-dots ">
                                                <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route('jobDetail',$saved_job->jobs->id) }}"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="{{ route('account.editJob', $saved_job->jobs->id) }}"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="removeSavedJob({{ $saved_job->id }})"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr><td>Not Found</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $saved_jobs->links() }}
                        </div>
                    </div>
                </div>                        
            </div>
        </div>
    </div>
</section>


@endsection

@section('customJs')
    <script>
      

        function removeSavedJob(id) {
            // alert("2");
            if (confirm("Are you sured want to remove job!")) {
                $.ajax({
                    url : "{{ route('account.removeSavedJob') }}",
                    type : "post",
                    data : {id: id},
                    dataType : "json",
                    success : function(response) {
                        // alert("sad");
                        if (response.status == true) {  
                            // window.location.reload(true);  // Forces the browser to load from the server, bypassing cache
                            window.location.href="{{ route('account.savedJobs') }}";
                        }
                    }
                });
            }
        }
    </script>
@endsection