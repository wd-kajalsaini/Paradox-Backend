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
                    <div class="col-4 ">
                        <h4 class="m-0">All Shows</h4>
                    </div>
                    <div class="col-8 text-right">
                        <a href="{{ route('addShowAdd')}}">
                            <button class="btn  btn-info" type="button">Create New Show</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class=" table-responsive table_mob">
                <!-- Datatable Start-->
                <table class="table table-striped my-4 w-100" id="datatable1">
                    <thead>
                        <tr>
                            <th>Thumbnail</th>
                            <th>Show Title</th>
                            <th>Show Date </th>
                            <th>Show Timing </th>
                            <th>Expiry Date</th>
                            <th>Subscribers Count</th>
                            <th>Questions Count</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shows as $show)

                        <tr class="gradeX">
                            <td><img src="{{ (!empty($show->banner))?$show->banner:asset('simg/avatarEmpty.png') }}" class="width-80" alt="Show banner"></td>
                            <td>{{ $show->title }}</td>
                            <td>{{ date('d F, Y', strtotime($show->date)) }}</td>
                            <td>{{ $show->start_time.' - '.$show->end_time }}</td>
                            <td>{{ date('d F, Y', strtotime($show->expiry_date)) }}</td>
                            <td ><a href="{{ route('subscribedShowUsers',$show->id) }}" class="text-warning" style="text-decoration:none"><i class="fas fa-bookmark"></i> {{ $show->subscribed_users_count }}</a></td>
                            <td ><a href="{{ route('showQuestions',$show->id) }}" class="text-primary" style="text-decoration:none"><i class="fa fa-file"></i> {{ $show->show_questions_count }}</a></td>
                            <td class="text-right">
                                <button class="mb-1 btn btn-danger delete_show" type="button" data-id="{{$show->id}}" title="Delete"><i class="fa fa-trash"></i> </button>
                                <a href="{{ route('editShow',$show->id) }}" class="mb-1 btn btn-info" type="button" title="Edit"><i class="fa fa-edit"></i></a>
                                @if(is_null($show->live_at))
                                <button class="mb-1 btn btn-success make_show_live" type="button" data-id="{{$show->id}}" title="Live Now"><i class="fa fa-play"></i></button>
                                @endif
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
$(document).on('click', ".delete_show", function () {
    var thiss = $(this);
    var data_id = thiss.data('id');
    swal({
        title: "Are you sure!",
        text: "It will permanently delete this show",
        icon: "warning",
        buttons: ["Cancel", "Yes"],
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "{{route('showsListing')}}" + '/delete/' + data_id,
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

$(document).on('click', ".make_show_live", function () {
    var thiss = $(this);
    var data_id = thiss.data('id');
    swal({
        title: "Are you sure!",
        text: "You want to make the show live",
        icon: "warning",
        buttons: ["Cancel", "Yes"],
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $('#loader').show();
            $.ajax({
                url: "{{route('showsListing')}}" + '/make_show_live/' + data_id,
                type: "POST",
                data: {"_token": "{{ csrf_token() }}"},
                success: function (response) {
                    var result = response;
                    $('#loader').hide();
                    if (result.status == 1) {
                        swal('Success', result.message, 'success');
                        thiss.parents('td').find('.make_show_live').remove();
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
