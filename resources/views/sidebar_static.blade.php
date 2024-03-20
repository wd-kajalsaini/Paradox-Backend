<li class="Dashboard">
    <a  href="{{ route('dashboardListing') }}"  title="Dashboard" >
        <em class="glyphicon glyphicon-dashboard"></em><span>Dashboard</span>
    </a>
    <ul class="sidebar-nav sidebar-subnav collapse" id="Dashboard">

    </ul>
</li>

<li class="App_Settings">
    <a href="#App_Settings" data-toggle='collapse' title="App Settings" >
        <em class="glyphicon glyphicon-cog"></em><span>App Settings</span>
    </a>
    <ul class="sidebar-nav sidebar-subnav collapse" id="App_Settings">
        <li class="Content_Management">
            <a href="{{ route('contentManagementListing') }}" title="Content Management">
                <span><em class="glyphicon glyphicon-equalizer"></em>&nbsp;&nbsp;Content Management</span>
            </a>
        </li>
    </ul>
</li>

<li class="Push_Notification">
    <a href="{{ route('pushNotificationListing') }}"  title="Push Notification" >
        <em class="glyphicon glyphicon-envelope"></em><span>Push Notification</span>
    </a>
    <ul class="sidebar-nav sidebar-subnav collapse" id="Push_Notification">
    </ul>
</li>

<li class="Shows">
    <a  href="{{ route('showsListing') }}"  title="Shows" >
        <em class="fa fa-video"></em><span>Shows</span>
    </a>
    <ul class="sidebar-nav sidebar-subnav collapse" id="Shows">
    </ul>
</li>

<li class="Section_Management">
    <a  href="{{ route('appSectionsListing') }}"  title="Section Management" >
        <em class="fa fa-th-large"></em><span>Section Management</span>
    </a>
    <ul class="sidebar-nav sidebar-subnav collapse" id="Section_Management">
    </ul>
</li>

<li class="Banner_Shows">
    <a href="{{ route('bannerShowsListing') }}"  title="Banner Shows" >
        <em class="fa fa-tasks"></em><span>Banner Shows</span>
    </a>
    <ul class="sidebar-nav sidebar-subnav collapse" id="Banner_Shows">
    </ul>
</li>

<li class="Live_Shows">
    <a href="{{ route('liveShowListing') }}"  title="Live Shows" >
        <em class="fa fa-play"></em><span>Live Shows</span>
    </a>
    <ul class="sidebar-nav sidebar-subnav collapse" id="Live_Shows">
    </ul>
</li>

<li class="Players">
    <a href="{{ route('playersListing') }}"  title="Players" >
        <em class="fa fa-group"></em><span>Players</span>
    </a>
    <ul class="sidebar-nav sidebar-subnav collapse" id="Players">
    </ul>
</li>

<li class="Teams">
    <a href="{{ route('teamsListing') }}"  title="Teams" >
        <em class="fa fa-user-friends"></em><span>Teams</span>
    </a>
    <ul class="sidebar-nav sidebar-subnav collapse" id="Teams">
    </ul>
</li>

<li class="Application_Users">
    <a  href="{{ route('applicationUsersListing') }}"  title="Application Users" >
        <em class="fa fa-group"></em><span>Application Users</span>
    </a>
    <ul class="sidebar-nav sidebar-subnav collapse" id="Application_Users">
    </ul>
</li>

<!-- <li class="System">
    <a href="#System" data-toggle='collapse' title="System" >
        <em class="fa fa-store"></em><span>System</span>
    </a>
    <ul class="sidebar-nav sidebar-subnav collapse" id="System">
        <li class="Managers">
            <a href="{{ route('managersListing') }}" title="Managers">
                <span><em class="   "></em>&nbsp;&nbsp;Managers</span>
            </a>
        </li>
        <li class="System_Sections">
            <a href="{{ route('sectionsListing') }}" title="System Sections">
                <span><em class=" "></em>&nbsp;&nbsp;System Sections</span>
            </a>
        </li>
    </ul>
</li> -->
