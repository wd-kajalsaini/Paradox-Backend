@extends('layouts.header')
@section('content')

<style type="text/css">
    /*    table.dataTable tbody th.focus, table.dataTable tbody td.focus {
        box-shadow: none !important;
        outline:0!important;
    }*/
    .modal-header {
        justify-content: normal !important;
    }

    .font-12 {
        margin-top: 5px;
        font-size: 12px;
    }

    /*    table#datatable1 tr td {
        border-top: 1px solid #ccc;
        background: #f5f5f5;
    }
    table#datatable1 tr.unread_message td{
        border-top: 1px solid #ccc;
        background: #fff !important;
        font-weight: bold;
    }*/
</style>

<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading  px-4">
            <div>{{__('Inbox')}}</div><!-- START Language list-->
            <!-- END Language list-->
        </div><!-- START cards box-->

        <div class="p-3">
            <div class="p-0">
                @if (Session::has('import_error'))
                <div class="alert alert-warning alert-dismissible show" role="alert">
                    <?php print_r(Session::get('import_error')); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif


                <div class="row">

                    <div class="col-sm-12">
                        <!-- Table Card Start-->
                        <div class="card pl-0 pr-0 border">
                            <div class=" ">
                                <!-- Datatable Start-->
                                <div class="">
                                    <table class="table table-striped table-responsive table_mob my-4 w-100" id="datatable1">
                                        <thead>
                                            <tr>
                                                <th data-priority="1">{{__('Id')}}</th>
                                                <th>{{__('User name')}}</th>
                                                <th>{{__('Date')}}</th>
                                                <th>{{__('Subject')}}</th>
                                                <th>{{__('Is New')}}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($inbox_data as $messages)
                                            <tr>
                                                <td>{{ $messages->id }}</td>
                                                <td>{{ $messages->username }}</td>
                                                <td>{{ date('d/m/Y',strtotime($messages->created_at)) }}</td>
                                                <td>{{ $messages->subject }}</td>
                                                <td class="read_status">{{ ($messages->is_read)?"No":"Yes" }}</th>
                                                <td><button class="btn btn-info show_message" data-id="{{ $messages->id }}" title="View Message"><i class="fa fa-eye"></i></button></td>
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
<div id="myModal" class="modal " tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <img class="mb-mail-avatar mr-2" alt="Mail Avatar" src="img/user/01.jpg" style="width: 30px">
                <div>
                    <h4 class="m-0">Evelyn Holmes</h4>
                    <span class="font-12">12Feb,2020 10:23PM</span>
                </div>
            </div>
            <div class="modal-body" style="max-height: 300px;">
                <b>Hi Bro...</b>
                <p>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. <Br><Br>

                    Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.<Br><Br>

                    Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar,</p>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button></div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#datatable1').on('click', '.show_message', function() {
        var thiss = $(this);
        var data_id = $(this).data('id');
        $.ajax({
            url: "{{ route('markReadAjax') }}",
            type: "POST",
            data: {
                "data_id": data_id,
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                $(document).find(".modal-content").html(response);
                $("#myModal").modal();
                thiss.parents('tr').find('td.read_status').html('No');
            }
        });
    })
</script>
@endsection