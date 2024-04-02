@extends('layouts.header')
@section('content')
<style type="text/css">
    .input-group-addon {
        padding: 8px 25px;
        width: 8%;
    }

    .del_btn {
        position: absolute;
        top: 3px;
        right: 3px;
        width: 20px;
        height: 20px;
        background: red;
        text-align: center;
        line-height: 20px;
        border-radius: 100%;
        color: #fff;
        display: none;
        z-index: 999;
    }
</style>

<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading px-4">
            <div>Add New Show</div>
            <!-- START Language list-->
        </div>
        <div class="card m-3 md-m-0">
            <div class="card-header p-2">
                <div class="row align-items-center">
                    <div class="col-8 ">
                        <h4 class="m-0">New Show Details</h4>

                    </div>
                    <div class="col-4 text-right">
                        <p class="btn btn-info" onclick="goBack()">Back</p>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                </div>
            </div>
            <div class="">
                <form method="post" data-parsley-validate="" novalidate="" enctype="multipart/form-data" id="add_show">
                    @csrf
                    <div class="card-body p-2">
                        <div class="row mt-1">
                            <div class="col-4 col-md-2 p-">
                                <label for="validationCustom01">Show Title</label>
                            </div>
                            <div class="col-8 col-md-10">
                                <input type="text" class="form-control" name="title" placeholder="" value="" required>
                                <div class="invalid-feedback">Please enter title</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2 p0">
                                <label for="validationCustom01">Description</label>
                            </div>
                            <div class="col-8 col-md-10">
                                <textarea class="form-control" name="description" placeholder="" value="" required></textarea>
                                <div class="invalid-feedback">Please enter title</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2 p0">
                                <label for="validationCustom01">Show Start Time</label>
                            </div>
                            <div class="col-8 col-md-10">
                                <input type="text" class="form-control 24hours-timepicker" name="start_time" placeholder="" value="" style="background-color:white" required>
                                <div class="invalid-feedback">Please enter title</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2 p0">
                                <label for="validationCustom01">Show End Time</label>
                            </div>
                            <div class="col-8 col-md-10">
                                <input type="text" class="form-control 24hours-timepicker" name="end_time" placeholder="" value="" style="background-color:white" required>
                                <div class="invalid-feedback">Please enter title</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2 p0">
                                <label for="validationCustom01">Show Date</label>
                            </div>
                            <div class="col-8 col-md-10">
                                <div class="input-group date" id="datetimepicker1">
                                    <input class="form-control" type="text" name="date" readonly="readonly" style="background-color:white;" required="">
                                    <span class="fas fa-calendar-alt input-group-append input-group-addon">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2 p0">
                                <label for="validationCustom01">Show Expiry Date</label>
                            </div>
                            <div class="col-8 col-md-10">
                                <div class="input-group date" id="datetimepicker2">
                                    <input class="form-control" type="text" name="expiry_date" readonly="readonly" style="background-color:white;" required="">
                                    <span class="fas fa-calendar-alt input-group-append input-group-addon">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2 p0">
                                <label for="validationCustom01">Video URL </label>
                            </div>
                            <div class="col-8 col-md-10">
                                <input type="text" class="form-control" name="video_url" placeholder="" value="" required>
                                <div class="invalid-feedback">Please enter video url</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2 p0">
                                <label for="validationCustom01">Promo URL </label>
                            </div>
                            <div class="col-8 col-md-10">
                                <input type="text" class="form-control" name="promo_url" placeholder="" value="" required>
                                <div class="invalid-feedback">Please enter promo url</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2 p0">
                                <label for="validationCustom01">Team 1</label>
                            </div>
                            <div class="col-8 col-md-10">
                                <select name="team_1_id" id="team_1_dropdown" placeholder="" class="form-control ctSelectBox1" required="">
                                    <option value="">Choose team</option>
                                    @foreach($teams as $team)
                                    <option value="{{ $team->id }}" data-image="{{ !empty($team->logo)?$team->logo:asset('img/avatarEmpty.png') }}">
                                        {{ $team->title }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a team</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2 p0">
                                <label for="validationCustom01">Team 2</label>
                            </div>
                            <div class="col-8 col-md-10">
                                <select name="team_2_id" id="team_2_dropdown" placeholder="" class="form-control ctSelectBox1" required="">
                                    <option value="">Choose team</option>
                                    @foreach($teams as $team)
                                    <option value="{{ $team->id }}" data-image="{{ !empty($team->logo)?$team->logo:asset('img/avatarEmpty.png') }}">
                                        {{ $team->title }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a team</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2 p0">
                                <label for="validationCustom01">Show Banner</label>
                            </div>
                            <div class="col-8 col-md-10">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type='file' id="imgInp" name="banner" />
                                    </div>
                                    <div class="col-sm-6">
                                        <b>Preview</b>
                                        <div class="preview_thumb mt-2"><img id="blah" src="{{ asset('img/avatarEmpty.png') }}" alt="Show banner" />
                                            <div class="del_btn" id="delet_photo"><i class="fa fa-times"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <button class="btn btn-info" type="submit">Submit </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</section>

@endsection

@section('modals')

@endsection

@section('script')
<script>
    $('#datetimepicker1, #datetimepicker2').datepicker({
        startDate: new Date(),
        format: 'yyyy-mm-dd'
    });
    $('.24hours-timepicker').flatpickr({
        enableTime: !0,
        noCalendar: !0,
        dateFormat: "H:i",
        time_24hr: !0
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#imgInp").change(function() {
        readURL(this);
        $('.del_btn').show();
    });

    $("#delet_photo").click(function() {
        $('#blah').attr('src', "{{ asset('img/avatarEmpty.png') }}");
        $('.del_btn').hide();
        $("#imgInp").val("");
    });

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
        placeholder: "Select Team",
        escapeMarkup: function(m) {
            return m;
        }
    });

    $('#add_show').on('submit', function(e) {
        e.preventDefault();
        var thiss = $(this);
        var form_instance = $('form#add_show').parsley();
        if (form_instance.isValid()) {
            var dropdown_1_value = $('#team_1_dropdown').val();
            var dropdown_2_value = $('#team_2_dropdown').val();
            if (dropdown_1_value != "" && dropdown_2_value != "") {
                $.ajax({
                    url: "{{route('validateTeamPlayers')}}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'dropdown_1_value': dropdown_1_value,
                        'dropdown_2_value': dropdown_2_value
                    },
                    success: function(response) {
                        var result = response;
                        if (result.status == 0) {
                            swal('Error', result.message, 'error');
                        } else {
                            var action = thiss.attr('action');
                            var form_data = new FormData(thiss[0]);
                            console.log(form_data);
                            $.ajax({
                                url: "{{route('addShowAdd')}}",
                                type: 'POST',
                                data: form_data,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    if (response.status == 1) {
                                        window.location = "{{route('showsListing')}}";
                                    } else {
                                        swal("Error", response.message, 'error');
                                    }
                                }
                            })
                        }
                        return false;
                    },
                });
            }
        }
    })
</script>
@endsection