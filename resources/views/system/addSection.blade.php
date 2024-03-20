@extends('layouts.header')
@section('content')
<!-- Main section-->
<section  id="sectionManager"class="section-container">

    <!-- Page content-->
    <div class="content-wrapper">
        <!-- Start ManagerInfo Form --->
        <form action="{{route('addSectionAdd')}}" method="post">
            @csrf
            <div class="content-heading">
                <div class="text-dark">{{__('System')}}/{{__('Section')}}/{{__('New Section')}}</div><!--- START Language list--->

                <div class="ml-auto">
                    <button class="btn btn-info btn-lg " type="submit">{{__('Save')}}</button>
                    <button class="btn btn-info btn-lg " type="button" onclick="goBack()">{{__('Back')}}</button>
                </div><!--- END Language list--->
            </div><!-- START cards box-->

            <div class="p-3">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- START card-->
                        <div class="card p-4 b-01">
                            <div class="card-header">
                                <h3 class="card-title">{{__('Section Settings')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{__('Parent')}} <span class="text-danger">*</span></label>
                                            <select class="form-control @error('parent_id') is-invalid @enderror" style="border-right: 1px solid  red;" name="parent_id" required>
                                                <option value="">{{__('Choose')}}....</option>
                                                <option value="main">{{__('Main')}} </option>
                                                @foreach($hSections as $section)
                                                <option value="{{$section['id']}}"><?php echo $section['name']; ?></option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{__('Show On Sidebar')}} </label>
                                            <select class="form-control showAction @error('show_on_sidebar') is-invalid @enderror" style="border-right: 1px solid  red;" name="show_on_sidebar" required>
                                                <option value="yes">{{__('Yes')}} </option>
                                                <option value="no">{{__('No')}} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 yesActions">
                                        <div class="form-group">
                                            <label class="col-form-label">{{__('Action')}}</label>
                                            <select class="form-control action @error('route') is-invalid @enderror" style="border-right: 1px solid  red;" name="route">
                                                <option value="">{{__('Choose')}}....</option>
                                                @foreach($yActions as $action)
                                                <option value="{{$action}}"><?php echo ucfirst(camelToTitle($action)); ?></option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 noActions">
                                        <div class="form-group">
                                            <label class="col-form-label">Action</label>
                                            <select class="form-control  action @error('action') is-invalid @enderror" style="border-right: 1px solid  red;" name="route" >
                                                <option value="">{{__('Choose')}}....</option>
                                                @foreach($nActions as $action)
                                                <option value="{{$action}}"><?php echo ucfirst(camelToTitle($action)); ?></option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{__('Name')}} <span class="text-danger">*</span></label>
                                            <input class="form-control @error('name') is-invalid @enderror" type="text" style="border-right: 1px solid  red;" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group" id="iconLists">
                                            <label class="col-form-label">Icon <span class="text-danger">*</span></label>
                                            <input type="text" id="someName" name="icon" class="icon-picker @error('icon') is-invalid @enderror" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- END card-->
                    </div>

                    <div class="col-sm-6">
                        <!-- START card-->
                        <div class="card p-4 b-01 ">
                            <div class="card-header">
                                <h3 class="card-title">{{__('Section Names')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{__('Name in English')}}</label>
                                            <input class="form-control  @error('english') is-invalid @enderror" type="text" name="english" style="border-right: 1px solid  red;" required>
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
