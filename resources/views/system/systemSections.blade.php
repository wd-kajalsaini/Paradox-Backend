@extends('layouts.header')
@section('content')
<!-- Main section-->
<section id="sectionManager" class="section-container">
   <!-- Page content-->
   <div class="content-wrapper">
      <div class="content-heading px-4 d-block d-md-flex">
         <div>{{__('System')}}/{{__('Section')}}</div><!-- START Delete Btn -->
         <div class="ml-auto mt-3 mt-md-0">
            <a href="{{route('addSectionAdd')}}"><button class="btn btn-info" type="button">New</button></a>
            <a href="{{route('reOrder')}}"><button class="btn btn-info" type="button">Reorder</button></a>
            <button class="btn btn-info" type="button" onclick="goBack()">Back</button>
         </div><!-- END  Delete Btn-->
      </div><!-- START cards box-->

      <div class="">

         <div class="tab-content p-0 bg-white">
            <div class="tab-pane active" id="home" role="tabpanel">
               <div class="row p-4">
                  <div class="col-sm-12 p-0">
                     @if (Session::has('section'))
                     <div class="alert alert-{{ session('class') }} alert-dismissible text-center">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session('section') }}
                     </div>
                     @endif
                     <!-- Table Card Start-->
                     <div class="card pl-0 pr-0 border">
                        <div class="table-responsive table_mob">
                           <!-- Datatable Start-->
                           <table class="table table-striped my-4 w-100" id="datatable1">
                              <thead>
                                 <tr>
                                    <th data-priority="1">{{__('Id')}}</th>
                                    <th>{{__('Parent Section')}}</th>
                                    <th>{{__('Child')}} </th>
                                    <th>{{__('Grand Child')}}</th>
                                    <th>{{__('Icon')}}</th>
                                    <th>{{__('Production Date')}}</th>
                                    <th>{{__('User Created')}}</th>
                                    <th>{{__('Update Date')}}</th>
                                    <th>{{__('Updated User')}}</th>
                                    <th></th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 $id = 1;
                                 ?>
                                 @foreach($hSections as $section)
                                 <tr class="gradeX">
                                    <td>{{$id}}</td>
                                    <td>
                                       {{$section['name']}}
                                    </td>
                                    <td>&#8212;</td>
                                    <td>&#8212;</td>
                                    <td><em class="{{ $section['icon'] }}" aria-hidden="true"></em></td>
                                    <td>{{ $section['created_at'] }}</td>
                                    <td>{{ $section['created_by'] }}</td>
                                    <td>{{ $section['updated_at'] }}</td>
                                    <td>{{ $section['updated_by'] }}</td>
                                    <td class="text-right">
                                       <a href="{{route('editSection',$section['id'])}}"><button class="mb-1 btn btn-info" type="button"><i class="fa fa-edit"></i> </button></a>
                                    </td>
                                 </tr>

                                 @if($section['sub_sections']!=="")

                                 @foreach($section['sub_sections'] as $subSection)
                                 <tr class="gradeX">
                                    <td>{{$id+1}}</td>

                                    <td>&#8212;</td>
                                    <td>{{$subSection['name']}}</td>
                                    <td>&#8212;</td>
                                    <td><em class="{{ $subSection['icon'] }}" aria-hidden="true"></em></td>
                                    <td>{{ $subSection['created_at'] }}</td>
                                    <td>{{ $subSection['created_by'] }}</td>
                                    <td>{{ $subSection['updated_at'] }}</td>
                                    <td>{{ $subSection['updated_by'] }}</td>
                                    <td class="text-right">
                                       <a href="{{route('editSection',$subSection['id'])}}"><button class="mb-1 btn btn-info" type="button"><i class="fa fa-edit"></i> </button></a>
                                    </td>
                                 </tr>

                                 @if($subSection['sub_sections']!=="")

                                 @foreach($subSection['sub_sections'] as $sSubSection)
                                 <tr class="gradeX">
                                    <td>{{$id+2}}</td>
                                    <td>&#8212;</td>
                                    <td>&#8212;</td>
                                    <td>{{$sSubSection['name']}}</td>
                                    <td><em class="{{ $sSubSection['icon'] }}" aria-hidden="true"></em></td>
                                    <td>{{ $sSubSection['created_at'] }}</td>
                                    <td>{{ $sSubSection['created_by'] }}</td>
                                    <td>{{ $sSubSection['updated_at'] }}</td>
                                    <td>{{ $sSubSection['updated_by'] }}</td>
                                    <td class="text-right">
                                       <a href="{{route('editSection',$sSubSection['id'])}}"><button class="mb-1 btn btn-info" type="button"><i class="fa fa-edit"></i> </button></a>
                                    </td>
                                 </tr>
                                 <?php $id++; ?>
                                 @endforeach
                                 @endif
                                 <?php $id++; ?>
                                 @endforeach
                                 @endif
                                 <?php $id++; ?>
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
            <div class="tab-pane" id="profile" role="tabpanel">
               <div class="row p-4">
                  <div class="col-sm-12">
                     <a href=""><button class="btn btn-primary btn-lg theme-btn " type="button">New</button></a>
                  </div>
                  <div class="col-sm-12">
                     <div class="card">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-sm-5">
                                 <ul class="list-group">
                                    <li class="list-group-item mb-2">
                                       <h4 class="typeData">Super Manager</h4>
                                       <div class="typeAction">
                                          <button class="mb-1 btn btn-danger" type="button"><i class="fa fa-trash"></i></button>
                                          <button class="mb-1 btn btn-info" type="button"><i class="fa fa-edit"></i> </button>
                                       </div>
                                    </li>
                                    <li class="list-group-item mb-2">
                                       <h4 class="typeData">Product Manager</h4>
                                       <div class="typeAction">
                                          <button class="mb-1 btn btn-danger" type="button"><i class="fa fa-trash"></i></button>
                                          <button class="mb-1 btn btn-info" type="button"><i class="fa fa-edit"></i> </button>
                                       </div>
                                    </li>
                                    <li class="list-group-item mb-2">
                                       <h4 class="typeData">Application User Manager</h4>
                                       <div class="typeAction">
                                          <button class="mb-1 btn btn-danger" type="button"><i class="fa fa-trash"></i></button>
                                          <button class="mb-1 btn btn-info" type="button"><i class="fa fa-edit"></i> </button>
                                       </div>
                                    </li>

                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection