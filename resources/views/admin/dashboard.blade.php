@extends('admin.layouts.app')

@section('main')

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
             @include('admin.layouts.sidebar')
            </div>
            
            <div class="col-lg-9">
                @include('front.message')
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Users</h3>
                            </div>
                            <div style="margin-top: -10px;">
                                {{-- <a href="{{ route('account.createJob') }}" class="btn btn-primary">Post a Job</a> --}}
                            </div>
                            
                        </div>
                        <div class="table-responsive">
                        
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