@extends('layouts.header')
@section('content')

<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            <div>Shows related to Sections</div>
            <!-- START Language list-->
        </div>
        <div class="card m-3 border">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="m-0">Shows List</h4>
                    </div>
                    <div class="col-4 text-right">
                        <button class="btn btn-info" type="button" onclick="goBack()">Back</button>

                    </div>
                </div>
            </div>
            <div class="">
                <!-- Datatable Start-->
                <table class="table  table-striped table_mob my-4 w-100 table-responsive" id="data-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Thumbnail</th>
                            <th>Show Title</th>
                            <th>Show Date </th>
                            <th>Show Timing </th>
                            <th>Expiry Date</th>
                        </tr>
                    </thead>
                    <tbody class="sortable">
                        @if(!$shows->isEmpty())
                        @foreach($shows as $show)
                        <tr class="gradeX" data-id="{{ $show->id }}" data-order="{{ $show->sort_order }}">
                            <td><i class="fa fa-bars pt-2 font-20"></i></td>
                            <td><img src="{{ (!empty($show->show_list->banner))?$show->show_list->banner:asset('img/avatarEmpty.png') }}" class="width-80" alt="Show banner"></td>
                            <td>{{ $show->show_list->title }}</td>
                            <td>{{ date('d F, Y', strtotime($show->show_list->date)) }}</td>
                            <td>{{ $show->show_list->start_time.' - '.$show->show_list->end_time }}</td>
                            <td>{{ date('d F, Y', strtotime($show->show_list->expiry_date)) }}</td>
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

            var array = [];
            $("#data-table > tbody").find("tr").each(function(index) {
                orderObject = {
                    "data_id": $(this).attr('data-id'),
                    "data_order": $(this).attr('data-order')
                }
                array.push(orderObject);
            })
            $.post("{{ route('sectionShowSorting') }}", {
                orderArray: array,
                "_token": "{{ csrf_token() }}"
            });
            $.notify("Shows re-order successfully", "success");
        }
    })
</script>
@endsection