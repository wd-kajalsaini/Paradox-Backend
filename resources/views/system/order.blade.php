@extends('layouts.header') @section('content')
<!-- Main section-->
<section id="sectionManager" class="section-container">
	<!-- Page content-->
	<div class="content-wrapper">
		<div class="content-heading">
			<div>System/System Section/Reoder</div>
			<div class="ml-auto">
				<button class="btn btn-primary btn-lg theme-btn" type="button" onclick="goBack()">Back</button>
			</div>
			<!--- END Language list--->
		</div>
		<!-- START cards box-->
		<div class="card card-transparent" role="tabpanel">
			<div class="container-fluid">
				<div class="js-nestable-action"> <a class="btn btn-secondary btn-sm mr-1" id="expandAll">Expand All</a>
					<a class="btn btn-secondary btn-sm" id="collapseAll">CollapseAll</a>
				</div>
				<div class="row">
					<div class="col-lg-6 mt-3">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="sections-box first-section">
									<div class="panel-group panel-daggable ui-sortable" id="accordion" data-url="{{route('reOrder')}}">
                           @csrf
                           @foreach($sections as $section)
										<div class="panel panel-default ui-sortable-handle oSection" data-id="{{$section['id']}}">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$section['id']}}">
												<div class="panel-heading">
													<p class="pl-2 mb-0"> <em class="fas fa-bars fa-fw text-muted mr-2"></em>
														<span class="navTitle">{{$section['name']}}</span>
													</p>
												</div>
											</a>
                                 @if(count($section['sub_sections'])!==0)
                                    <div id="collapse{{$section['id']}}" class="panel-collapse collapse allCollpsehide">
                                       <div class="panel-body">
                                          <div class="panel-group panel-daggable ui-sortable">
                                             
                                                @foreach($section['sub_sections'] as $subsection)
                                                   <div class="panel panel-default oSubSection" data-id="{{$subsection['id']}}">
                                                      
                                                      <div class="panel-heading">
                                                         <p class="pl-2 mb-0"> <em class="fas fa-bars fa-fw text-muted mr-2"></em>
                                                            <span class="navTitle">{{$subsection['name']}}</span>
                                                         </p>
                                                      </div>
                                                   </div>
                                                @endforeach
                                             
                                          </div>
                                       </div>
                                    </div>
                                 @endif
										</div>
										<!-- panel Closed -->
										<!-- panel Closed -->
                              @endforeach</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
   </div>
</section>@endsection