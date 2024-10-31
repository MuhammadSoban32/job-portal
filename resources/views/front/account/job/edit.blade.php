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

                <form action="" method="post" id="editJobForm">
                    @csrf
                    <div class="card border-0 shadow mb-4">
                        <div class="card-body card-form p-4">
                            <h3 class="fs-4 mb-1">Edit Job Details</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Title<span class="req">*</span></label>
                                    <input type="text" value="{{ $job->title }}" placeholder="Job Title" id="title" name="title" class="form-control">
                                    <p></p>
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Category<span class="req">*</span></label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="" selected disabled>Select a Category</option>
                                        @forelse ($category as $categories)
                                            <option {{ ($job->category_id == $categories->id) ? "selected" : '' }} value="{{ $categories->id }}" >{{ $categories->name }}</option>
                                        @empty
                                            <option selected disabled>Not Found</option>
                                        @endforelse
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Job Type<span class="req">*</span></label>
                                    <select class="form-select" name="job_type" id="job_type">
                                        <option value="" selected disabled>Select a Type</option>
                                        @forelse ($jobType as $jobTypes)
                                            <option {{ ($job->job_type_id == $jobTypes->id) ? "selected" : '' }} value="{{ $jobTypes->id }}">{{ $jobTypes->name }}</option>
                                        @empty
                                            <option selected disabled>Not Found</option>
                                        @endforelse
                                    </select>
                                    <p></p>
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                    <input value="{{ $job->vacancy }}" type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                    <p></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Salary</label>
                                    <input value="{{ $job->salary }}" type="text" placeholder="Salary" id="salary" name="salary" class="form-control">
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location<span class="req">*</span></label>
                                    <input value="{{ $job->location }}" type="text" placeholder="location" id="location" name="location" class="form-control">
                                    <p></p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="" class="mb-2">Description<span class="req">*</span></label>
                                <textarea class="textarea" name="description" id="description" cols="5" rows="5" placeholder="Description">{{ $job->description }}</textarea>
                                <p></p>
                            </div>  
                            <div class="mb-4">
                                <label for="" class="mb-2">Benefits</label>
                                <textarea class="textarea" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{ $job->benifits }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Responsibility</label>
                                <textarea  class="textarea" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility">{{ $job->responsibility }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Qualifications</label>
                                <textarea class="textarea" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications">{{ $job->qualification }}</textarea>
                            </div>
                            {{-- @dd($job->experiance) --}}
                            <div class="mb-4">
                                <label for="" class="mb-2">Experiance</label>
                                <select name="experiance" id="" class="form-select">
                                    <option value="1" {{ ($job->experiance == 1) ? "selected" : " " }}>1 Year</option>
                                    <option value="2" {{ ($job->experiance == 2) ? "selected" : " " }}>2 Year</option>
                                    <option value="3" {{ ($job->experiance == 3) ? "selected" : " " }}>3 Year</option>
                                    <option value="4" {{ ($job->experiance == 4) ? "selected" : " " }}>4 Year</option>
                                    <option value="5" {{ ($job->experiance == 5) ? "selected" : " " }}>5 Year</option>
                                    <option value="6" {{ ($job->experiance == 6) ? "selected" : " " }}>6 Year</option>
                                    <option value="7" {{ ($job->experiance == 7) ? "selected" : " " }}>7 Year</option>
                                    <option value="8" {{ ($job->experiance == 8) ? "selected" : " " }}>8 Year</option>
                                    <option value="9" {{ ($job->experiance == 9) ? "selected" : " " }}>9 Year</option>
                                    <option value="10" {{ ($job->experiance == 10) ? "selected" : " " }}>10 Year</option>
                                    <option value="10_plus" {{ ($job->experiance == "10_plus") ? "selected" : " " }}>10+ Year</option>
                                </select>
                            </div>
                            
                            

                            <div class="mb-4">
                                <label for="" class="mb-2">Keywords</label>
                                <input value="{{ $job->kwywords }}" type="text" placeholder="keywords" id="keywords" name="keywords" class="form-control">
                            </div>

                            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Name<span class="req">*</span></label>
                                    <input value="{{ $job->company_name }}" type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control">
                                    <p></p>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location</label>
                                    <input value="{{ $job->company_location }}" type="text" placeholder="Location" id="company_location" name="company_location" class="form-control">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="" class="mb-2">Website</label>
                                <input value="{{ $job->company_website }}" type="text" placeholder="Website" id="company_website" name="company_website" class="form-control">
                            </div>
                            <div class="mb-4">
                                <button class="btn btn-primary mx-3" type="submit">Update Job</button>
                            </div>
                        </div> 
                    </div>     
                </form>

                       
            </div>
        </div>
    </div>
</section>
{{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div> --}}

@endsection

@section('customJs')
    <script>
        $("#editJobForm").submit(function(e){
            e.preventDefault();
            $("button[type='submit']").prop('disabled', true);
                // alert("sa");
            $.ajax({
                url: '{{ route('account.updateJob', $job->id) }}',
                type: 'POST',
                data: $("#editJobForm").serializeArray(),
                dataType: 'json',
                success: function(response){
            $("button[type='submit']").prop('disabled', false);
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
    </script>
@endsection