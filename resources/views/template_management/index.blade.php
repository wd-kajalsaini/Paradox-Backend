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
</style>

<section id="sectionManager"class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">

        <div class="content-heading">
            <div>{{__('Template Management')}}</div><!-- START Delete Btn -->
        </div><!-- START cards box-->

        <div class="p-3">

            <div class="row">
                <div class="col-sm-3">

                    <div class="nav flex-column nav-pills nav-tabs userList" role="tablist"  aria-orientation="vertical">
                        <!--<li class="nav-item" role="presentation">-->
                        <a class="nav-link bb0 active" href="#forgot_password_template" aria-controls="forgot_password_template" role="tab" data-toggle="tab" aria-selected="true">
                            {{__('Forgot Password')}}
                        </a>
                        <!--</li>-->
                        <!--<li class="nav-item" role="presentation">-->
                        <!-- <a class="nav-link bb0" href="#phone_profile" aria-controls="phone_profile" role="tab" data-toggle="tab" aria-selected="false"> -->
                            <!-- {{__('Phones')}} -->
                        <!-- </a> -->
                        <!--</li>-->
                        <!--<li class="nav-item" role="presentation">-->

                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="tab-content p-0 bg-white">
                        <!-- Screen Text Tab Start-->
                        <div class="tab-pane active" id="forgot_password_template" role="tabpanel">
                            <div class="">
                                <div class="">
                                    <div class="row">
                                        <div class="col-8">

                                        </div>
                                        <div class="col-4 text-right">
                                            <button class="btn btn-danger" onclick="goBack()">Close</button>
                                            <button type="submit" class="btn btn-info" form="template_management_form">Save</button>
                                        </div>
                                    </div>
                                </div>
                                <form method="POST" id="template_management_form" action="{{route('templateManagementListing')}}" data-parsley-validate="">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mt-3 lightBkg p-4">
                                                <h4 class="">{{__('Forgot Password')}}</h4>
                                                <label class="col-form-label">{{ __('Tags')}}*</label>
                                                <p>[USERNAME] : Name of user</p>
                                                <p>[FORGOTPASSWORDLINK] : Internal Link, don't change this</p>
                                                <div class="form-group">
                                                    <!-- <label class="col-form-label">{{ __('Title')}}</label> -->
                                                    <textarea name="forgot_password" class="form-control required_field" id="ckeditor1" required>{{ $templates->forgot_password }}</textarea>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="tab-pane" id="phone_profile" role="tabpanel">

                        </div>
                    </div>
                </div>

                <!-- Screen Text Tab End-->

            </div>
        </div>

    </div>
</section>

@endsection

@section('script')
<script>
var editor_config = {

};
CKEDITOR.replace('ckeditor1', editor_config);
</script>
@endsection
