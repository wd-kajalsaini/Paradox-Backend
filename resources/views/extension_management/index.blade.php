@extends('layouts.header')
@section('content')

<!-- Main section-->
<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading px-4">
            <div>Country Extensions</div><!-- START Language list-->
            <div class="ml-auto">
                <a href="{{route('exportExtension')}}"><button class="btn btn-purple btn-lg" type="button">Export Sample</button></a>
                <button class="btn btn-purple btn-lg import_    button" type="button">Import Excel</button>
                <form id="import_form" enctype="multipart/form-data" style="display:none" method="POST" action="{{route('importExtension')}}">
                    @csrf
                    <input type="file" name="iExtension" class="import_file" accept=".xlsx">
                </form>
                <a href="{{route('addCountryExtensionAdd')}}"><button class="btn btn-purple btn-lg" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button></a>
            </div>
            <!-- END Language list-->
        </div><!-- START cards box-->

        <div class="p-3">
            <div class="card pl-0 pr-0  border bg-white">
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
                        <div class="">
                            <div class="">
                                <!-- Datatable Start-->
                                <div class="">
                                    <table class="table table-striped table-responsive table_mob my-4 w-100" id="datatable1">
                                        <thead>
                                            <tr>
                                                <th data-priority="1">{{__('Id')}}</th>
                                                <th>{{__('Extension')}}</th>
                                                <th>{{__('Country')}}</th>
                                                <th>{{__('Country Code')}}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($country_extensions as $country_extension)
                                            <tr>
                                                <td>{{ $country_extension->id }}</td>
                                                <td>{{ $country_extension->extension }}</td>
                                                <td>{{ $country_extension->country }}</td>
                                                <td>{{ $country_extension->country_code }}</td>
                                                <td class="text-right">
                                                    <button class="mb-1 btn btn-danger delete_extension" type="button" title="Delete" data-id="{{$country_extension->id}}"><i class="fa fa-trash"></i></button>
                                                    <a href="{{route('editCountryExtension',$country_extension->id)}}" title="Edit"><button class="mb-1 btn btn-info" type="button"><i class="fa fa-edit"></i> </button></a>
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

<script>
    $(".delete_extension").on('click', function() {
        var thiss = $(this);
        var data_id = thiss.data('id');
        swal({
            title: "Are you sure!",
            text: "It will permanently delete this extension",
            icon: "warning",
            buttons: ["Cancel", "Yes"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{route('extensionManagementListing')}}" + '/delete/' + data_id,
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
    $(document).on('click', '.import_button', function() {
        $('.import_file').trigger('click');
    })
    $(document).on('change', '.import_file', function() {
        $('#import_form').submit();
    })
</script>
@endsection