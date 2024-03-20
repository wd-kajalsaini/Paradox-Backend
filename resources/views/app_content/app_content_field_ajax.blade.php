
<div class="">
    <div class="">
        <div class="row">
            <div class="col-8">

            </div>
            <div class="col-4 text-right">
                <button class="btn btn-danger" onclick="goBack()">Close</button>
                <button type="submit" class="btn btn-info" form="content_field_form">Save</button>
            </div>
        </div>
    </div>
    <form method="POST" id="content_field_form" action="{{route('contentManagementListing')}}" data-parsley-validate="">
        @csrf
        <div class="card-body">
            <div class="row">
                <input type="hidden" name="app_content_id" value="<?php echo $content['id']; ?>">

                <div class="col-12 mt-3 lightBkg p-4">
                    <h4 class="">English</h4>
                    {{-- @if(in_array('title_english',$selected_fields)) --}}
                    @if(isset($content['field_data']['title_english']))

                    <div class="form-group">
                        <label class="col-form-label">{{ __('Title')}}</label>
                        <textarea name="title_english" class="form-control" id="ckeditor1" ><?php echo (!empty($content['field_data']['title_english'])) ? $content['field_data']['title_english'] : "" ?></textarea>
                    </div>
                    @endif
                    {{-- @if(in_array('description_english',$selected_fields)) --}}
                    @if(isset($content['field_data']['description_english']))

                    <div class="form-group mt-3">
                        <label class="col-form-label">{{ __('Description')}}</label>
                        <textarea name="description_english" class="form-control" rows="5" id="ckeditor2" ><?php echo (!empty($content['field_data']['description_english'])) ? $content['field_data']['description_english'] : "" ?></textarea>
                    </div>
                    @endif
                    {{-- @if(in_array('error_english',$selected_fields)) --}}
                    @if(isset($content['field_data']['error_english']))

                    <div class="form-group mt-3">
                        <label class="col-form-label">{{ __('Error')}}</label>
                        <textarea name="error_english" class="form-control" id="ckeditor3" ><?php echo (!empty($content['field_data']['error_english'])) ? $content['field_data']['error_english'] : "" ?></textarea>
                    </div>
                    @endif
                    {{-- @if(in_array('alert_english',$selected_fields)) --}}
                    @if(isset($content['field_data']['alert_english']))

                    <div class="form-group mt-3">
                        <label class="col-form-label">{{ __('Alert')}}</label>
                        <textarea name="alert_english" class="form-control" id="ckeditor4" ><?php echo (!empty($content['field_data']['alert_english'])) ? $content['field_data']['alert_english'] : "" ?></textarea>
                    </div>
                    @endif
                    {{-- @if(in_array('explantion_popup1_title_english',$selected_fields)) --}}
                    @if(isset($content['field_data']['explantion_popup1_title_english']))

                    <div class="card">
                        <div class="card-body pl-2 pr-2">
                            <div class="form-group">
                                <label class="col-form-label">{{ __('Explanation Popup 1 Title')}}</label>
                                <textarea name="explantion_popup1_title_english" class="form-control" id="ckeditor5" ><?php echo (!empty($content['field_data']['explantion_popup1_title_english'])) ? $content['field_data']['explantion_popup1_title_english'] : "" ?></textarea>
                            </div>

                            {{-- @if(in_array('explantion_popup1_description_english',$selected_fields)) --}}
                            @if(isset($content['field_data']['explantion_popup1_description_english']))

                            <div class="form-group mt-3">
                                <label class="col-form-label">{{ __('Explanation Popup 1 Description')}}</label>

                                <textarea name="explantion_popup1_description_english" class="form-control" rows="5" id="ckeditor6" ><?php echo (!empty($content['field_data']['explantion_popup1_description_english'])) ? $content['field_data']['explantion_popup1_description_english'] : "" ?></textarea>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    {{-- @if(in_array('explantion_popup2_title_english',$selected_fields)) --}}
                    @if(isset($content['field_data']['explantion_popup2_title_english']))

                    <div class="card">
                        <div class="card-body pl-2 pr-2">
                            <div class="form-group">
                                <label class="col-form-label">{{ __('Explanation Popup 2 Title')}}</label>
                                <textarea name="explantion_popup2_title_english" class="form-control" id="ckeditor7" ><?php echo (!empty($content['field_data']['explantion_popup2_title_english'])) ? $content['field_data']['explantion_popup2_title_english'] : "" ?></textarea>
                            </div>

                            {{-- @if(in_array('explantion_popup2_description_english',$selected_fields)) --}}
                            @if(isset($content['field_data']['explantion_popup2_description_english']))

                            <div class="form-group mt-3">
                                <label class="col-form-label">{{ __('Explanation Popup 2 Description')}}</label>
                                <textarea name="explantion_popup2_description_english" class="form-control" rows="5" id="ckeditor8" ><?php echo (!empty($content['field_data']['explantion_popup2_description_english'])) ? $content['field_data']['explantion_popup2_description_english'] : "" ?></textarea>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    {{-- @if(in_array('camera_english',$selected_fields)) --}}
                    @if(isset($content['field_data']['camera_english']))

                    <div class="form-group">
                        <label class="col-form-label">{{ __('Title for Camera')}}</label>
                        <textarea name="camera_english" class="form-control" id="ckeditor9" required><?php echo (!empty($content['field_data']['camera_english'])) ? $content['field_data']['camera_english'] : "" ?></textarea>
                    </div>
                    @endif
                    {{-- @if(in_array('gallery_english',$selected_fields)) --}}
                    @if(isset($content['field_data']['gallery_english']))

                    <div class="form-group">
                        <label class="col-form-label">{{ __('Title for Gallery')}}</label>
                        <textarea name="gallery_english" class="form-control" id="ckeditor10" required><?php echo (!empty($content['field_data']['gallery_english'])) ? $content['field_data']['gallery_english'] : "" ?></textarea>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>



<script>
    var editor_config = {

    };
    CKEDITOR.replace('ckeditor1', editor_config);
    CKEDITOR.replace('ckeditor2', editor_config);
    CKEDITOR.replace('ckeditor3', editor_config);
    CKEDITOR.replace('ckeditor4', editor_config);
    CKEDITOR.replace('ckeditor5', editor_config);
    CKEDITOR.replace('ckeditor6', editor_config);
    CKEDITOR.replace('ckeditor7', editor_config);
    CKEDITOR.replace('ckeditor8', editor_config);
    CKEDITOR.replace('ckeditor9', editor_config);
    CKEDITOR.replace('ckeditor10', editor_config);
</script>
