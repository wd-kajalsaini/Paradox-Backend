@extends('layouts.header')
@section('content')
<!-- Main section-->
<section  id="sectionManager"class="section-container">
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            <div class="text-dark">{{__('System')}}/{{__('Dictionary')}}</div><!-- START Delete Btn -->
            <div class="ml-auto">
                <a href="{{route('addDictionaryAdd')}}"><button class="btn btn-info btn-lg" type="button">{{__('New')}}</button></a>
            </div><!-- END  Delete Btn-->
        </div><!-- START cards box-->

        <div class="p-3">


            <div class="tab-content p-0 bg-white">
                <div class="tab-pane active" id="home" role="tabpanel">
                    <div class="row">
                        <div class="col-sm-12">

                            <!-- Table Card Start-->
                            <div class="card pl-0 pr-0 border">                                      
                                <div class="">
                                    <!-- Datatable Start-->
                                    <table class="table table-striped my-4 w-100" id="datatable1">
                                        <thead>
                                            <tr>
                                                <th data-priority="1">{{__('Id')}}</th>
                                                <th>{{__('Variable')}}</th>
                                                <th>{{__('Hebrew')}}</th>
                                                <th>{{__('English')}}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dictionary as $dictionary)
                                            <tr class="gradeX">
                                                <td>{{$loop->iteration}}</td>
                                                <td  class="text-capitalize">{{$dictionary->variable}}</td>
                                                <td class="text-capitalize">{{$dictionary->hebrew}}</td>
                                                <td class="text-capitalize">{{$dictionary->english}}</td>
                                                 <td class="text-right"><!--<button class="mb-1 btn btn-danger" type="button"><i class="fa fa-trash"></i> </button>  -->
                                                    <a href="{{route('editDictionary',$dictionary->id)}}"><button class="mb-1 btn btn-info" type="button"><i class="fa fa-edit"></i> </button></a>
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
                            <a href="newManagerType.php"><button class="btn btn-primary btn-lg theme-btn " type="button">New</button></a>
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