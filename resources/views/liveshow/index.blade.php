@extends('layouts.header')
@section('content')

<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading px-4">
            <div>Shows</div>
            <!-- START Language list-->
        </div>
        <div class="card m-3 border">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="m-0">Live Shows</h4>
                    </div>
                    <div class="col-4 text-right ">
                        <button class="btn btn-info " type="button" onclick="goBack()">{{__('Back')}}</button>
                    </div>
                </div>
            </div>
            <div class="">
                <!-- Datatable Start-->
                <table class="table table-striped table-responsive table_mob my-4 w-100" id="datatable1">
                    <thead>
                        <tr>
                            <th>Thumbnail</th>
                            <th>Show Title</th>
                            <th>Subscribers Count</th>
                            <th>Questions Count</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shows as $show)
                        <tr class="gradeX">
                            <td><img src="{{ (!empty($show->banner))?$show->banner:asset('img/avatarEmpty.png') }}" class="width-80" alt="Show banner"></td>
                            <td>{{ $show->title }}</td>
                            <td><a href="{{ route('subscribedShowUsers',$show->id) }}" class="text-warning" style="text-decoration:none"><i class="fas fa-bookmark"></i> {{ $show->subscribed_users_count }}</a></td>
                            <td><a href="{{ route('showQuestions',$show->id) }}" class="text-primary" style="text-decoration:none"><i class="fa fa-file"></i> {{ $show->show_questions_count }}</a></td>
                            <td class="text-right">
                                <button class="mb-1 btn btn-danger make_show_stop" type="button" data-id="{{$show->id}}" title="Stop Now"><i class="fa fa-stop"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Datatable Start-->
            </div>
        </div>
    </div>
</section>

@endsection

@section('modals')

@endsection

@section('script')
<script>
    $(document).on('click', ".make_show_stop", function() {
        var thiss = $(this);
        var data_id = thiss.data('id');
        swal({
            title: "Are you sure!",
            text: "You want to remove this show from live list",
            icon: "warning",
            buttons: ["Cancel", "Yes"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{route('liveShowListing')}}" + '/stop/' + data_id,
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        var result = response;
                        if (result.status == 1) {
                            swal('Success', result.message, 'success');
                            thiss.parents('td').find('.make_show_stop').remove();
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