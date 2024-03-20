<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', function () {
    // if(Auth::check())
    // {
    // 	redirect()->back();
    // }
    return redirect()->route('login');
    //return view('auth.login');
});

Auth::routes(['register' => false]);

Route::group(['middleware' => 'localization'], function () {


    Route::get('/dashboard', 'HomeController@index')->name('dashboardListing');
    Route::post('/dashboard/graph_data', 'HomeController@graph_data')->name('graphDataAjax');

    /* App Users */

    Route::get('/users', 'Admin\UsersController@index')->name('applicationUsersListing');
    Route::get('users/add', 'Admin\UsersController@add')->name('addUser');
    Route::post('users/add', 'Admin\UsersController@add')->name('addUser');
    Route::get('users/view/{id}', 'Admin\UsersController@view')->name('editUserInfo');
    Route::post('users/view/{id}', 'Admin\UsersController@view')->name('editUserInfo');
    Route::delete('users/delete/{id}', 'Admin\UsersController@delete')->name('deleteApplicationUsers');
    Route::post('users/active_block/{id}', 'Admin\UsersController@active_block');

    //system
    Route::prefix('system')->group(function () {
        //listing have use to show yes route on sections
        //Add have use to show yes route on sections

        Route::get('managers', 'System\ManagersController@managers')->name('managersListing');
        Route::get('addManager', 'System\ManagersController@addManager')->name('addManagerAdd');
        Route::post('addManager', 'System\ManagersController@addManager')->name('addManagerAdd');
        Route::get('editManager/{id}', 'System\ManagersController@editManager')->name('editManager');
        Route::post('editManager/{id}', 'System\ManagersController@editManager')->name('editManager');
        Route::get('addManagerType', 'System\ManagersController@addManagerType')->name('addManagerTypeAdd');
        Route::post('addManagerType', 'System\ManagersController@addManagerType')->name('addManagerTypeAdd');
        Route::get('editManagerType/{id}', 'System\ManagersController@editManagerType')->name('editManagerType');
        Route::post('editManagerType/{id}', 'System\ManagersController@editManagerType')->name('editManagerType');
        Route::get('deleteManagerType/{id}', 'System\ManagersController@deleteManagerType')->name('deleteManagerType');
        Route::get('sections', 'System\SystemSectionsController@sections')->name('sectionsListing');
        Route::get('addSection', 'System\SystemSectionsController@addSection')->name('addSectionAdd');
        Route::post('addSection', 'System\SystemSectionsController@addSection')->name('addSectionAdd');
        Route::get('editSection/{id}', 'System\SystemSectionsController@editSection')->name('editSection');
        Route::post('editSection/{id}', 'System\SystemSectionsController@editSection')->name('editSection');
        Route::get('reOrder', 'System\SystemSectionsController@reOrder')->name('reOrder');
        Route::post('reOrder', 'System\SystemSectionsController@reOrder')->name('reOrder');
        //dictionary
        Route::get('dictionary', 'System\DictionaryController@dictionary')->name('dictionaryListing');
        Route::get('addDictionary', 'System\DictionaryController@addDictionary')->name('addDictionaryAdd');
        Route::post('addDictionary', 'System\DictionaryController@addDictionary')->name('addDictionaryAdd');
        Route::get('editDictionary/{id}', 'System\DictionaryController@editDictionary')->name('editDictionary');
        Route::post('editDictionary/{id}', 'System\DictionaryController@editDictionary')->name('editDictionary');
        //files
        Route::get('files', 'System\FilesController@index')->name('filesListing');
    });

    /* Subsection in App Section */
    Route::get('/app_content_management', 'Admin\AppContentController@index')->name('contentManagementListing');
    Route::post('/app_content_management', 'Admin\AppContentController@index')->name('contentManagementListing');
    Route::post('/app_content/app_content_field_ajax', 'Admin\AppContentController@app_content_field_ajax')->name('appContentFieldAjax');
    Route::post('app_content/update_limits', 'Admin\AppContentController@update_limits')->name('updateLimits');

    /* Extension Management */
    Route::get('/country_extension', 'Admin\ExtensionManagementController@index')->name('extensionManagementListing');
    Route::get('/country_extension/add', 'Admin\ExtensionManagementController@add')->name('addCountryExtensionAdd');
    Route::post('/country_extension/add', 'Admin\ExtensionManagementController@add')->name('addCountryExtensionAdd');
    Route::get('/country_extension/edit/{id}', 'Admin\ExtensionManagementController@edit')->name('editCountryExtension');
    Route::post('/country_extension/edit/{id}', 'Admin\ExtensionManagementController@edit')->name('editCountryExtension');
    Route::delete('/country_extension/delete/{id}', 'Admin\ExtensionManagementController@delete')->name('deleteCountryExtension');

    /* Kvitel Products */

    Route::get('kvitel_products', 'Admin\KvitelProductController@index')->name('kvitelProductsListing');
    Route::get('kvitel_products/add', 'Admin\KvitelProductController@add')->name('addKvitelProductAdd');
    Route::post('kvitel_products/add', 'Admin\KvitelProductController@add')->name('addKvitelProductAdd');
    Route::get('kvitel_products/edit/{id}', 'Admin\KvitelProductController@edit')->name('editKvitelProduct');
    Route::post('kvitel_products/edit/{id}', 'Admin\KvitelProductController@edit')->name('editKvitelProduct');
    Route::delete('kvitel_products/delete/{id}', 'Admin\KvitelProductController@delete')->name('deleteKvitelProduct');

    Route::get('setLocale/{locale}', 'System\DictionaryController@setLocale')->name('setLocale');
    Route::get('changePassword', 'Auth\ResetPasswordController@changePassword')->name('changePassword');
    Route::post('changePassword', 'Auth\ResetPasswordController@changePassword')->name('changePassword');

    Route::get('extension/export', 'Admin\ExtensionManagementController@export')->name('exportExtension');
    Route::post('extension/import', 'Admin\ExtensionManagementController@import')->name('importExtension');
    Route::get('kvitel_id_restrictions', 'Admin\KvitelIdController@index')->name('kvitelIdRestrictionsListing');
    Route::post('kvitel_id_restrictions', 'Admin\KvitelIdController@index')->name('kvitelIdRestrictionsListing');

    /* Inbox */

    Route::get('inbox', 'Admin\InboxController@index')->name('inboxListing');
    Route::post('/inbox/mark_read', 'Admin\InboxController@mark_read')->name('markReadAjax');

    /* Push Notifications */

    Route::get('push_notification', 'Admin\PushNotificationController@index')->name('pushNotificationListing');
    Route::get('push_notification/add', 'Admin\PushNotificationController@add')->name('sendPushNotificationAdd');
    Route::post('push_notification/add', 'Admin\PushNotificationController@add')->name('sendPushNotificationAdd');
    Route::post('push_notification/resend/{id}', 'Admin\PushNotificationController@resend')->name('resendPushNotification');

    /* Website Settings */

    Route::get('website_setting/add', 'Admin\WebsiteSettingController@add')->name('websiteSettingsAdd');
    Route::post('website_setting/add', 'Admin\WebsiteSettingController@add')->name('websiteSettingsAdd');

    /* Template Management */

    Route::get('template_management', 'Admin\TemplateController@index')->name('templateManagementListing');
    Route::post('template_management', 'Admin\TemplateController@index')->name('templateManagementListing');

    /* Groups */

    Route::get('admin/groups', 'Admin\GroupController@index')->name('groupsListing');
    Route::get('admin/groups/view/{id}', 'Admin\GroupController@view')->name('groupInfo');
    Route::delete('admin/groups/delete/{id}', 'Admin\GroupController@delete')->name('deleteGroup');

    /* Shows */

    Route::get('admin/shows', 'Admin\ShowController@index')->name('showsListing');
    Route::get('admin/shows/add', 'Admin\ShowController@add')->name('addShowAdd');
    Route::post('admin/shows/add', 'Admin\ShowController@add')->name('addShowAdd');
    Route::get('admin/shows/edit/{id}', 'Admin\ShowController@edit')->name('editShow');
    Route::post('admin/shows/edit/{id}', 'Admin\ShowController@edit')->name('editShow');
    Route::delete('admin/shows/delete/{id}', 'Admin\ShowController@delete')->name('deleteShow');
    Route::post('admin/shows/make_show_live/{id}', 'Admin\ShowController@make_show_live')->name('makeShowLive');
    Route::post('admin/shows/validate_team_players', 'Admin\ShowController@validate_team_players')->name('validateTeamPlayers');
    Route::get('admin/shows/subscribed_users/{id}', 'Admin\ShowController@subscribed_users')->name('subscribedShowUsers');
    Route::get('admin/shows/questions/{id}', 'Admin\ShowController@questions')->name('showQuestions');
    Route::get('admin/shows/question_add/{id}', 'Admin\ShowController@question_add')->name('showQuestionAdd');
    Route::post('admin/shows/question_add/{id}', 'Admin\ShowController@question_add')->name('showQuestionAdd');
    Route::get('admin/shows/question_edit/{show_id}/{id}', 'Admin\ShowController@question_edit')->name('showQuestionEdit');
    Route::post('admin/shows/question_edit/{show_id}/{id}', 'Admin\ShowController@question_edit')->name('showQuestionEdit');
    Route::delete('admin/shows/delete_question/{id}', 'Admin\ShowController@delete_question')->name('showQuestionDelete');
    Route::post('admin/shows/subscriber_notification/{id}', 'Admin\ShowController@subscriber_notification')->name('admin/shows/subscriber_notification');


    /* Section */

    Route::get('admin/sections', 'Admin\AppsectionController@index')->name('appSectionsListing');
    Route::post('admin/sections/sortOrder', 'Admin\AppsectionController@sortOrder')->name('appSectionsSorting');
    Route::get('admin/sections/add', 'Admin\AppsectionController@add')->name('addAppSectionsAdd');
    Route::post('admin/sections/add', 'Admin\AppsectionController@add')->name('addAppSectionsAdd');
    Route::get('admin/sections/edit/{id}', 'Admin\AppsectionController@edit')->name('editAppSections');
    Route::post('admin/sections/edit/{id}', 'Admin\AppsectionController@edit')->name('editAppSections');
    Route::delete('admin/sections/delete/{id}', 'Admin\AppsectionController@delete')->name('deleteAppSections');
    Route::get('admin/sections/shows/{id}', 'Admin\AppsectionController@shows')->name('showsRelatedToSection');
    Route::post('admin/sections/showSort', 'Admin\AppsectionController@showSort')->name('sectionShowSorting');

    /* Banner */

    Route::get('admin/banner/shows', 'Admin\BannerController@shows')->name('bannerShowsListing');
    Route::post('admin/banner/shows', 'Admin\BannerController@shows')->name('bannerShowsListing');
    Route::post('admin/banner/showSort', 'Admin\BannerController@showSort')->name('bannerShowSorting');

    /* Live Shows */

    Route::get('admin/liveshow', 'Admin\LiveshowController@index')->name('liveShowListing');
    Route::post('admin/liveshow/stop/{id}', 'Admin\LiveshowController@stop')->name('makeShowLive');

    /* Players */

    Route::get('admin/players', 'Admin\PlayerController@index')->name('playersListing');
    Route::get('admin/players/add', 'Admin\PlayerController@add')->name('addPlayersAdd');
    Route::post('admin/players/add', 'Admin\PlayerController@add')->name('addPlayersAdd');
    Route::get('admin/players/edit/{id}', 'Admin\PlayerController@edit')->name('editPlayer');
    Route::get('admin/players/edit/{id}', 'Admin\PlayerController@edit')->name('editPlayer');
    Route::post('admin/players/edit/{id}', 'Admin\PlayerController@edit')->name('editPlayer');
    Route::delete('admin/players/delete/{id}', 'Admin\PlayerController@delete')->name('deletePlayer');

    /* Teams */

    Route::get('admin/teams', 'Admin\TeamController@index')->name('teamsListing');
    Route::get('admin/teams/add', 'Admin\TeamController@add')->name('addTeamsAdd');
    Route::post('admin/teams/add', 'Admin\TeamController@add')->name('addTeamsAdd');
    Route::get('admin/teams/edit/{id}', 'Admin\TeamController@edit')->name('editTeam');
    Route::get('admin/teams/edit/{id}', 'Admin\TeamController@edit')->name('editTeam');
    Route::post('admin/teams/edit/{id}', 'Admin\TeamController@edit')->name('editTeam');
    Route::delete('admin/teams/delete/{id}', 'Admin\TeamController@delete')->name('deleteTeam');


    Route::get('/unauthorized', function () {
        $data['page_title'] = 'unauthorized';
        return view('unauthorized', $data);
    })->name('unauthorized');
    Route::get('/comingSoon', function () {
        $data['page_title'] = 'comingSoon';
        return view('comingsoon', $data);
    })->name('comingSoon');
});

Route::get('reset_password/{token}', 'Admin\LoginController@reset_password')->name('reset_password');
Route::patch('reset_password_submit', 'Admin\LoginController@reset_password_submit')->name('reset_password_submit');
Route::get('invalid_link', 'Admin\LoginController@invalid_link')->name('invalid_link');
Route::get('page_not_found', 'Admin\LoginController@page_not_found')->name('page_not_found');
Route::get('password_success', 'Admin\LoginController@password_success')->name('password_success');
