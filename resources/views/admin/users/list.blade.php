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
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        {{-- <th scope="col">Job Created</th> --}}
                                        <th scope="col">Email</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @forelse ($users as $user)
                                    <tr class="active">
                                        <td>
                                            <div class="job-name fw-500">{{ $user->id }}</div>
                                            {{-- <div class="info1">{{ $user->jobs->job_type->name }} . {{ $user->jobs->location }}</div> --}}
                                        </td>
                                        <td>
                                            <div class="job-name fw-500">{{ $user->name }}</div>
                                            {{-- <div class="info1">{{ $user->jobs->job_type->name }} . {{ $user->jobs->location }}</div> --}}
                                        </td>
                                        {{-- <td>{{ \Carbon\Carbon::parse($user->jobs->created_at)->format("d-M-Y") }}</td> --}}
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            {{ $user->mobile }}
                                        </td>
                                        <td>
                                            <div class="action-dots ">
                                                <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route("admin.users.edit", $user->id) }}"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteUser({{ $user->id }})"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr><td>Not Found</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $users->links() }}
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

        function deleteUser(id) {
            alert(id);
            if (confirm("Are you sured want to remove!")) {
                $.ajax({
                    url : "{{ route('admin.user.destroy') }}",
                    type : "post",
                    data : {id: id},
                    dataType : "json",
                    success : function(response) {
                        // alert("sad");
                        // if (response.status == true) {  
                            // window.location.reload(true);  // Forces the browser to load from the server, bypassing cache
                            window.location.href="{{ route('admin.users') }}";
                        // }
                    }
                });
            }
        }
    </script>
@endsection