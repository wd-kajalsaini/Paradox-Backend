@extends('layouts.header')
@section('content')

<style>
.checkInput {
    opacity: 1 !important;
    top: 0;
    position: inherit !important;
    height: 24px !important;
    padding: 0;
}
</style>
<section class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            <div>{{__('Kvitel Id Restriction')}}</div><!-- START Language list-->
        </div>
        <div class="p-3">
            <div class="p-0 bg-white border">
                <form method="POST" action="{{route('kvitelIdRestrictionsListing')}}">
                    @csrf
                    <div class="row p-4">
                        <div class="col-sm-6">
                            <div class="checkbox c-checkbox"><label><input type="checkbox" name="start_with_zero" value="1" <?php echo!empty($restrictions->start_with_zero) ? "checked" : ""; ?>><span class="fa fa-check"></span> The number can’t start with zero - 0</label></div>
                            <div class="checkbox c-checkbox"><label><input type="checkbox" name="five_digit_sequence_between" value="1" <?php echo!empty($restrictions->five_digit_sequence_between) ? "checked" : ""; ?>><span class="fa fa-check"></span> The number can’t contain <input type="number" class="checkInput" name="five_digit_sequence_between_input" value="<?php echo $restrictions->five_digit_sequence_between_input;?>" min="2" max="9">-digit sequence</label></div>
                            <div class="checkbox c-checkbox"><label><input type="checkbox" name="same_number_repeated_four_times_or_more" value="1" <?php echo!empty($restrictions->same_number_repeated_four_times_or_more) ? "checked" : ""; ?>><span class="fa fa-check"></span> The number can’t have the same number repeated <input type="number" class="checkInput" name="same_number_repeated_four_times_or_more_input"  value="<?php echo $restrictions->same_number_repeated_four_times_or_more_input;?>" min="2" max="9"> times or more</label></div>
                            <div class="checkbox c-checkbox"><label><input type="checkbox" name="starting_with_five_digit_or_more_ascending" value="1" <?php echo!empty($restrictions->starting_with_five_digit_or_more_ascending) ? "checked" : ""; ?>><span class="fa fa-check"></span> Can't start with <input type="number" class="checkInput" name="starting_with_five_digit_or_more_ascending_input"  value="<?php echo $restrictions->starting_with_five_digit_or_more_ascending_input;?>" min="2" max="9"> digits (or more) in ascending order</label></div>
                            <div class="checkbox c-checkbox"><label><input type="checkbox" name="starting_with_five_digit_or_more_descending" value="1" <?php echo!empty($restrictions->starting_with_five_digit_or_more_descending) ? "checked" : ""; ?>><span class="fa fa-check"></span> Can't start with <input type="number" class="checkInput" name="starting_with_five_digit_or_more_descending_input"  value="<?php echo $restrictions->starting_with_five_digit_or_more_descending_input;?>" min="2" max="9"> digits (or more) in descending order</label></div>
                            <div class="checkbox c-checkbox"><label><input type="checkbox" name="four_different_digits" value="1" <?php echo!empty($restrictions->four_different_digits) ? "checked" : ""; ?>><span class="fa fa-check"></span> A number must contain at least <input type="number" class="checkInput" name="four_different_digits_input"  value="<?php echo $restrictions->four_different_digits_input;?>" min="2" max="9"> different digits</label></div>
                            <div class="form-group">
                                <label class="col-form-label">Number Range Starting Value</label>
                                <input class="form-control" type="number" min="0" name="number_range_start" value="{{ $restrictions->number_range_start}}" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Number Range Ending Value</label>
                                <input class="form-control" type="number" max="999999999" name="number_range_end" value="{{ $restrictions->number_range_end }}" required>
                            </div>
                            <button class="btn btn-primary mb-2" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection