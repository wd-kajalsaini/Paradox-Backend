@extends('layouts.header')
@section('content')

<!-- Main section-->
<section  class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            <div class="text-dark">Show : {{ $show->title }}</div>
        </div><!-- START cards box-->

        <div class="p-3">
            <!-- Table Card Start-->
            <div class="card pl-0 pr-0 border">
                <div class="card-header">
                    <div class="col-sm-10 ">
                        <h4 class="mt-3">Questions</h4>
                    </div>
                    <div class="col-sm-2 text-right">
                        <a href="{{ route('showQuestionAdd',$id)}}">
                            <button class="btn theme-blue-btn btn-md theme-btn mt-3" type="button">Create New Question</button>
                        </a>
                    </div>
                </div>
                <div class="row ">

                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <!-- Datatable Start-->
                            <table class="table table-striped table-hover my-4 w-100" id="datatable1">
                                <thead>
                                    <tr>
                                        <th data-priority="1">Id</th>
                                        <th>Title</th>
                                        <th>Duration</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($show_questions))
                                    @foreach($show_questions as $question)
                                    <tr>
                                        <td>{{ $question->id }}</td>
                                        <td>{{ $question->title }}</td>
                                        <td>{{ $question->duration }} seconds</td>
                                        <td class="text-right">
                                            <button class="mb-1 btn btn-danger delete_question" type="button" data-id="{{$question->id}}" title="Delete"><i class="fa fa-trash"></i> </button>
                                            <a href="{{ route('showQuestionEdit',[$show->id,$question->id]) }}" class="mb-1 btn btn-info" type="button" title="Edit"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <!-- Datatable Start-->
                        </div>
                    </div>
                    <!-- Table Card End-->
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@section('modals')

@endsection

@section('script')
<script>
$(document).on('click', ".delete_question", function () {
    var thiss = $(this);
    var data_id = thiss.data('id');
    swal({
        title: "Are you sure!",
        text: "It will permanently delete this question",
        icon: "warning",
        buttons: ["Cancel", "Yes"],
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "{{route('showsListing')}}" + '/delete_question/' + data_id,
                type: "DELETE",
                data: {"_token": "{{ csrf_token() }}"},
                success: function (response) {
                    var result = response;
                    if (result.status == 1) {
                        window.location = "";
                    } else {
                        swal('Error', result.message, 'error');
                    }
                    return false;
                },
            });
            return true;
        } else {
            return false;
        }
    })
})
</script>
@endsection
