@extends('layouts.header')
@section('content')
<style type="text/css">
  .input-group-addon
  {
    padding: 8px 25px;
    width: 8%;
  }

  .del_btn {
      position: absolute;
      top: 3px;
      right: 3px;
      width: 20px;
      height: 20px;
      background: red;
      text-align: center;
      line-height: 20px;
      border-radius: 100%;
      color: #fff;
      display: none;
      z-index: 999;
  }
</style>

<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            <div>Show : {{ $show->title }}</div>
            <!-- START Language list-->
        </div>
        <div class="card m-3 border">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10 ">
                        <h4 class="mt-3">Add New Question</h4>
                        <p class="btn btn-info" onclick="goBack()">Back</p>
                    </div>
                    <div class="col-sm-2 text-right">
                    </div>
                    <div class="col-12"><hr>
                    </div>
                </div>
            </div>
            <div class="">
                <form method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row mt-1">
                            <div class="col-sm-3 text-right mt-1">
                                <label for="validationCustom01">Title</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="title" placeholder="" value="" required>
                                <div class="invalid-feedback">Please enter a Title</div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-3 text-right mt-1">
                                <label for="validationCustom01">Duration</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input class="form-control" type="number" name="duration" required="" min="1">
                                    <div class="input-group-append">
                                        <span class="input-group-text">seconds</span>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter a Duration</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-3 text-right mt-1">
                            </div>
                            <div class="col-sm-9">
                                <button class="btn theme-blue-btn" type="submit">Submit </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('modals')

@endsection

@section('script')
<script>

</script>
@endsection
