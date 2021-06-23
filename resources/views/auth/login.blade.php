@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column justify-content-between vh-100">
    <div class="row justify-content-center mt-5">
        <div class="col-xl-5 col-lg-6 col-md-10">

            <div class="card">
                <div class="card-header bg-primary">
                    <div class="app-brand">
                        <a href="/index.html">
                          <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30" height="33"
                            viewBox="0 0 30 33">
                            <g fill="none" fill-rule="evenodd">
                              <path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" />
                              <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                            </g>
                          </svg>
                          <span class="brand-name">Aplikasi Inventory</span>
                        </a>
                      </div>
                </div>

                <div class="card-body p-5">
                    <h4 class="text-dark mb-5">{{ __('Login') }}</h4>
                    <form method="POST" action="{{ route('login') }}">
                        <div class="row">
                            @csrf

                            <div class="form-group col-md-12 mb-4">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Username" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>

                            <div class="form-group col-md-12">

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                               
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex my-2 justify-content-between">
                                     <div class="d-inline-block mr-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>

                                        </div>
                                     </div>
                                       @if (Route::has('password.request'))
                                            <a class="text-blue" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary btn-block mb-4">{{ __('Login') }}
                                </button>
                                <!-- <p>Belum mempunyai akun ?
                                    <a class="text-blue" href="sign-up.html">Sign Up</a>
                                </p>   -->   
                                    
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
