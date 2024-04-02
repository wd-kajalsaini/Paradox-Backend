@extends('layouts.header')
@section('content')
<!---Side Bar End-->
      <!-- Main section-->
      <section  id="sectionManager"class="section-container">
         <!-- Page content-->
         <div class="content-wrapper">
            <div class="content-heading px-4">
               <div>{{__('System')}}/{{__('Managers')}}</div><!-- START Language list-->
               <!--div class="ml-auto">
                  <div class="btn-group"><button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret" type="button" data-toggle="dropdown">English</button>
                     <div class="dropdown-menu dropdown-menu-right-forced animated fadeInUpShort" role="menu"><a class="dropdown-item" href="#" data-set-lang="en">English</a><a class="dropdown-item" href="#" data-set-lang="es">Spanish</a></div>
                  </div>
               </div--><!-- END Language list-->
            </div><!-- START cards box-->

               <div class="pt-4 bg-white">
                     <!-- Nav tabs-->
                     <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item" role="presentation">
                           <a class="nav-link bb0 active" href="#home" aria-controls="home" role="tab" data-toggle="tab" aria-selected="true">
                              {{__('Managers')}}
                           </a>
                        </li>
                        <li class="nav-item" role="presentation">
                           <a class="nav-link bb1" href="#profile" aria-controls="profile" role="tab" data-toggle="tab" aria-selected="false">
                             {{__('Manager Types')}}
                           </a>
                        </li>
                     </ul><!-- Tab panes-->

                     <div class="tab-content p-0 bg-white">
                        <div class="tab-pane active" id="home" role="tabpanel">
                              <div class="row p-4"> 
                                 <div class="col-12 text-right ">
                                       <a href="{{route('addManagerAdd')}}"><button class="btn btn-primary btn-lg theme-btn " type="button">{{__('New')}}</button></a>
                                 </div>
                                 <div class="col-sm-12">
                                 @if (Session::has('manager'))
                                 <div class="alert alert-{{ session('class') }} alert-dismissible text-center">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    {{ session('manager') }}
                                 </div>
                                 @endif  
                                 </div>
                                 <div class="col-sm-12 p-1">
                                      <!-- Table Card Start-->
                                    <div class="card pl-0 pr-0 border">                                      
                                       <div class="table-responsive table_mob">
                                          <!-- Datatable Start-->
                                          <table class="table table-striped my-4 w-100" id="datatable1">
                                             <thead>
                                                <tr>
                                                    <th data-priority="1">{{__('Id')}}</th>
                                                    <th>{{__('Name')}}</th>
                                                    <th>{{__('Type')}}</th>
                                                    <th>{{__('Status')}}</th>
                                                    <th>{{__('Email')}}</th>
                                                    <th>{{__('Online')}} </th>
                                                    <th>{{__('Last Order')}}</th>
                                                    <th></th>
                                                </tr>
                                             </thead>
                                             <tbody>

                                              @foreach($managers as $manager)

                                                <tr class="gradeX">
                                                   <td>{{ $loop->iteration }}</td>
                                                   <td>{{ $manager->full_name }}</td>
                                                   <td>{{ $manager->managerType->name }}</td>
                                                   <td class="text-{{ $manager->status=='Active'?'success':'danger' }}">{{ $manager->status }}</td>
                                                   <td>{{ $manager->email }}</td>
                                                    <td class="text-success">Yes</td>
                                                   <td>12/03/2020 12:30</td>
                                                   <td class="text-right">
                                                      <!-- <button class="mb-1 btn btn-danger" type="button"><i class="fa fa-trash"></i> </button>  -->
                                                      <a href="{{route('editManager',$manager->id)}}"> <button class="mb-1 btn btn-info" type="button"><i class="fa fa-edit"></i> </button></a>
                                                    </td>
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
                        <div class="tab-pane" id="profile" role="tabpanel">
                               <div class="row p-4"> 
                                 <div class="col-sm-12">
                                       <a href="{{route('addManagerTypeAdd')}}"><button class="btn btn-primary btn-lg theme-btn " type="button">{{__('New')}}</button></a>
                                 </div>
                                 
                                 <div class="col-sm-12"> 
                                 @if (Session::has('managerType'))
                                 <div class="alert alert-{{ session('class') }} alert-dismissible text-center">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    {{ session('managerType') }}
                                 </div>
                                 @endif                                   
                                    <div class="pl-0 pr-0">                                      
                                       
                                          <div class="row">
                                          <div class="col-sm-3">
                                             <ul class="list-group">
                                              @foreach($managerTypes as $managerType)
                                                  <li class="list-group-item mb-2">
                                                      <h4 class="typeData">{{$managerType->name}}</h4>
                                                     <div class="typeAction">
                                                            <!-- <a onclick="return confirm('Are you sure you want to delete this item?')" href="{{route('deleteManagerType',$managerType->id)}}"><button class="mb-1 btn btn-danger" type="button"><i class="fa fa-trash"></i></button></a> -->
                                                            <a href="{{route('editManagerType',$managerType->id)}}"><button class="mb-1 btn btn-info" type="button"><i class="fa fa-edit"></i> </button></a>  
                                                       </div>
                                                   </li>  
                                              @endforeach   

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
      </section>
      
@endsection