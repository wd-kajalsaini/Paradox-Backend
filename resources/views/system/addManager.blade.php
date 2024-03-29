@extends('layouts.header')
@section('content')

<!---Side Bar End-->
<!-- Main section-->
<section id="sectionManager" class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <!-- Start ManagerInfo Form --->
        <form action="{{route('addManagerAdd')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="content-heading px-4 d-block d-md-flex ">
                <div>{{__('System')}}/{{__('Managers')}}/{{__('Add')}}</div><!-- START Language list-->
                <div class="ml-auto mt-4 mt-md-2">
                    <button class="btn btn-info btn-lg  " type="submit">{{__('Save')}}</button>
                    <button class="btn btn-info btn-lg " type="button" onclick="goBack()">{{__('Back')}}</button>
                </div><!-- END Language list-->
            </div><!-- START cards box-->

            <div class="pt-4 bg-white">
                <!-- Nav tabs-->
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link bb0 active" href="#home" aria-controls="home" role="tab" data-toggle="tab" aria-selected="true">
                            {{__('Manager Info')}}
                        </a>
                    </li>
                </ul><!-- Tab panes-->

                <div class="tab-content p-0 bg-white">
                    <div class="tab-pane active" id="home" role="tabpanel">
                        <div class="row p-4">
                            <div class="col-lg-6">
                                <!-- START card-->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('Login Info')}}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Manager Type')}}</label>

                                                    <select class="form-control @error('manager_type') is-invalid @enderror" name="manager_type" style="border-right: 1px solid  red;" required>
                                                        <option value="">{{__('Choose')}}....</option>
                                                        @foreach($managersTypes as $managersType)
                                                        <option value="{{$managersType->id}}" {{ old('manager_type') == $managersType->id ?"selected":""  }}>{{$managersType->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('manager_type'))
                                                    <span class="text-danger">{{ $errors->first('manager_type') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">{{__('Status')}}</label>
                                                <select class="form-control @error('status') is-invalid @enderror" style="border-right: 1px solid  red;" name="status" required>
                                                    <option value="">{{__('Choose')}}....</option>
                                                    <option value="Active" {{ old('status') == "Active"?"selected":""  }}>{{__('Active')}}</option>
                                                    <option value="Inactive" {{ old('status') == "Inactive"?"selected":""  }}>{{__('Inactive')}}</option>
                                                </select>
                                                @if ($errors->has('status'))
                                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Password')}}</label>
                                                    <input class="form-control @error('password') is-invalid @enderror" name="password" style="border-right: 1px solid  red;" value="{{old('password')}}" type="password" required>

                                                    @if ($errors->has('password'))
                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Confirm Password')}}</label>
                                                    <input class="form-control @error('confirm_password') is-invalid @enderror" style="border-right: 1px solid  red;" name="confirm_password" value="{{old('confirm_password')}}" type="password" required>
                                                    @if ($errors->has('confirm_password'))
                                                    <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-12 mt-4">
                                                <span class=" text-muted">{{__('Password format')}}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div><!-- END card-->
                            </div>


                            <div class="col-lg-6">
                                <!-- START card-->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('User Info')}}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('First Name')}}</label>
                                                    <input class="form-control @error('first_name') is-invalid @enderror" style="border-right: 1px solid  red;" name="first_name" type="text" value="{{old('first_name')}}" required>
                                                    @if ($errors->has('first_name'))
                                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Last Name')}}</label>
                                                    <input class="form-control @error('last_name') is-invalid @enderror" style="border-right: 1px solid  red;" name="last_name" type="text" value="{{old('last_name')}}" required>
                                                    @if ($errors->has('last_name'))
                                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Phone Number')}}</label>
                                                    <input class="form-control @error('phone') is-invalid @enderror" style="border-right: 1px solid  red;" name="phone" type="phone" value="{{old('phone')}}" required>
                                                    @if ($errors->has('phone'))
                                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Email Address')}}</label>
                                                    <input class="form-control @error('email') is-invalid @enderror" style="border-right: 1px solid  red;" name="email" type="email" value="{{old('email')}}" required>
                                                    @if ($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-sm-6 text">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Avatar Image (Click icon to upload)')}}</label>
                                                    <input class="form-control" type="hidden" id="extension_icon" name="image">
                                                    <div class="uploadAvatarImage">
                                                        <img src="{{ asset('img/avatarEmpty.png') }}" id="extension_avatar" onclick="selectFileWithCKFinder('extension_icon', 'extension_avatar')">
                                                    </div>
                                                    @if ($errors->has('image'))
                                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div><!-- END card-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- End ManagerInfo Form --->
    </div>
</section>
@endsection