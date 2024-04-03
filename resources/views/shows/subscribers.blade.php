@extends('layouts.header')
@section('content')

<!-- Main section-->
<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            <div class="text-dark">{{__('Subscribe Users')}}</div><!-- START Language list-->
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
                        <h4 class="mt-3">Subscribe Users</h4>
                    </div>
                    <div class="col-sm-2 text-right">
                        <button class="btn btn-info mt-3" type="button" data-toggle="modal" data-target="#notificationModal">Send Notification</button>
                    </div>
                </div>
                <div class="row ">

                    <div class="col-sm-12">
                        <div class="">
                            <!-- Datatable Start-->
                            <table class="table table-striped table-responsive table_mob my-4 w-100" id="datatable1">
                                <thead>
                                    <tr>
                                        <th data-priority="1">{{__('Id')}}</th>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Phone Number')}}</th>
                                        <th>{{__('Email')}}</th>
                                        <th>{{__('Avatar')}}</th>
                                        <th>{{__('Gender')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($subscribers->subscribers))
                                    @foreach($subscribers->subscribers as $userList)
                                    <tr>
                                        <td>{{ $userList->id }}</td>
                                        <td>{{ $userList->name }}</td>
                                        <td>{{ $userList->phone_number }}</td>
                                        <td>{{ $userList->email }}</td>
                                        <td><img src="{{ !empty($userList->image) && @getimagesize($userList->image)?$userList->image:asset('img/avatarEmpty.png')}}" width="80" height="80" class="img-thumbnail rounded-circle"></td>
                                        <td>{{ $userList->gender }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
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

@section('modals')
<div class="modal" tabindex="-1" role="dialog" id="notificationModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Notification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="notification_form">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="hidden" name="show_id" value="{{$id}}">
                        <input class="form-control" type="text" name="title" placeholder="Enter notification title">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" placeholder="Enter notification description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Send</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).on('click', ".delete_user", function() {
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
                $.ajax({
                    url: "{{route('applicationUsersListing')}}" + '/delete/' + data_id,
                    type: "DELETE",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
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

    $('.active_block').click(function() {
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
        }).then(function(willYes) {
            if (willYes) {
                $.ajax({
                    url: "{{route('applicationUsersListing')}}/active_block/" + data_id,
                    method: "POST",
                    data: {
                        'status': data_status,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(result) {
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

    $("#notification_form").on('submit', function(e) {
        e.preventDefault();
        var formEl = $(this);
        var submitButton = $('button[type=submit]', formEl);
        $.ajax({
            type: 'POST',
            url: "{{route('showsListing')}}/subscriber_notification/" + "{{$id}}",
            data: formEl.serialize(),
            beforeSend: function() {
                submitButton.prop('disabled', 'disabled');
            },
            success: function(response) {
                submitButton.prop("disabled", false);
                formEl[0].reset();
                $('#notificationModal').modal('hide');
                swal(response.message, {
                    icon: "success",
                });
            }
        });
    })
</script>
@endsection