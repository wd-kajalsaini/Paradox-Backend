@extends('layouts.header')
@section('content')

<!-- Main section-->
<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            <div>{{__('Kvitel Products')}}</div><!-- START Language list-->
            <div class="ml-auto">
                <a href="{{route('addKvitelProductAdd')}}"><button class="btn btn-purple btn-lg" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button></a>
            </div>
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
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Description')}}</th>
                                                <th>{{__('Price')}}</th>
                                                <th>{{__('Is Best')}}</th>
                                                <th>{{__('Logo')}}</th>
                                                <th>{{__('Length')}}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($kvitel_products as $kvitel_product)
                                            <tr>
                                                <td>{{ $kvitel_product->id }}</td>
                                                <td>{{ $kvitel_product->title }}</td>
                                                <td>{{ $kvitel_product->description }}</td>
                                                <td>{{ $kvitel_product->price }}</td>
                                                <td>{{ !empty($kvitel_product->is_best)?"Yes":"No" }}</td>
                                                <td><?php if (!empty($kvitel_product->logo)) {
                                                        echo "<img src='" . $kvitel_product->logo . "' class='roundimg smallimg' height='30'>";
                                                    } ?></td>
                                                <td>{{ $kvitel_product->length }}</td>
                                                <td class="text-right">
                                                    <button class="mb-1 btn btn-danger delete_product" type="button" title="Delete" data-id="{{$kvitel_product->id}}"><i class="fa fa-trash"></i></button>
                                                    <a href="{{route('editKvitelProduct',$kvitel_product->id)}}" title="Edit"><button class="mb-1 btn btn-info" type="button"><i class="fa fa-edit"></i> </button></a>
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
    $(document).on('click', ".delete_product", function() {
        var thiss = $(this);
        var data_id = thiss.data('id');
        swal({
            title: "Are you sure!",
            text: "It will permanently delete this product",
            icon: "warning",
            buttons: ["Cancel", "Yes"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{route('kvitelProductsListing')}}" + '/delete/' + data_id,
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