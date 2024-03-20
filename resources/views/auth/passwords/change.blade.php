@extends('layouts.header')
@section('content')

      <!-- Main section-->
      <section  id="sectionManager"class="section-container">
         <!-- Page content-->
         <div class="content-wrapper">
           <!-- Start ManagerInfo Form --->

            <div class="card  col-8 offset-md-2">
                <div class="card-header text-center h4 mt-4">{{ __('Change Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('changePassword') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>

                            <div class="col-md-6">
                                <input id="cpassword" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" value="{{old('current_password')}}" required autocomplete="new-password">

                                @if ($errors->has('current_password'))
                                    <span class="text-danger">{{ $errors->first('current_password') }}</span>
                                @endif 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                            <div class="col-md-6">
                                <input id="npassword" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" value="{{old('new_password')}}" required autocomplete="new-password">
                                @if ($errors->has('new_password'))
                                    <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                @endif
                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm New Password') }}</label>

                            <div class="col-md-6">
                                <input id="c-password-confirm" type="password" class="form-control @error('confirm_new_password') is-invalid @enderror" name="confirm_new_password" value="{{old('confirm_new_password')}}" required autocomplete="new-password">
                                @if ($errors->has('confirm_new_password'))
                                    <span class="text-danger">{{ $errors->first('confirm_new_password') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
      </section>
@endsection
