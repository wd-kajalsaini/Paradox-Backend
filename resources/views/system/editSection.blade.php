@extends('layouts.header')
@section('content')
<!-- Main section-->
<section  id="sectionManager"class="section-container">

    <!-- Page content-->
    <div class="content-wrapper">
        <!-- Start ManagerInfo Form --->
        <form action="{{route('editSection',$selectSection->id)}}" method="post">
            @csrf
            <div class="content-heading">
                <div class="text-dark">{{__('System')}}/{{__('Section')}}/{{__('New Section')}}</div><!--- START Language list--->

                <div class="ml-auto">
                    <button class="btn btn-info btn-lg " type="submit">{{__('Update')}}</button>
                    <button class="btn btn-info btn-lg " type="button" onclick="goBack()">{{__('Back')}}</button>
                </div><!--- END Language list--->
            </div><!-- START cards box-->

            <div class="p-3">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- START card-->
                        <div class="card border">
                            <div class="card-header">
                                <h3 class="card-title">{{__('Section Settings')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{__('Parent')}} </label>
                                            <select class="form-control" name="parent_id" style="border-right: 1px solid  red;" required>
                                                <option value="">{{__('Choose')}}....</option>
                                                <option value="main" {{$selectSection->parent_id=="main"?"selected":""}}>{{__('Main')}} </option>
                                                @foreach($hSections as $section)
                                                <option value="{{$section['id']}}" {{$selectSection->parent_id==$section['id']?"selected":""}}><?php echo $section['name']; ?></option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{__('Show On Sidebar')}} </label>
                                            <select class="form-control showAction" style="border-right: 1px solid  red;" name="show_on_sidebar" required>
                                                <option value="yes" {{$selectSection->show_on_sidebar=="yes"?"selected":""}}>{{__('Yes')}} </option>
                                                <option value="no" {{$selectSection->show_on_sidebar=="no"?"selected":""}}>{{__('No')}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{$selectSection->route}}" name="hidden_route" />
                                    <div class="col-sm-12 yesActions">
                                        <div class="form-group">
                                            <label class="col-form-label">{{__('Action')}}</label>

                                            <select class="form-control action" style="border-right: 1px solid  red;" name="route">
                                                <option value="">{{__('Choose')}}....</option>

                                                @foreach($yActions as $action)
                                                <option value="{{$action}}" {{$selectSection->route==$action?"selected":""}}><?php echo ucfirst(camelToTitle($action)); ?></option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 noActions">
                                        <div class="form-group">
                                            <label class="col-form-label">{{__('Action')}}</label>
                                            <select class="form-control  action" style="border-right: 1px solid  red;" name="route" >
                                                <option value="">{{__('Choose')}}....</option>

                                                @foreach($nActions as $action)
                                                <option value="{{$action}}" {{$selectSection->route==$action?"selected":""}}><?php echo ucfirst(camelToTitle($action)); ?></option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{__('Name')}} </label>
                                            <input class="form-control" type="text" style="border-right: 1px solid  red;" name="name" value="{{$selectSection->name}}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group" id="iconLists">
                                            <label class="col-form-label">{{__('Icon')}} </label>


                                            <input type="text" id="someName" name="icon" value="{{$selectSection->icon}}" class="icon-picker required" >

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div><!-- END card-->
                    </div>


                    <div class="col-sm-6">
                        <!-- START card-->
                        <div class="card border">
                            <div class="card-header">
                                <h3 class="card-title">{{__('Section Names')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{__('Name in English')}}</label>
                                            <input class="form-control @error('english') is-invalid @enderror" style="border-right: 1px solid  red;" type="text" value="{{$selectSection->english}}" name="english" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- END card-->
                    </div>
                </div>
            </div>
        </form>
        <!-- End ManagerInfo Form --->
    </div>
</section>
<?php

function camelToTitle($camelStr) {
    $intermediate = preg_replace('/(?!^)([[:upper:]][[:lower:]]+)/', ' $0', $camelStr);
    $titleStr = preg_replace('/(?!^)([[:lower:]])([[:upper:]])/', '$1 $2', $intermediate);
    return str_replace(' Listing', '', str_replace(' Add', '', $titleStr));
}
?>

<script>
    $(document).ready(function () {
        $(".showAction").change(function () {

            var showAction = $(this).val();
            if (showAction == 'no')
            {
                $('.yesActions').hide();
                $('.yesActions').find('.action').prop('disabled', true);
                $('.noActions').show();
                $('.noActions').find('.action').prop('disabled', false);
            }
            if (showAction == 'yes')
            {
                $('.yesActions').show();
                $('.yesActions').find('.action').prop('disabled', false);
                $('.noActions').hide();
                $('.noActions').find('.action').prop('disabled', true);
            }
        });
        var showAction = $('.showAction').val();
        if (showAction == 'no')
        {
            $('.yesActions').hide();
            $('.yesActions').find('.action').prop('disabled', true);
            $('.noActions').show();
            $('.noActions').find('.action').prop('disabled', false);
        }
        if (showAction == 'yes')
        {
            $('.yesActions').show();
            $('.yesActions').find('.action').prop('disabled', false);
            $('.noActions').hide();
            $('.noActions').find('.action').prop('disabled', true);
        }
    });

</script>
@endsection
