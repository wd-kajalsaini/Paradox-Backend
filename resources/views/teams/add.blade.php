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
            <div>Add New Team</div>
            <!-- START Language list-->
        </div>
        <div class="card m-3 border">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10 ">
                        <h4 class="mt-3">New Team Details</h4>
                        <p class="btn btn-info" onclick="goBack()">Back</p>
                    </div>
                    <div class="col-sm-2 text-right">
                    </div>
                    <div class="col-12"><hr>
                    </div>
                </div>
            </div>
            <div class="">
                <form method="post" data-parsley-validate="" novalidate="" enctype="multipart/form-data">
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
                                <label for="validationCustom01">Players</label>
                            </div>
                            <div class="col-sm-9">
                                <select multiple id="showselection" name="players[]" placeholder="" class="form-control ctSelectBox1" required="" >
                                    @foreach($players as $player)
                                  <option  value="{{ $player->id }}" data-image="{{ !empty($player->thumbnail)?$player->thumbnail:asset('img/avatarEmpty.png') }}">
                                    {{ $player->name }}
                                    </option>
                                    @endforeach
                                 </select>
                                <div class="invalid-feedback">Please select a player</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-3 text-right mt-1">
                                <label for="validationCustom01">Logo</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type='file' id="imgInp" name="thumbnail" />
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Preview:</b>
                                        <div class="preview_thumb mt-2"><img id="blah" src="{{ asset('img/avatarEmpty.png') }}" alt="Team Logo" />
                                            <div class="del_btn" id="delet_photo"><i class="fa fa-times"></i></div>
                                        </div>
                                    </div>
                                </div>
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
    </section>

@endsection

@section('modals')

@endsection

@section('script')
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

$("#imgInp").change(function() {
    readURL(this);
    $('.del_btn').show();
});

$("#delet_photo").click(function()
{
    $('#blah').attr('src',"{{ asset('img/avatarEmpty.png') }}");
    $('.del_btn').hide();
    $("#imgInp").val("");
});

function formatState(state) {
    if (!state.id) return state.text; // optgroup

    var originalOption = state.element;

    var option = "<span style='display:inline-block;' class='show_box'><img class='mr-2 rounded' src='" + $(originalOption).data('image') + "' /></span> "+ state.text;
    return option;
    //console.log(state.text);
}
$(".ctSelectBox1").select2({
	templateResult: formatState,
	//formatSelection: format,
    placeholder: "Select player(s)",
	escapeMarkup: function(m)
	{
		return m;
	}
});
</script>
@endsection
