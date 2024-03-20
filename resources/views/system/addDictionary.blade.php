@extends('layouts.header')
@section('content')

<!-- Main section-->
<section  id="sectionManager"class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <!-- Start New Manager Type  --->
        <form action="{{route('addDictionaryAdd')}}" method="post">
            @csrf
            <div class="content-heading">
                <div class="text-dark">{{__('System')}}/{{__('Dictionary')}}/{{__('New Dictionary')}} </div>
                <div class="ml-auto">
                    <button class="btn btn-info btn-lg  " type="submit">{{__('Save')}}</button>
                    <button class="btn btn-info btn-lg " type="button" onclick="goBack()">{{__('Back')}}</button>
                </div>
            </div>
            <div class="p-3">
                <div class="col-sm-4">
                    <div class="card border">
                        <div class="">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('Variable')}} </label>
                                        <input class="form-control @error('variable') is-invalid @enderror" value="{{old('variable')}}" style="border-right: 1px solid  red;" type="text" name="variable" required>
                                        @error('variable')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label" >{{__('Hebrew')}}</label>
                                        <textarea class="form-control @error('hebrew') is-invalid @enderror text-right" name="hebrew" value="{{old('hebrew')}}"  style="border-right: 1px solid  red;"  rows="3" required>{{old('hebrew')}} </textarea>
                                        @error('hebrew')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{__('English')}}</label>
                                        <textarea class="form-control @error('english') is-invalid @enderror" name="english" value="{{old('english')}}"  style="border-right: 1px solid  red;"  rows="3" required>{{old('english')}}</textarea>
                                        @error('english')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- End New Manager Type  --->
    </div>

</section>

@endsection
