@extends('layouts.header')
@section('content')

<!---Side Bar End-->
<!-- Main section-->
<section id="sectionManager" class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <!-- Start ManagerInfo Form --->
        <form action="{{route('editManager',$manager->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="content-heading px-4 d-block d-md-flex">
                <div class="text-dark">{{__('System')}}/{{__('Managers')}}/{{__('Edit')}}</div><!-- START Language list-->
                <div class="ml-auto mt-3 mt-md-0">
                    <button class="btn btn-info" type="submit">{{__('Update')}}</button>
                    <button class="btn btn-info" type="button" onclick="goBack()">{{__('Back')}}</button>
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
                                <div class="card p-4 b-01">
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('Login Info')}}</h3>
                                    </div>
                                    <div class="card-body p-0 -md-2">
                                        <div class="row">
                                            @if($manager->role!=="Admin")
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Manager Type')}}</label>

                                                    <select class="form-control  @error('manager_type') is-invalid @enderror" style="border-right: 1px solid  red;" name="manager_type" required>
                                                        <option value="">{{__('Choose')}}....</option>
                                                        @foreach($managersTypes as $managersType)
                                                        <option value="{{$managersType->id}}" {{ $manager->managerType->id == $managersType->id ?"selected":""  }}>{{$managersType->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('manager_type'))
                                                    <span class="text-danger">{{ $errors->first('manager_type') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-form-label">{{__('Status')}}</label>
                                                <select style="border-right: 1px solid  red;" class="form-control  @error('status') is-invalid @enderror" name="status" required>
                                                    <option value="">{{__('Choose')}}....</option>
                                                    <option value="Active" {{ $manager->status == "Active"?"selected":""  }}>{{__('Active')}}</option>
                                                    <option value="Inactive" {{ $manager->status == "Inactive"?"selected":""  }}>{{__('Inactive')}}</option>
                                                </select>
                                                @if ($errors->has('status'))
                                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                                @endif
                                            </div>
                                            @endif
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Password')}}</label>
                                                    <input class="form-control" name="password" value="{{old('password')}}" type="password">
                                                    @if ($errors->has('password'))
                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Confirm Password')}}</label>
                                                    <input class="form-control" name="confirm_password" value="{{old('confirm_password')}}" type="password">
                                                    @if ($errors->has('confirm_password'))
                                                    <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <span class=" text-muted">{{__('Password format')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- END card-->
                            </div>


                            <div class="col-lg-6">
                                <!-- START card-->
                                <div class="card p-4 b-01">
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('User Info')}}</h3>
                                    </div>
                                    <div class="card-body p-0 p-md-2">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('First Name')}}</label>
                                                    <input class="form-control  @error('first_name') is-invalid @enderror" style="border-right: 1px solid  red;" name="first_name" type="text" value="{{$manager->first_name}}" required>
                                                    @if ($errors->has('first_name'))
                                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Last Name')}}</label>
                                                    <input class="form-control  @error('last_name') is-invalid @enderror" style="border-right: 1px solid  red;" name="last_name" type="text" value="{{$manager->last_name}}" required>
                                                    @if ($errors->has('last_name'))
                                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Phone Number')}}</label>
                                                    <input class="form-control  @error('phone') is-invalid @enderror" style="border-right: 1px solid  red;" name="phone" type="phone" value="{{$manager->phone}}" required>
                                                    @if ($errors->has('phone'))
                                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Email Address')}}</label>
                                                    <input class="form-control  @error('email') is-invalid @enderror" style="border-right: 1px solid  red;" name="email" type="email" value="{{old('email')!=''?old('email'):$manager->email}}" required>
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
                                                        <img src="{{ (!empty($manager->image) && @getimagesize($manager->image))?$manager->image:asset('img/avatarEmpty.png')}}" id="extension_avatar">
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