@extends('layouts.header')
@section('content')

<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading px-4">
            <div>Players</div>
            <!-- START Language list-->
        </div>
        <div class="card m-3 border">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h4 class="m-0">All Players</h4>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('addPlayersAdd')}}">
                            <button class="btn btn-info" type="button">Create New Player</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive table_mob">
                <!-- Datatable Start-->
                <table class="table table-striped my-4 w-100" id="datatable1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Thumbnail</th>
                            <th>Description</th>
                            <th>Instagram Profile URL</th>
                            <th>Facebook Profile URL</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($players as $player)
                        <tr class="gradeX">
                            <td>{{ $player->name }}</td>
                            <td><img src="{{ (!empty($player->thumbnail))?$player->thumbnail:asset('img/avatarEmpty.png') }}" class="width-80" alt="Player Thumbnail"></td>
                            <td>{{ $player->description }}</td>
                            <td>{{ $player->instagram_profile_url }}</td>
                            <td>{{ $player->facebook_profile_url }}</td>
                            <td class="text-right">
                                <button class="mb-1 btn btn-danger delete_player" type="button" data-id="{{$player->id}}"><i class="fa fa-trash"></i> </button>
                                <a href="{{ route('editPlayer',$player->id) }}" class="mb-1 btn btn-info" type="button"><i class="fa fa-edit"></i> </button>
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
$(document).on('click', ".delete_player", function () {
    var thiss = $(this);
    var data_id = thiss.data('id');
    swal({
        title: "Are you sure!",
        text: "It will permanently delete this player",
        icon: "warning",
        buttons: ["Cancel", "Yes"],
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "{{ route('playersListing') }}" + '/delete/' + data_id,
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
