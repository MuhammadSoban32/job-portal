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
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        @include('front.message')
                        <h3 class="fs-4 mb-1">Jobs Applied</h3>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Applied Date</th>
                                        <th scope="col">Applicants</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @forelse ($jobApplied as $jobApplieds)
                                    <tr class="active">
                                        <td>
                                            <div class="job-name fw-500">{{ $jobApplieds->job->title }}</div>
                                            <div class="info1">{{ $jobApplieds->job->job_type->name }} . {{ $jobApplieds->job->location }}</div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($jobApplieds->applied_date )->format('d M,Y') }}</td>
                                        <td>{{ $jobApplieds->job->application->count() }} Applications</td>
                                        <td>
                                            @if ( $jobApplieds->job->status == 1 )
                                                <div class="job-status text-capitalize">active</div>
                                            @else
                                                <div class="job-status text-capitalize">deactive</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-dots float-end">
                                                <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route('jobDetail', $jobApplieds->job->id) }}"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="removeJob({{ $jobApplieds->id }})"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td>Not  Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $jobApplied->links() }}
                </div> 
            </div>
        </div>
    </div>
</section>


@endsection

@section('customJs')
    <script>
        function removeJob(id) {
            alert(id);
            if (confirm("Are you sured want to remove!")) {
                $.ajax({
                    url : "{{ route('account.removeJobs') }}",
                    type : "post",
                    data : {id: id},
                    dataType : "json",
                    success : function(response) {
                        // alert("sad");
                        // if (response.status == true) {  
                            // window.location.reload(true);  // Forces the browser to load from the server, bypassing cache
                            window.location.href="{{ route('account.myJobApplication') }}";
                        // }
                    }
                });
            }
        }
    </script>
@endsection