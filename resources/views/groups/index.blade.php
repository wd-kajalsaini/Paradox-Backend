@extends('layouts.header')
@section('content')

<!-- Main section-->
<section  class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading px-4">
            <div class="text-dark">{{__('Groups')}}</div><!-- START Language list-->
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
                        <div class="table-responsive">
                            <!-- Datatable Start-->
                            <table class="table table-striped table-hover my-4 w-100" id="datatable1">
                                <thead>
                                    <tr>
                                        <th data-priority="1">{{__('Id')}}</th>
                                        <th>{{__('Group name')}}</th>
                                        <th>{{__('No. of contacts')}}</th>
                                        <th>{{__('Group image')}}</th>
                                        <th>{{__('User created')}}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($groupListing as $group)
                                    <tr>
                                        <td>{{ $group->id }}</td>
                                        <td>{{ $group->name }}</td>
                                        <td>{{ $group->group_members_count }}</td>
                                        <td><img src="{{ !empty($group->image) && file_exists(public_path().'/images/groups/'.$group->image)?asset('/images/groups/'.$group->image):asset('img/kvitelEmpty.png')}}" width="80" height="80" class="rounded-circle"></td>
                                        <td>{{ $group->owner['first_name']. " ". $group->owner['last_name'] }}</td>
                                        <td class="text-right d-flex">
                                            <button class="mb-1 btn btn-danger delete_group" type="button" title="Delete" data-id="{{$group->id}}"><i class="fa fa-trash"></i></button>
                                            <a href="{{route('groupInfo',$group->id)}}"><button class="mb-1 btn btn-info" title="Group Info" type="button"><i class="fa fa-eye"></i></button></a>
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
    $(document).on('click', ".delete_group", function () {
        var thiss = $(this);
        var data_id = thiss.data('id');
        swal({
            title: "Are you sure!",
            text: "It will permanently delete this group",
            icon: "warning",
            buttons: ["Cancel", "Yes"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{route('groupsListing')}}" + '/delete/' + data_id,
                    type: "DELETE",
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function (response) {
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
</script>
@endsection
