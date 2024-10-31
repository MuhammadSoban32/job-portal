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
                                <h3 class="fs-4 mb-1">My Jobs</h3>
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
                                        <th scope="col">Job Created</th>
                                        <th scope="col">Applicants</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @forelse ($jobs as $job)
                                    <tr class="active">
                                        <td>
                                            <div class="job-name fw-500">{{ $job->title }}</div>
                                            <div class="info1">{{ $job->job_type->name }} . {{ $job->location }}</div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($job->created_at)->format("d-M-Y") }}</td>
                                        <td>130 Applications</td>
                                        <td>
                                            @if ($job->status == 1)
                                                <div class="job-status text-capitalize">active</div>
                                            @else
                                                <div class="job-status text-capitalize">Block</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-dots float-end">
                                                <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="job-detail.html"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="{{ route('account.editJob', $job->id) }}"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="confirmDelete({{ $job->id }})"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr><td>Not Found</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $jobs->links() }}
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
        $("#jobForm").submit(function(e){
            e.preventDefault();
                // alert("sa");
            $.ajax({
                url: '{{ route('account.saveJob') }}',
                type: 'post',
                data: $("#jobForm").serializeArray(),
                dataType: 'json',
                success: function(response){
                        if (response.status == false) {
                                errors = response.errors;
                                if (errors.title) {
                                    $("#title").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors.title);
                                }else{
                                    $("#title").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
                                }
                                if (errors.category) {
                                    $("#category").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors.category);
                                }else{
                                    $("#category").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
                                }
                                if (errors.job_type) {
                                    $("#job_type").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors.job_type);
                                }else{
                                    $("#job_type").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
                                }
                                if (errors.vacancy) {
                                    $("#vacancy").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors.vacancy);
                                }else{
                                    $("#vacancy").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
                                }
                                if (errors.location) {
                                    $("#location").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors.location);
                                }else{
                                    $("#location").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
                                }
                                if (errors.description) {
                                    $("#description").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors.description);
                                }else{
                                    $("#description").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
                                }
                                if (errors.company_name) {
                                    $("#company_name").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors.company_name);
                                }else{
                                    $("#company_name").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
                                }
                        }else{
                            $("#title").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
                            $("#category").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
                            $("#job_type").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
                            $("#vacancy").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
                            $("#location").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
                            $("#description").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
                            $("#company_name").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html();
                            window.location.href="{{ route('account.myJob') }}";
                        }
                }
            });
        });

        function confirmDelete(jobID) {
            // alert("2");
            if (confirm("Are you sured want to delete!")) {
                $.ajax({
                    url : "{{ route('account.deleteJob') }}",
                    type : "post",
                    data : {jobID: jobID},
                    dataType : "json",
                    success : function(response) {
                        // alert("sad");
                        if (response.status == true) {  
                            // window.location.reload(true);  // Forces the browser to load from the server, bypassing cache
                            window.location.href="{{ route('account.myJob') }}";
                        }
                    }
                });
            }
        }
    </script>
@endsection