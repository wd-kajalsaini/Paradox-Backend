@extends('layouts.header')

@section('content')

<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading  px-4">
            <div>{{__('Dashboard')}} </div>
        </div>
        @if (Session::has('change'))
        <div class="alert alert-{{session('class')}} alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('change') }}
        </div>
        @endif
        <div class="p-3">
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <!-- START card-->
                    <div class="card bg-danger-dark border-0" style="padding:0px">
                        <div class="row align-items-center mx-0">
                            <div class="col-3 text-center"><em class="fa fa-users fa-2x"></em></div>
                            <div class="col-9 py-4 bg-danger rounded-right">
                                <div class="h1 m-0 text-bold">{{ $total_users }}</div>
                                <div class="sub_title_card">Total users</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <!-- START card-->
                    <div class="card bg-warning-dark border-0" style="padding:0px">
                        <div class="row align-items-center mx-0">
                            <div class="col-3 text-center"><em class="fa fa-credit-card fa-2x"></em></div>
                            <div class="col-9 py-4 bg-warning rounded-right">
                                <div class="h1 m-0 text-bold">{{ $total_payments_for_products }}</div>
                                <div class="sub_title_card">Total payments for products</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <!-- START card-->
                    <div class="card bg-green-dark border-0" style="padding:0px">
                        <div class="row align-items-center mx-0">
                            <div class="col-3 text-center"><em class="fa fa-envelope fa-2x"></em></div>
                            <div class="col-9 py-4 bg-green rounded-right">
                                <div class="h1 m-0 text-bold">{{ $unread_messages }}</div>
                                <div class="sub_title_card">No. of unread messages</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <!-- START card-->
                    <div class="card bg-primary-dark border-0" style="padding:0px">
                        <div class="row align-items-center mx-0">
                            <div class="col-3 text-center"><em class="fa fa-users fa-2x"></em></div>
                            <div class="col-9 py-4 bg-primary rounded-right">
                                <div class="h1 m-0 text-bold">{{ $online_users }}</div>
                                <div class="sub_title_card">Total online/active users</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-12">
                    <!-- Table Card Start-->
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-8 col-sm-12 ">
                                    <h4 class="mt-3">User activity graph</h4>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <select class="form-control" id="graph_month_dropdown">
                                        <option value="01" <?php echo (date('m') == 1) ? "selected" : ""; ?>>January</option>
                                        <option value="02" <?php echo (date('m') == 2) ? "selected" : ""; ?>>February</option>
                                        <option value="03" <?php echo (date('m') == 3) ? "selected" : ""; ?>>March</option>
                                        <option value="04" <?php echo (date('m') == 4) ? "selected" : ""; ?>>April</option>
                                        <option value="05" <?php echo (date('m') == 5) ? "selected" : ""; ?>>May</option>
                                        <option value="06" <?php echo (date('m') == 6) ? "selected" : ""; ?>>June</option>
                                        <option value="07" <?php echo (date('m') == 7) ? "selected" : ""; ?>>July</option>
                                        <option value="08" <?php echo (date('m') == 8) ? "selected" : ""; ?>>August</option>
                                        <option value="09" <?php echo (date('m') == 9) ? "selected" : ""; ?>>September</option>
                                        <option value="10" <?php echo (date('m') == 10) ? "selected" : ""; ?>>October</option>
                                        <option value="11" <?php echo (date('m') == 11) ? "selected" : ""; ?>>November</option>
                                        <option value="12" <?php echo (date('m') == 12) ? "selected" : ""; ?>>December</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-body p-0 p-md-4">
                                <div class="chart-bar-dashboard flot-chart" style="height: 450px"></div>
                            </div>
                        </div>
                        <!-- Table Card End-->
                    </div>


                    <!-- Table Card Start-->
                    <div class="card p-2 p-md-4">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="mb-0">Unread Contact Us Table</h4>
                            </div>
                            <div class="col-4 text-right ">
                                <a href="{{route('inboxListing')}}"><button class="btn btn-primary btn-sm theme-btn " type="button">View All</button></a>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <!-- Datatable Start-->
                            <table class="table table-striped table-hover my-4 w-100" id="contactUs">
                                <thead>
                                    <tr>
                                        <th data-priority="1">{{__('Id')}}</th>
                                        <th>{{__('User name')}}</th>
                                        <th>{{__('Date')}}</th>
                                        <th>{{__('Subject')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inbox_data as $messages)
                                    <tr class="show_message" data-id="{{ $messages->id }}">
                                        <td>{{ $messages->id }}</td>
                                        <td>{{ $messages->username }}</td>
                                        <td>{{ date('d/m/Y',strtotime($messages->created_at)) }}</td>
                                        <td>{{ $messages->subject }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Datatable Start-->
                        </div>
                    </div>
                    <!-- Table Card End-->

                </div>
            </div>
        </div>

</section>
@endsection

@section('modals')
<div id="myModal" class="modal " tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <img class="mb-mail-avatar mr-2" alt="Mail Avatar" src="img/user/01.jpg" style="width: 30px">
                <div>
                    <h4 class="m-0">Evelyn Holmes</h4>
                    <span class="font-12">12Feb,2020 10:23PM</span>
                </div>
            </div>
            <div class="modal-body" style="max-height: 300px;">
                <b>Hi Bro...</b>
                <p>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. <Br><Br>

                    Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.<Br><Br>

                    Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar,</p>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button></div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('vendor/flot/jquery.flot.js')}}"></script>

<script src="{{ asset('vendor/jquery.flot.tooltip/js/jquery.flot.tooltip.js')}}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.resize.js')}}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.pie.js')}}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.time.js')}}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.categories.js')}}"></script>
<script src="{{ asset('vendor/jquery.flot.spline/jquery.flot.spline.js')}}"></script>

<script>
    $('#contactUs').on('click', '.show_message', function() {
        var thiss = $(this);
        var data_id = $(this).data('id');
        $.ajax({
            url: "{{ route('markReadAjax') }}",
            type: "POST",
            data: {
                "data_id": data_id,
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                $(document).find(".modal-content").html(response);
                $("#myModal").modal();
                thiss.parents('tr').find('td.read_status').html('No');
            }
        });
    });


    function initFlotBar(graph_data) {

        //    var data = [{
        //            "label": "Active Users",
        //            "color": "#9cd159",
        //            "data": [
        //                [1, 27],
        //                [2, 82],
        //                [3, 56],
        //                [4, 14],
        //                [5, 28],
        //                [6, 77],
        //                [7, 23],
        //                [8, 49],
        //                [9, 81],
        //                [10, 20],
        //            ]
        //        }];
        var data = [{
            "label": "Active Users",
            "color": "#9cd159",
            "data": graph_data
        }];
        console.log(graph_data);
        var options = {
            series: {
                bars: {
                    align: 'center',
                    lineWidth: 0,
                    show: true,
                    barWidth: 0.6,
                    fill: 0.9
                }
            },
            grid: {
                borderColor: '#eee',
                borderWidth: 1,
                hoverable: true,
                backgroundColor: '#fcfcfc'
            },
            tooltip: true,
            tooltipOpts: {
                content: function(label, x, y) {
                    return x + ' : ' + y;
                }
            },
            xaxis: {
                tickColor: '#fcfcfc',
                mode: 'categories'
            },
            yaxis: {
                // position: 'right' or 'left'
                tickColor: '#eee'
            },
            shadowSize: 0
        };

        var chart = $('.chart-bar-dashboard');
        if (chart.length)
            $.plot(chart, data, options);

    }

    //(function () {
    //    'use strict';
    //
    //
    //    $(initFlotBar)
    //
    //
    //
    //})();
    $(window).on('load', function() {
        initFlotBar(<?php print_r($active_users); ?>);
    })


    $('#graph_month_dropdown').on('change', function() {
        var selected_month = $(this).val();
        $.ajax({
            url: "{{route('graphDataAjax')}}",
            type: "POST",
            data: {
                "month": selected_month,
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                initFlotBar(JSON.parse(response));
            }
        })
    })
</script>
@endsection