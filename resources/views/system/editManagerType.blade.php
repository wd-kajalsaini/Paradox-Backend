@extends('layouts.header')
@section('content')
<!-- Main section-->
<section id="sectionManager" class="section-container mb-4">
    <!-- Page content-->
    <div class="content-wrapper">
        <!-- Start New Manager Type  --->
        <form action="{{route('editManagerType',$manager->id)}}" method="post">
            @csrf
            <div class="content-heading px-4 d-block d-md-flex">
                <div class="text-dark">{{__('System')}}/{{__('Managers')}}/{{__('Edit Manager Type')}}</div>
                <div class="ml-auto mt-3 mt-md-0">
                    <button class="btn btn-info btn-lg  " type="submit">{{__('Update')}}</button>
                    <button class="btn btn-info btn-lg " type="button" onclick="goBack()">{{__('Back')}}</button>
                </div>
            </div>
            <div class="p-3">
                <div class="col-sm-12 mb-0 mb-md-5">
                    <div class="row">
                        <div class="col-sm-6 p-0">
                            <div class="form-group">
                                <label class="col-form-label">{{__('Manager Type Name')}}</label>
                                <input class="form-control" name="name" type="text" style="border-right: 1px solid  red;" name="managertype" value="{{ $manager->name }}" required>
                                @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 managerPermission p-0 ">
                            <div class="form-group">
                                <label class="col-form-label">{{__('Manager Type Permissions')}}</label>
                                <div class="dd" id="nestable2">
                                    <ol class="dd-list">
                                        @foreach($hSections as $section)
                                        <li class="dd-item dd3-item" data-id="15">
                                            <div class="dd3-content">{{$section['name']}}
                                                <div class="form-group float-right">
                                                    <input type="hidden" name="sectionId[{{$section['id']}}]" value="{{$section['id']}}" />
                                                    <select class="" name="permission[{{$section['id']}}]">
                                                        <option value="2" @if(!empty($section['permission'])){{ $section['permission']['permission']== 2?"selected":""  }} @endif>{{__('Read & Write')}}</option>
                                                        <option value="1" @if(!empty($section['permission'])){{ $section['permission']['permission']== 1?"selected":""  }} @endif>{{__('Read only')}}</option>
                                                        <option value="0" @if(!empty($section['permission'])){{ $section['permission']['permission']== 0?"selected":""  }} @endif>{{__('N/A')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            @if($section['sub_sections']!=="")
                                            <ol class="dd-list" id="nestList">
                                                @foreach($section['sub_sections'] as $subSection)
                                                <input type="hidden" name="sectionId[{{$section['id']}}][{{$subSection['id']}}]" value="{{$subSection['id']}}" />
                                                <li class="dd-item dd3-item mainList" data-id="16">
                                                    <div class="dd3-content">{{$subSection['name']}}
                                                        <div class="form-group float-right">
                                                            <select class="" name="permission[{{$subSection['id']}}]">
                                                                <option value="2" @if(!empty($section['permission'])){{ $subSection['permission']['permission']== 2?"selected":""  }} @endif>{{__('Read & Write')}}</option>
                                                                <option value="1" @if(!empty($section['permission'])){{ $subSection['permission']['permission']== 1?"selected":""  }} @endif>{{__('Read only')}}</option>
                                                                <option value="0" @if(!empty($section['permission'])){{ $subSection['permission']['permission']== 0?"selected":""  }} @endif>{{__('N/A')}}</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    @if($subSection['sub_sections']!=="")

                                                    <ol class="dd-list" id="nestList">
                                                        @foreach($subSection['sub_sections'] as $sSubSection)
                                                        <input type="hidden" name="sectionId[{{$subSection['id']}}][{{$sSubSection['id']}}]" value="{{$sSubSection['id']}}" />
                                                        <li class="dd-item dd3-item mainList" data-id="16">
                                                            <div class="dd3-content">{{$sSubSection['name']}}
                                                                <div class="form-group float-right">
                                                                    <select class="" name="permission[{{$sSubSection['id']}}]">
                                                                        <option value="2" @if(!empty($sSubSection['permission'])){{ $sSubSection['permission']['permission']== 2?"selected":""  }} @endif>{{__('Read & Write')}}</option>
                                                                        <option value="1" @if(!empty($sSubSection['permission'])){{ $sSubSection['permission']['permission']== 1?"selected":""  }} @endif>{{__('Read only')}}</option>
                                                                        <option value="0" @if(!empty($sSubSection['permission'])){{ $sSubSection['permission']['permission']== 0?"selected":""  }} @endif>{{__('N/A')}}</option>
                                                                    </select>
                                                                </div>

                                                            </div>
                                                        </li>
                                                        @endforeach
                                                    </ol>
                                                    @endif
                                                </li>
                                                @endforeach

                                            </ol>
                                            @endif
                                        </li>
                                        @endforeach

                                    </ol>
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