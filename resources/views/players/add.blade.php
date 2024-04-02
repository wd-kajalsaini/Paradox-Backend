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
            <div>Add New Player</div>
            <!-- START Language list-->
        </div>
        <div class="card m-3 border">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="m-0">New Player Details</h4>
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
                <form method="post" data-parsley-validate="" novalidate="" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row mt-1">
                            <div class="col-4 col-md-2">
                                <label for="validationCustom01">Name</label>
                            </div>
                            <div class="col-8 col-md-10">
                                <input type="text" class="form-control" name="name" placeholder="" value="" required>
                                <div class="invalid-feedback">Please enter a Name</div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-4 col-md-2">
                                <label for="validationCustom01">Description</label>
                            </div>
                            <div class="col-8 col-md-10">
                                <textarea type="text" class="form-control" name="description" placeholder="" required></textarea>
                                <div class="invalid-feedback">Please enter description</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2">
                                <label for="validationCustom01">Instagram Profile URL </label>
                            </div>
                            <div class="col-8 col-md-10">
                                <input type="text" class="form-control" name="instagram_profile_url" placeholder="" value="">
                                <div class="invalid-feedback">Please enter a instagram url</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2">
                                <label for="validationCustom01">Facebook Profile URL </label>
                            </div>
                            <div class="col-8 col-md-10">
                                <input type="text" class="form-control" name="facebook_profile_url" placeholder="" value="">
                                <div class="invalid-feedback">Please enter a facebook url</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2">
                                <label for="validationCustom01">TikTok account</label>
                            </div>
                            <div class="col-8 col-md-10">
                                <input type="text" class="form-control" name="ticktok_account" placeholder="" value="">
                                <div class="invalid-feedback">Please enter a TikTok Account</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2">
                                <label for="validationCustom01">Snapchat account</label>
                            </div>
                            <div class="col-8 col-md-10">
                                <input type="text" class="form-control" name="snapchat_account" placeholder="" value="">
                                <div class="invalid-feedback">Please enter a Snapchat Account</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2">
                                <label for="validationCustom01">Twitch account</label>
                            </div>
                            <div class="col-8 col-md-10">
                                <input type="text" class="form-control" name="twitch_account" placeholder="" value="">
                                <div class="invalid-feedback">Please enter a Twitch Account</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-md-2">
                                <label for="validationCustom01">Thumbnail</label>
                            </div>
                            <div class="col-8 col-md-10">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type='file' id="imgInp" name="thumbnail" />
                                    </div>
                                    <div class="col-sm-6">
                                        <b>Preview:</b>
                                        <div class="preview_thumb mt-2"><img id="blah" src="{{ asset('img/avatarEmpty.png') }}" alt="Player Thumbnail" />
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
</script>
@endsection