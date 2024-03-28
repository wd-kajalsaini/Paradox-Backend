@extends('layouts.header')
@section('content')

<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading px-4">
            <div>Shows related to Banner</div>
        </div>
        <div class="row mt-3">
            <div class="col-xl-8 ms-3">
                <div class="card border m-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-10 ">
                                <h4 class="">Shows List</h4>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table_mob">
                        <!-- Datatable Start-->
                        <table class="table table-striped my-4 w-100" id="data-table">
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
            <div class="col-xl-4">
                <div class="card border m-3">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-10 ">
                                <h4 class="mt-3">Edit Banner Shows</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form id="" action="{{ route('bannerShowsListing') }}" method="POST">
                                    @csrf
                                    <div class="form-group row mb-3">
                                        <label for="inputEmail3" class="col-12 col-form-label "><span class="text-danger">*</span>Shows:</label>
                                        <div class="col-12">
                                            <select multiple id="showselection" name="shows[]" class="form-control ctSelectBox1" required="">
                                                @foreach($overall_shows as $show)
                                                <option value="{{ $show->id }}" data-image="{{ !empty($show->banner)?$show->banner:asset('img/avatarEmpty.png') }}" <?php if (in_array($show->id, $selected_shows)) {
                                                                                                                                                                        echo "selected";
                                                                                                                                                                    } ?>>
                                                    {{ $show->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-content-save"></i> Save</button>
                                    </div>
                                </form>
                            </div> <!-- end card-box-->
                        </div>
                    </div>

                </div>
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
            $.post("{{ route('bannerShowSorting') }}", {
                orderArray: array,
                "_token": "{{ csrf_token() }}"
            });
            $.notify("Shows re-order successfully", "success");
        }
    })

    function formatState(state) {
        if (!state.id) return state.text; // optgroup

        var originalOption = state.element;

        var option = "<span style='display:inline-block;' class='show_box'><img class='mr-2 rounded' src='" + $(originalOption).data('image') + "' /></span> " + state.text;
        return option;
        //console.log(state.text);
    }

    $(".ctSelectBox1").select2({
        templateResult: formatState,
        //formatSelection: format,
        placeholder: "Select show(s)",
        escapeMarkup: function(m) {
            return m;
        }
    });
</script>
@endsection