@extends('layouts.header')
@section('content')
<style>
    table.datatable1 tr th, table.datatable1 tr td {
        padding-left: 25px;
        padding-right: 25px;
    }
    .userList .nav-link {
        background: #fff;
        margin-top: 5px;
        color: #000 !important;
        border: 1px solid #ccc;
        box-shadow: none;
    }
    .userList .nav-link.bb0.active {
        background-color: #fff;
        border-left: 4px solid #44c2e8 !important;
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
<section id="sectionManager" class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading px-4">
            <div>{{ __('User Info') }}</div>
            <!-- START Language list-->
            <!--div class="ml-auto">
                     <div class="btn-group"><button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown">English</button>
                        <div class="dropdown-menu dropdown-menu-right-forced animated fadeInUpShort" role="menu"><a class="dropdown-item" href="#" data-set-lang="en">English</a><a class="dropdown-item" href="#" data-set-lang="es">Spanish</a></div>
                     </div>
                  </div-->
            <!-- END Language list-->
        </div>
        <!-- START cards box-->
        <div class="pt-3 bg-white">

            <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link bb0 active" href="#general_tab" aria-controls="general_tab" role="tab" data-toggle="tab" aria-selected="true">
                        {{__('General')}}
                    </a>
                </li>
            </ul>

            <!-- Tab panes-->
            <div class="tab-content p-0 bg-white">
                <!-- Screen Text Tab Start-->
                <div class="tab-pane active" id="general_tab" role="tabpanel">
                    <div class="row p-4">
                        <div class="col-sm-12">
                            <!-- Table Card Start-->
                            <div class="card  border">
                                <div class="card-body">
                                    <form method="POST" action="{{route('editUserInfo',$userDetail->id)}}" id="general_data" >
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="">{{ __('General Info')}}</h4>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Id')}}</label>
                                                    <input class="form-control" type="text" value="{{ $userDetail->id }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Name')}}</label>
                                                    <input class="form-control" type="text" name="name" value="{{ $userDetail->name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Phone number')}}</label>
                                                    <input name="phone_number" class="form-control" type="text" value="{{ $userDetail->phone_number }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Email address')}}</label>
                                                    <input name="email" class="form-control" type="text" value="{{ $userDetail->email }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Gender')}}</label>
                                                    <select class="form-control" type="password" name="gender">
                                                        <option value="Male" {{ ($userDetail->gender == 'Male')?"required":"" }}>Male</option>
                                                        <option value="Female" {{ ($userDetail->gender == 'Female')?"required":"" }} >Female</option>
                                                        <option value="Non-binary" {{ ($userDetail->gender == 'Non-binary')?"required":"" }}>Non-binary</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Is active/online')}}</label>
                                                    <input class="form-control" type="text" value="{{ ($userDetail->is_online)?'Yes':'No' }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Device type')}}</label>
                                                    <input class="form-control" type="text" value="{{ $userDetail->device_type }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('App version')}}</label>
                                                    <input class="form-control" type="text" value="{{ $userDetail->app_version }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Install date')}}</label>
                                                    <input class="form-control" type="text" value="{{ (!empty($userDetail->install_date))?date('d M, Y',strtotime($userDetail->install_date)):"" }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{__('Avatar')}}</label>
                                                    <div class="row align-items-center">
                                                        <div class="col-md-6">
                                                            <input type='file' id="imgInp" name="avatar" />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <b>Preview</b>
                                                            <div class="preview_thumb mt-2"><img id="blah" src="{{ !empty($userDetail->image) && @getimagesize($userDetail->image)?$userDetail->image:asset('img/avatarEmpty.png')}}" alt="Show banner" />
                                                                <div class="del_btn" id="delet_photo"><i class="fa fa-times"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 text-center">
                                                <input type="hidden" name="general_form_submit" value="Update">
                                                <button class="btn btn-info" type="submit" name="general_form_submit">{{__('Update')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Table Card End-->
                        </div>
                    </div>
                </div>
		  </div>
	  </div>
  </div>

</section>
@endsection

@section('script')
<script>
$('#general_data').on('submit', function (e) {
    e.preventDefault();
    var action = $(this).attr('action');
    var form_data = new FormData($(this)[0]);
    $('#loader').show();
    $.ajax({
        url: action,
        type: 'POST',
        data: form_data,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#loader').hide();
            if (response.status == 1) {
                window.location = "";
            } else {
                swal("Error", response.message, 'error');
            }
        }
    })
})

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
</script>
@endsection
