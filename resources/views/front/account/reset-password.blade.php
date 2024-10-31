@extends('front.layouts.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                    <p>{{ Session::get('success') }}</p>
                    </div>
                @endif
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Reset password</h1>
                    @if (Session()->has('error'))
                        <p class="text-danger alert alert-danger">{{ Session('error') }}</p>
                    @endif
                    <form action="{{ route("account.processResetPassword") }}" method="post">
                        @csrf
                        {{-- @dd($token->token) --}}
                        <input type="hidden" name="token" value="{{ $token->token }}" id="">
                        <div class="mb-3">
                            <label for="" class="mb-2">New Password*</label>
                            <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror"  placeholder="New Password">
                            @error('new_password')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div> 
                        <div class="mb-3">
                            <label for="" class="mb-2">Confirm Password*</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password">
                            @error('password_confirmation')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div> 
                        <div class="justify-content-between d-flex">
                        <button class="btn btn-primary mt-2">Submit</button>
                            <a href="{{ route('account.forgot-password') }}" class="mt-3">Forgot Password?</a>
                        </div>
                    </form>                    
                </div>
                <div class="mt-4 text-center">
                    <p>Do not have an account? <a  href="{{ route("account.registration") }}">Register</a></p>
                </div>
            </div>
        </div>
        <div class="py-lg-5">&nbsp;</div>
    </div>
</section>

@endsection

@section('customJs')
@endsection