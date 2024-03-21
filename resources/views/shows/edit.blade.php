@extends('layouts.header')
@section('content')
<style type="text/css">
.input-group-addon
{
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
        <div class="content-heading">
            <div>Edit Show</div>
            <!-- START Language list-->
        </div>
        <div class="p-3">
            <div class="row">
                <div class="col-xl-4">
                    <!-- START card-->
                    <div class="card bg-warning-dark border-0" style="padding:0px">
                        <div class="row align-items-center mx-0">
                            <div class="col-4 text-center"><em class="fas fa-bookmark fa-2x"></em></div>
                            <div class="col-8 py-4 bg-warning rounded-right">
                                <div class="h1 m-0 text-bold">{{ $show->subscribed_users_count }}</div>
                                <div class="mb-4">Total Subscribers</div>
                                <a href="{{ route('subscribedShowUsers',$show->id) }}" style="color: white;"><p>View Subscribers <i class="fa fa-caret-right ml-1"></i></p></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <!-- START card-->
                    <div class="card bg-primary-dark border-0" style="padding:0px">
                        <div class="row align-items-center mx-0">
                            <div class="col-4 text-center"><em class="fa fa-file fa-2x"></em></div>
                            <div class="col-8 py-4 bg-primary rounded-right">
                                <div class="h1 m-0 text-bold">{{ $show->show_questions_count }}</div>
                                <div class="mb-4">Total Questions</div>
                                <a href="{{ route('showQuestions',$show->id) }}" style="color: white;"><p>Add Questions <i class="fa fa-caret-right ml-1"></i></p></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-10 ">
                            <h4 class="mt-3">Edit Show Details</h4>
                            <p class="btn btn-info" onclick="goBack()">Back</p>
                        </div>
                        <div class="col-sm-2 text-right">
                        </div>
                        <div class="col-12"><hr>
                        </div>
                    </div>
                </div>
                <div class="">
                    <form method="post" data-parsley-validate="" id="edit_show" novalidate="" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row mt-1">
                                <div class="col-sm-3 text-right mt-1">
                                    <label for="validationCustom01">Show Title</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="title" placeholder="" value="{{ $show->title }}" required>
                                    <div class="invalid-feedback">Please enter title</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-3 text-right mt-1">
                                    <label for="validationCustom01">Description</label>
                                </div>
                                <div class="col-sm-9">
                                    <textarea  class="form-control" name="description" placeholder="">{{ $show->description }}</textarea>
                                    <div class="invalid-feedback">Please enter title</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-3 text-right mt-1">
                                    <label for="validationCustom01">Show Start Time</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control 24hours-timepicker" name="start_time" placeholder="" value="{{ $show->start_time }}" style="background-color:white" required>
                                    <div class="invalid-feedback">Please enter title</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-3 text-right mt-1">
                                    <label for="validationCustom01">Show End Time</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control 24hours-timepicker" name="end_time" placeholder="" value="{{ $show->end_time }}" style="background-color:white" required>
                                    <div class="invalid-feedback">Please enter title</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-3 text-right mt-1">
                                    <label for="validationCustom01">Show Date</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group date" id="datetimepicker1">
                                        <input class="form-control" type="text" name="date"  readonly="readonly" style="background-color:white;" value="{{ $show->date }}" required="">
                                        <span class="fas fa-calendar-alt input-group-append input-group-addon">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-3 text-right mt-1">
                                    <label for="validationCustom01">Show Expiry Date</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group date" id="datetimepicker2">
                                        <input class="form-control" type="text" name="expiry_date" readonly="readonly" style="background-color:white;" value="{{ $show->expiry_date }}" required="">
                                        <span class="fas fa-calendar-alt input-group-append input-group-addon">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-3 text-right mt-1">
                                    <label for="validationCustom01">Video URL </label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="video_url" placeholder="" value="{{ $show->video_url }}" required>
                                    <div class="invalid-feedback">Please enter video url</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-3 text-right mt-1">
                                    <label for="validationCustom01">Promo URL </label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="promo_url" placeholder="" value="{{ $show->promo_url }}" required>
                                    <div class="invalid-feedback">Please enter promo url</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-3 text-right mt-1">
                                    <label for="validationCustom01">Team 1</label>
                                </div>
                                <div class="col-sm-9">
                                    <select name="team_1_id" id="team_1_dropdown" placeholder="" class="form-control ctSelectBox1" required="" >
                                        <option value="">Choose team</option>
                                        @foreach($teams as $team)
                                        <option value="{{ $team->id }}" data-image="{{ !empty($team->logo)?$team->logo:asset('img/avatarEmpty.png') }}" <?php if($team->id == $show->team_1_id){echo "selected";} ?>>
                                            {{ $team->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a team</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-3 text-right mt-1">
                                    <label for="validationCustom01">Team 2</label>
                                </div>
                                <div class="col-sm-9">
                                    <select name="team_2_id" id="team_2_dropdown" placeholder="" class="form-control ctSelectBox1" required="" >
                                        <option value="">Choose team</option>
                                        @foreach($teams as $team)
                                        <option  value="{{ $team->id }}" data-image="{{ !empty($team->logo)?$team->logo:asset('img/avatarEmpty.png') }}" <?php if($team->id == $show->team_2_id){echo "selected";} ?>>
                                            {{ $team->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a team</div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-3 text-right mt-1">
                                    <label for="validationCustom01">Show Banner</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input type='file' id="imgInp" name="banner" />
                                        </div>
                                        <div class="col-sm-4">
                                            <b>Preview:</b>
                                            <div class="preview_thumb mt-2" style="width: 100%;height: 150px;"><img id="blah" src="{{ (!empty($show->banner))?$show->banner:asset('img/avatarEmpty.png') }}" alt="your image" />
                                                <div class="del_btn" id="delet_photo"><i class="fa fa-times"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-3 text-right mt-1">
                                </div>
                                <div class="col-sm-9">
                                    <button class="btn theme-blue-btn" type="submit">Submit </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
            enableTime: !0, noCalendar: !0, dateFormat: "H:i", time_24hr: !0
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

        $("#delet_photo").click(function()
        {
            $('#blah').attr('src',"{{ asset('img/avatarEmpty.png') }}");
            $('.del_btn').hide();
            $("#imgInp").val("");
        });
        $('#edit_show').on('submit',function(e){
            e.preventDefault();
            var thiss = $(this);
            var form_instance = $('form#edit_show').parsley();
            if(form_instance.isValid()){
                var dropdown_1_value = $('#team_1_dropdown').val();
                var dropdown_2_value = $('#team_2_dropdown').val();
                if(dropdown_1_value != "" && dropdown_2_value != ""){
                    $.ajax({
                        url: "{{route('validateTeamPlayers')}}",
                        type: "POST",
                        data: {"_token": "{{ csrf_token() }}",'dropdown_1_value':dropdown_1_value,'dropdown_2_value':dropdown_2_value},
                        success: function (response) {
                            var result = response;
                            if (result.status == 0) {
                                swal('Error', result.message, 'error');
                            } else {
                                var action = thiss.attr('action');
                                var form_data = new FormData(thiss[0]);
                                $.ajax({
                                    url: action,
                                    type: 'POST',
                                    data: form_data,
                                    contentType: false,
                                    processData: false,
                                    success: function (response) {
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
