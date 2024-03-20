@extends('layouts.header')
@section('content')
<section id="sectionManager" class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            <div>{{ __('App Content Management') }}</div>
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
                    <a class="nav-link bb0 active" href="#cont_manag" aria-controls="cont_manag" role="tab" data-toggle="tab" aria-selected="true">
                        {{__('Content Management')}}
                    </a>
                </li>
                <!-- <li class="nav-item" role="presentation">
                    <a class="nav-link bb0" href="#max_limit" aria-controls="max_limit" role="tab" data-toggle="tab" aria-selected="false">
                        {{__('Maximum Limits')}}
                    </a>
                </li> -->
            </ul>

            <!-- Tab panes-->
            <div class="tab-content p-0 bg-white">
                <!-- Screen Text Tab Start-->
                <div class="tab-pane active" id="cont_manag" role="tabpanel">
                    <div class="row p-4">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-12 managerPermission">
                                    <div class="form-group">
                                        <div class="dd" id="nestable2">
                                            <ol class="dd-list">
                                                @foreach($app_contents as $app_content)
                                                <li class="dd-item dd3-item ">
                                                    <div class="dd3-content">{{ __($app_content->name) }}
                                                        <div class="form-group float-right">
                                                            <button class="btn btn-info p-0 btn_p editScreenText" data-id="{{ $app_content->id }}"><i class="fa fa-edit"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--- Edit  Row Start--->
                        <div class="col-8 pl-4 " id="editScreenData">

                        </div>
                        <!--- Edit  Row End--->
                    </div>
                </div>
                <!-- Screen Text Tab End-->

            </div>
            <!--  Email/Text/Push template Tab End-->
        </div>
    </div>
</section>

<script>
    $('.editScreenText').on('click', function () {
        var content_id = $(this).data('id');
        var csrf_token = $('meta[name="csrf-token"]').attr('content'); // Retrieve CSRF token

        $.ajax({
            url: "{{route('appContentFieldAjax')}}",
            type: "POST",
            data: {app_content_id: content_id, _token: csrf_token },

            success: function (response) {
                $('#editScreenData').html(response);
                $('#editScreenData').show();
            }
        })
    });

    $(document).on('submit', '#content_field_form', function (e) {
        var empty_field = 0;
        $(document).find('.required_field').each(function (index, element) {
            var thiss = $(this);
            if (thiss.val() == "") {
                e.preventDefault();
                thiss.trigger('click');
                $.notify("Please fill all field.", {"status": "danger"});
                return false;
            }
        })
    })
</script>
@endsection
