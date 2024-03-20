@extends('layouts.header')
@section('content')

<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper pl-0 pr-0">
        <div class="content-heading bg-">
            <div>{{ __('Website Settings')}}</div>
            <!-- START Language list-->
            <div class="ml-auto">
                <button class="btn btn-info btn-lg" type="submit" form="update_settings">{{ __('Update')}}</button>
                <button class="btn btn-info btn-lg" type="button" onclick="goBack()">{{ __('Back')}}</button>
            </div><!-- END  Delete Btn-->
            <!-- END Language list-->
        </div>
        <div class="row">
            <div class="col-sm-12"> 
                <div class="tab-pane" id="api_settings" role="tabpanel">
                    <form action="{{ route('websiteSettingsAdd') }}" id="update_settings" method="POST">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Card Start-->
                                <div class="card-body">
                                    @csrf
                                    <!--- Facebook API Inner Row Start--->
                                    <div class="row lightBkg p-4 m-05 mt-3">
                                        <div class="col-12">
                                            <h4 class="api_tilte">{{ __('Header')}}</h4>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">{{__('Logo (Click icon to upload)')}}</label>
                                                <input class="form-control" type="hidden" id="header_logo_icon" name="header_logo" value="{{ @$website->header_logo}}">
                                                <div class="uploadAvatarImage">
                                                    <img src="{{!empty($website->header_logo)?$website->header_logo:asset('public/img/avatarEmpty.png')}}" id="header_logo_avatar" onclick="selectFileWithCKFinder('header_logo_icon', 'header_logo_avatar')">
                                                </div>
                                            </div>                                         
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="col-form-label">{{ __('Menu links text')}}</label>
                                                <textarea name="header_menu_links_text" class="form-control" spellcheck="false">{{ @$website->header_menu_links_text}}</textarea>
                                            </div>                                       
                                        </div>

                                    </div>
                                    <!---Facebook API Inner Row End--->

                                    <!--- Google API Inner Row Start--->
                                    <div class="row lightBkg p-4 m-05 mt-3" >
                                        <div class="col-12">
                                            <h4 class="api_tilte">{{ __('Atmosfire Image')}}</h4>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">{{__('Background Image (Click icon to upload)')}}</label>
                                                <input class="form-control" type="hidden" id="atmosfire_background_image_icon" name="atmosfire_background_image" value="{{ @$website->atmosfire_background_image}}">
                                                <div class="uploadAvatarImage">
                                                    <img src="{{!empty($website->atmosfire_background_image)?$website->atmosfire_background_image:asset('public/img/avatarEmpty.png')}}" id="atmosfire_background_image_avatar" onclick="selectFileWithCKFinder('atmosfire_background_image_icon', 'atmosfire_background_image_avatar')">
                                                </div>
                                            </div>                                         
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">{{ __('Title')}}</label>
                                                <input class="form-control" type="text" name="atmosfire_title" value="{{ @$website->atmosfire_title}}">
                                            </div>                                        
                                        </div> 

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">{{ __('Slogan')}}</label>
                                                <input class="form-control" type="text" name="atmosfire_slogan" value="{{ @$website->atmosfire_slogan}}">
                                            </div>                                        
                                        </div>                                  
                                    </div>

                                    <div class="row lightBkg p-4 m-05 mt-3">
                                        <div class="col-12">
                                            <h4 class="api_tilte">{{ __('Login')}}</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="col-form-label">{{ __('Title')}}</label>
                                                <input class="form-control" type="text" name="login_title" value="{{ @$website->login_title}}">
                                            </div>                                       
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="col-form-label">{{ __('Description')}}</label>
                                                <textarea class="form-control" name="login_description">{{ @$website->login_description}}</textarea>
                                            </div>                                       
                                        </div>

                                    </div>

                                    <div class="row lightBkg p-4 m-05 mt-3">
                                        <div class="col-12">
                                            <h4 class="api_tilte">{{ __('Contact Us')}}</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="col-form-label">{{ __('Title')}}</label>
                                                <input class="form-control" type="text" name="contact_us_title" value="{{ @$website->contact_us_title}}">
                                            </div>                                       
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="col-form-label">{{ __('Description')}}</label>
                                                <textarea class="form-control" name="contact_us_description">{{ @$website->contact_us_description}}</textarea>
                                            </div>                                       
                                        </div>

                                    </div>

                                </div>

                                <!-- Card End--->
                            </div>
                            <div class="col-sm-6">
                                <!-- Card Start-->
                                <div class="card-body">
                                    <!--- Facebook API Inner Row Start--->

                                    <!---Facebook API Inner Row End--->

                                    <!--- Google API Inner Row Start--->
                                    <div class="row lightBkg p-4 m-05 mt-3">
                                        <div class="col-12">
                                            <h4 class="api_tilte">{{ __('Download The App')}}</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="col-form-label">{{ __('Title')}}</label>
                                                <input class="form-control" type="text" name="download_app_title" value="{{ @$website->download_app_title}}">
                                            </div>                                       
                                        </div> 
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="col-form-label">{{ __('Description')}}</label>

                                                <textarea class="form-control" name="download_app_description">{{ @$website->download_app_description}}</textarea>
                                            </div>                                       
                                        </div> 
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">{{ __('Url to Google Play')}}</label>
                                                <input class="form-control" type="text" name="download_app_google_play" value="{{ @$website->download_app_google_play}}">
                                            </div> 
                                        </div>
                                        <div class="col-6">  
                                            <div class="form-group">
                                                <label class="col-form-label">{{ __('Url to Ios App Store')}}</label>
                                                <input class="form-control" type="text" name="download_app_ios_store" value="{{ @$website->download_app_ios_store}}">
                                            </div>   

                                        </div>                                    
                                    </div>
                                    <!---Google API Inner Row End--->

                                    <!---  SMS API Inner Row Start--->
                                    <div class="row lightBkg p-4 m-05 mt-3">
                                        <div class="col-12">
                                            <h4 class="api_tilte">{{ __('About the App')}}</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="col-form-label">{{ __('Title')}}</label>
                                                <input class="form-control" type="text" name="about_app_title" value="{{ @$website->about_app_title}}">
                                            </div>                                       
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">{{__('Image (Click icon to upload)')}}</label>
                                                <input class="form-control" type="hidden" id="about_app_image_icon" name="about_app_image" value="{{ @$website->about_app_image}}">
                                                <div class="uploadAvatarImage">
                                                    <img src="{{!empty($website->about_app_image)?$website->about_app_image:asset('public/img/avatarEmpty.png')}}" id="about_app_image_avatar" onclick="selectFileWithCKFinder('about_app_image_icon', 'about_app_image_avatar')">
                                                </div>
                                            </div>                                         
                                        </div>
                                    </div>

                                    <div class="row lightBkg p-4 m-05 mt-3">
                                        <div class="col-12">
                                            <h4 class="api_tilte">{{ __('Footer')}}</h4>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="col-form-label">{{ __('All rights reserved text')}}</label>
                                                <textarea class="form-control" rows="6" name="footer_text">{{ @$website->footer_text}}</textarea>
                                            </div>                                       
                                        </div>

                                    </div>

                                    <!--- SMS API Inner Row End--->
                                </div>
                                <!-- Card End--->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection