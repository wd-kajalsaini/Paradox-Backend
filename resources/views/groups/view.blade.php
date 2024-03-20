@extends('layouts.header')
@section('content')

<!-- Main section-->
<section  class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            <div class="text-dark">{{__('Group Info')}}</div><!-- START Language list-->
            <!--div class="ml-auto">
               <div class="btn-group"><button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown">English</button>
                  <div class="dropdown-menu dropdown-menu-right-forced animated fadeInUpShort" role="menu"><a class="dropdown-item" href="#" data-set-lang="en">English</a><a class="dropdown-item" href="#" data-set-lang="es">Spanish</a></div>
               </div>
            </div--><!-- END Language list-->
        </div><!-- START cards box-->

        <div class="p-3">
            <div class="row ">

                <div class="col-sm-12">
                    <!-- Table Card Start-->
                    <div class="card pl-0 pr-0 border">

                        <div class="row p-4">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Id')}}</label>
                                    <div class="form-control">{{ $groupDetail->id }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Group Name')}}</label>
                                    <div class="form-control">{{ $groupDetail->name }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">{{__('No. of contacts')}}</label>
                                    <div class="form-control">{{ $groupDetail->group_members_count }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">{{__('User Created')}}</label>
                                    <div class="form-control">{{ $groupDetail->owner['first_name']. " ".$groupDetail->owner['last_name'] }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label">{{__('Group image')}}</label>
                                    <div class="uploadAvatarImage">
                                        <img src="{{ !empty($groupDetail->image) && file_exists(public_path().'/images/groups/'.$groupDetail->image)?asset('/public/images/groups/'.$groupDetail->image):asset('public/img/kvitelEmpty.png')}}">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- <div class="row p-4"> -->
                            <div class="col-sm-12 pb-0">
                                <h4 class="">{{ __('Group contacts and permission')}}</h4>
                            </div>
                        <!-- </div> -->
                        <div class="table-responsive">
                            <!-- Datatable Start-->
                            <table class="table table-striped table-hover my-4 w-100" id="datatable1">
                                <thead>
                                    <tr>
                                        <th data-priority="1">{{__('Id')}}</th>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Phone')}}</th>
                                        <th>{{__('Image')}}</th>
                                        <th>{{__('Is Owner')}}</th>
                                        <th>{{__('Is Admin')}}</th>
                                        <th>{{__('Can See')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($groupDetail->group_members as $member)
                                    <tr>
                                        <td>{{ (!empty($member->user_id))?$member->user_id:"" }}</td>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->phone }}</td>
                                        <td><img src="{{ !empty($member->avatar) && file_exists(public_path().'/images/users/'.$member->avatar)?asset('/public/images/users/'.$member->avatar):asset('public/img/kvitelEmpty.png')}}" width="80" height="80" class="rounded-circle"></td>
                                        <td>{{ ($member->is_owner)?"Yes":"No" }}</td>
                                        <td>{{ ($member->is_admin)?"Yes":"No" }}</td>
                                        <td>{{ ($member->is_can_see)?"Yes":"No" }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Datatable Start-->
                        </div>
                    </div>
                    <!-- Table Card End-->
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
