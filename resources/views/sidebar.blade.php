
@foreach($sections as $section)
@if($section['permission']['permission']!==0)
   <li class="{{str_replace(' ','_',$section['name'])}}">
  @if(count($section['subSections'])==0)
    <a  href="{{Route::has($section['route'])?route($section['route']):''}}"  title="{{$section['name']}}" >
  @else
    <a  href="#{{str_replace('&','',str_replace(' ','_',$section['name']))}}" data-toggle='collapse' title="{{$section['name']}}" >
  @endif
     <em class="{{$section['icon']}}"></em><span>{{$section['english']}}</span>

     </a>
     @if($section['subSections']!=="")
        <ul class="sidebar-nav sidebar-subnav collapse" id="{{str_replace('&','',str_replace(' ','_',$section['name']))}}">
          @foreach($section['subSections'] as $subSection)
            @if($subSection['permission']['permission']!==0)
              <li class="{{str_replace(' ','_',$subSection['name'])}}">
                <a href="{{Route::has($subSection['route'])?route($subSection['route']):''}}" title="{{$subSection['name']}}">
                <span><em class="{{$subSection['icon']}}"></em>&nbsp;&nbsp;{{$subSection['english']}}</span>
                </a>
              </li>
            @endif
          @endforeach

        </ul>
     @endif

  </li>
@endif
@endforeach
