@extends('layouts.header')
@section('content')

<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading px-4">
            <div>{{__('Teams')}}</div>
            <!-- START Language list-->
        </div>
        <div class="card m-3 border">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-4">
                        <h4 class="m-0">All Teams</h4>
                    </div>
                    <div class="col-8 text-right">
                        <a href="{{ route('addTeamsAdd')}}">
                            <button class="btn btn-info" type="button">Create New Team</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="">
                <!-- Datatable Start-->
                <table class="table table-striped table-responsive table_mob my-4 w-100" id="datatable1">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Logo</th>
                            <th>No. of Players</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $team)
                        <tr class="gradeX">
                            <td>{{ $team->title }}</td>
                            <td><img src="{{ (!empty($team->logo))?$team->logo:asset('img/avatarEmpty.png') }}" class="width-80" alt="Player Thumbnail"></td>
                            <td>{{ $team->players_count }}</td>
                            <td class="text-right">
                                <button class="mb-1 btn btn-danger delete_team" type="button" data-id="{{$team->id}}"><i class="fa fa-trash"></i> </button>
                                <a href="{{ route('editTeam',$team->id) }}" class="mb-1 btn btn-info" type="button"><i class="fa fa-edit"></i> </button>
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
    $(document).on('click', ".delete_team", function() {
        var thiss = $(this);
        var data_id = thiss.data('id');
        swal({
            title: "Are you sure!",
            text: "It will permanently delete this team",
            icon: "warning",
            buttons: ["Cancel", "Yes"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('teamsListing') }}" + '/delete/' + data_id,
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
</script>
@endsection