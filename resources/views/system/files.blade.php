@extends('layouts.header')
@section('content')
@include('ckfinder::setup')
 <!-- Main section-->
    <section  id="sectionManager"class="section-container">
         <!-- Page content-->
        <div class="content-wrapper">
            <div class="content-heading">
                <div class="text-dark">{{__('System/Files')}}</div>
            </div><!-- START cards box-->

           	<div class="card card-transparent" role="tabpanel">
            	<div  id="ckfinder-widget" class="">

               	</div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
    	CKFinder.widget( 'ckfinder-widget', {
		// width: '100%',
		 // height: 800,
		 skin: 'moono',

		} );
    </script>
@endsection
