@extends('layouts.header')
@section('content')

<section id="sectionManager"class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">

        <div class="content-heading">
            <div class="text-dark">{{__('App Management')}}/{{__('Kvitel Products')}}/{{__('Add')}}</div><!-- START Delete Btn -->
            <div class="ml-auto">
                <button class="btn btn-info btn-lg" type="submit" form="add_product">Save</button>
                <button class="btn btn-info btn-lg" type="button" onclick="goBack()">Back</button>
            </div><!-- END  Delete Btn-->
        </div><!-- START cards box-->

        <div class="p-3">
            <form method="POST" action="{{route('editKvitelProduct',$kvitel_product->id)}}" id="add_product">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card pl-0 pr-0 border">
                            <div class="card-body">
                                <div class="row p-4">
                                    <div class="col-sm-12">
                                        <h4 class="">{{ __('Add Kvitel Product')}}</h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group eventDate">
                                            <label class="col-form-label">{{ __('Title')}}</label>
                                            <input type="text" name="title" class="form-control" value="{{ $kvitel_product->title }}" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ __('Price')}}</label>
                                            <input type="number" name="price" step="0.01" class="form-control" value="{{ $kvitel_product->price }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ __('Length')}}</label>
                                            <input type="number" name="length" min="1" max="9" class="form-control" value="{{ $kvitel_product->length }}" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ __('Is Best')}}</label>
                                            <label class="switch switch-lg"><input type="checkbox" <?php if(!empty($kvitel_product->is_best)){echo "checked";} ?> name="is_best" value="1"><span></span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ __('Description')}}</label>
                                            <textarea name="description" rows="2" class="form-control" required>{{ $kvitel_product->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{__('Image (Click icon to upload)')}}</label>
                                            <input class="form-control" type="hidden" id="extension_icon" name="logo">
                                            <div class="uploadAvatarImage">
                                                <img src="{{ !empty($kvitel_product->logo)?$kvitel_product->logo:asset('img/avatarEmpty.png')}}" id="extension_avatar" onclick="selectFileWithCKFinder('extension_icon', 'extension_avatar')">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
