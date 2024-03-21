@extends('layouts.header')
@section('content')

<!-- Main section-->
<section  class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            <div class="text-dark">{{__('Application Users')}}</div><!-- START Language list-->
            <!--div class="ml-auto">
               <div class="btn-group"><button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown">English</button>
                  <div class="dropdown-menu dropdown-menu-right-forced animated fadeInUpShort" role="menu"><a class="dropdown-item" href="#" data-set-lang="en">English</a><a class="dropdown-item" href="#" data-set-lang="es">Spanish</a></div>
               </div>
            </div--><!-- END Language list-->
        </div><!-- START cards box-->

        <div class="p-3">
                    <!-- Table Card Start-->
                    <div class="card pl-0 pr-0 border">
                        <div class="card-header">
                            <div class="col-sm-10 ">
                                <h4 class="mt-3">All Users</h4>
                            </div>
                            <div class="col-sm-2 text-right">
                                <a href="{{ route('addUser') }}">
                                    <button class="btn theme-blue-btn btn-md theme-btn mt-3" type="button">Create New User</button>
                                </a>
                            </div>
                        </div>
                        <div class="row ">

                            <div class="col-sm-12">
                        <div class="table-responsive">
                            <!-- Datatable Start-->
                            <table class="table table-striped table-hover my-4 w-100" id="datatable1">
                                <thead>
                                    <tr>
                                        <th data-priority="1">{{__('Id')}}</th>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Phone Number')}}</th>
                                        <th>{{__('Email')}}</th>
                                        <th>{{__('Avatar')}}</th>
                                        <th>{{__('Gender')}}</th>
                                        <th>{{__('Device Type')}}</th>
                                        <th>{{__('App version')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($userListing as $userList)
                                    <tr>
                                        <td>{{ $userList->id }}</td>
                                        <td>{{ $userList->name }}</td>
                                        <td>{{ $userList->phone_number }}</td>
                                        <td>{{ $userList->email }}</td>
                                        <td><img src="{{ !empty($userList->image) && @getimagesize($userList->image)?$userList->image:asset('img/avatarEmpty.png')}}" width="80" height="80" class="img-thumbnail rounded-circle"></td>
                                        <td>{{ $userList->gender }}</td>
                                        <td>{{ $userList->device_type }}</td>
                                        <td>{{ $userList->app_version }}</td>
                                        <td class="active_status">{{ $userList->status }}</td>
                                        <td class="text-right d-flex">
                                            <button class="btn btn-danger delete_user" type="button" title="Delete" data-id="{{$userList->id}}"><i class="fa fa-trash"></i></button>
                                            <a href="{{route('editUserInfo',$userList->id)}}"><button class="btn btn-info" type="button"><i class="fa fa-edit"></i></button></a>
                                            <button type="button" class="btn btn-success waves-effect waves-light active_block" data-id="{{ $userList->id }}" data-status="Active" style="{{ ($userList->status == 'Active') ? "display:none" : "" }}" title="Make user active">
                                                <i class="fas fa-user-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger waves-effect waves-light active_block" data-id="{{ $userList->id }}" data-status="Block" style="{{ ($userList->status == 'Active') ? "" : "display:none" }}" title="Make user block">
                                                <i class="fas fa-user-times"></i>
                                            </button>
                                        </td>
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

@section('script')
<script>
    $(document).on('click', ".delete_user", function () {
        var thiss = $(this);
        var data_id = thiss.data('id');
        swal({
            title: "Are you sure!",
            text: "It will permanently delete this user",
            icon: "warning",
            buttons: ["Cancel", "Yes"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $('#loader').modal('show');
                $.ajax({
                    url: "{{route('applicationUsersListing')}}" + '/delete/' + data_id,
                    type: "DELETE",
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function (response) {
                        $('#loader').modal('show');
                        var result = response;
                        if (result.status == 1) {
                            window.location = "";
                        } else {
                            swal('Error', result.message, 'error');
                        }
                        return false;
                    },
                });
                return true;
            } else {
                return false;
            }
        })
    })

    $('.active_block').click(function () {
        var thiss = $(this);
        var data_id = $(this).attr('data-id');
        var data_status = $(this).attr('data-status');
        if (data_status == 'Active') {
            confirmTxt = "You want to make it active!";
        } else {
            confirmTxt = "You want to make it block!";
        }
        swal({
            title: "Are you sure?",
            text: confirmTxt,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(function (willYes) {
            if (willYes) {
                $('#loader').modal('show');
                $.ajax({
                    url: "{{route('applicationUsersListing')}}/active_block/"+data_id,
                    method: "POST",
                    data: {'status': data_status, "_token": "{{ csrf_token() }}"},
                    success: function (result) {
                        $('#loader').modal('hide');
                        if (result.status == 1) {
                            $(".active_block[data-id='" + data_id + "']").hide();
                            $(".active_block[data-id='" + data_id + "']").not("[data-status='" + data_status + "']").show();
                            swal("Success!", result.message, "success");
                        } else {
                            swal("Error!", result.message, "error");
                        }
                        thiss.parents('tr').find('td.active_status').html(result.response_status);
                    }
                })
            }
        })
    })
</script>
@endsection
