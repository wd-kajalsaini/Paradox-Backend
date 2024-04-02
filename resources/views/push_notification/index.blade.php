@extends('layouts.header')
@section('content')

<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading px-4">
            <div>{{__('Push Notifications')}}</div><!-- START Language list-->
            <!-- END Language list-->
            <div class="ml-auto">
                <a href="{{ route('sendPushNotificationAdd')}}"><button class="btn btn-info" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button></a>
            </div>
        </div><!-- START cards box-->

        <div class="p-3">
            <div class="">
                @if (Session::has('import_error'))
                <div class="alert alert-warning alert-dismissible show" role="alert">
                    <?php print_r(Session::get('import_error')); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif


                <div class="row">

                    <div class="col-sm-12 ">
                        <!-- Table Card Start-->
                        <div class="card pl-0 pr-0 border">
                            <div class=" ">
                                <!-- Datatable Start-->
                                <div class="border-0">
                                    <table class="table table-striped table-responsive table_mob my-4 w-100" id="datatable1">
                                        <thead>
                                            <tr>
                                                <th data-priority="1">{{__('Id')}}</th>
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Text')}}</th>
                                                <th colspan="2">{{__('Received Device')}}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($notification_data as $notification)
                                            <tr>
                                                <td>{{ $notification->id }}</td>
                                                <td>{{ $notification->title }}</td>
                                                <td>{{ (strlen($notification->text) < 100)?$notification->text:substr($notification->text, 0, 95)." . . ." }}</td>
                                                <td>
                                                    <span class="text-primary">Iphone: </span> {{ $notification->iphone_received }}
                                                </td>
                                                <td>
                                                    <span class="text-success"> Android: </span> {{ $notification->android_received }}
                                                </td>
                                                <td>
                                                    <button class="mb-1 btn btn-info resend_notification" type="button" title="Resend" data-id="{{ $notification->id }}">Resend</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!--Datatable Start-->
                            </div>
                        </div>
                        <!-- Table Card End-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('modals')

@endsection

@section('script')
<script>
    $(".resend_notification").on('click', function() {
        var thiss = $(this);
        var data_id = thiss.data('id');
        swal({
            title: "Are you sure!",
            text: "You want to resend the same notification.",
            icon: "warning",
            buttons: ["Cancel", "Yes"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{route('pushNotificationListing')}}" + '/resend/' + data_id,
                    type: "POST",
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
                    error: function() {
                        swal('Error', "Something went wrong", 'error');
                    }
                });
                return true;
            } else {
                return false;
            }
        })
    })
</script>
@endsection