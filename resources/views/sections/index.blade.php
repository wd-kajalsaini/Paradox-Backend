@extends('layouts.header')
@section('content')

<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            <div>App Sections</div>
            <!-- START Language list-->
        </div>
        <div class="card m-3 border">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10 ">
                        <h4 class="mt-3">All Sections</h4>
                    </div>
                    <div class="col-sm-2 text-right">
                        <a href="{{ route('addAppSectionsAdd')}}">
                            <button class="btn theme-blue-btn btn-md theme-btn mt-3" type="button">Create New Section</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="">
                <!-- Datatable Start-->
                <table class="table table-striped my-4 w-100" id="data-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Section Name</th>
                            <th>No. of Shows</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="sortable">
                        @if(!$sections->isEmpty())
                        @foreach($sections as $section)
                        <tr class="gradeX" data-id="{{ $section->id }}" data-order="{{ $section->sort_order }}">
                            <td><i class="fa fa-bars pt-2 font-20"></i></td>
                            <td>{{ $section->name }}</td>
                            <td>{{ $section->shows_count }}</td>
                            <td class="text-right">
                                <a href="{{ route('editAppSections',$section->id) }}" class="mb-1 btn btn-info" type="button"><i class="fa fa-edit"></i></a>
                                <a href="{{ route('showsRelatedToSection',$section->id) }}" class="mb-1 btn btn-warning" type="button"><i class="fa fa-eye"></i></a>
                                <button class="mb-1 btn btn-danger delete_section" type="button" data-id="{{$section->id}}"><i class="fa fa-trash"></i> </button>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="gradeX">
                            <td colspan="4" class="text-center">No record found</td>
                        </tr>
                        @endif
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
$('.sortable').sortable({
    update: function() {
        var array  = [];
        $("#data-table > tbody").find("tr").each(function(index){
            orderObject = {
                "data_id" : $(this).attr('data-id'),
                "data_order" : $(this).attr('data-order')
            }
            array.push(orderObject);
        })
        $.post("{{ route('appSectionsSorting') }}",{ orderArray: array, "_token": "{{ csrf_token() }}"});
        $.notify("Section re-order successfully", "success");
    }
})
$(document).on('click', ".delete_section", function () {
    var thiss = $(this);
    var data_id = thiss.data('id');
    swal({
        title: "Are you sure!",
        text: "It will permanently delete this section",
        icon: "warning",
        buttons: ["Cancel", "Yes"],
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "{{route('appSectionsListing')}}" + '/delete/' + data_id,
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
