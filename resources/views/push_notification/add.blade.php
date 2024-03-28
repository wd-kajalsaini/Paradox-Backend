@extends('layouts.header')
@section('content')

<section id="sectionManager"class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">

        <div class="content-heading px-4 d-block d-md-flex">
            <div>{{__('Push Notification')}} / {{__('Send New')}}</div><!-- START Delete Btn -->
            <div class="ml-auto mt-3 mt-md-0 text-end">
                <button class="btn btn-info btn-lg" type="submit" form="send_notification">{{ __('Send')}}</button>
                <button class="btn btn-info btn-lg" type="button" onclick="goBack()">{{ __('Back')}}</button>
            </div><!-- END  Delete Btn-->
        </div><!-- START cards box-->

        <div class="p-3">
            <form method="POST" action="{{route('sendPushNotificationAdd')}}" id="send_notification">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card pl-0 pr-0 border">
                            <div class="card-body">
                                <!-- p.lead.text-centerNo mails here-->
                                <div class="row p-4">
                                    <div class="col-sm-12">
                                        <h4 class="">{{ __('Send New Notification')}}</h4>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 col-sm-2 text-right">
                                        <label class="col-form-label">{{ __('Notification Title')}}</label>
                                    </div>
                                    <div class="col-12 col-sm-10">
                                        <input class="form-control" type="text" name="title" required="">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 col-sm-2 text-right">
                                        <label class="col-form-label">{{ __('Notification Description')}}</label>
                                    </div>
                                    <div class="col-12 col-sm-10">
                                        <textarea class="form-control" rows="3" name="text" required></textarea>
                                        <input type="hidden" name="whom_send[]" value="subscribed_users">
                                    </div>
                                </div>
                                <!-- <div class="row mt-3">
                                    <div class="col-12 col-sm-2 text-right">
                                        <label class="col-form-label">{{ __('Notification Sent to')}}</label>
                                    </div>
                                    <div class="col-12 col-sm-10">
                                        <select class="form-control" id="select2-3" multiple="multiple" name="whom_send[]" required>
                                            <option value="subscribed_users">Send to All </option>
                                            @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{$user->first_name." ".$user->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
