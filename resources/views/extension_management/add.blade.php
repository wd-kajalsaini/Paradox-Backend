@extends('layouts.header')
@section('content')

<section id="sectionManager" class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">

        <div class="content-heading px-4">
            <div class="text-dark">{{__('App Management')}}/{{__('Extension Management')}}/{{__('Add')}}</div><!-- START Delete Btn -->
            <div class="ml-auto">
                <button class="btn btn-info btn-lg" type="submit" form="add_extension">Save</button>
                <button class="btn btn-info btn-lg" type="button" onclick="goBack()">Back</button>
            </div><!-- END  Delete Btn-->
        </div><!-- START cards box-->

        <div class="card card-transparent">
            <form method="POST" action="{{route('w')}}" id="add_extension">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card border">
                            <div class="card-body">
                                <div class="row p-4">
                                    <div class="col-sm-12">
                                        <h4 class="">{{ __('Add Extension')}}</h4>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ __('Extension')}}</label>
                                            <input class="form-control" type="text" name="extension" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ __('Country')}}</label>
                                            <input class="form-control" type="text" name="country">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ __('Country Code')}}</label>
                                            <input class="form-control" type="text" name="country_code">
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