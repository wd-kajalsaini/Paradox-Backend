<?php

use App\Permissions;
use App\Sections;
use Illuminate\Database\Seeder;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $sections = array(
            array('id' => '1','name' => 'Dashboard','parent_id' => 'main','sort_order' => '1','route' => 'dashboard','icon' => 'fa fa-dashboard','show_on_sidebar' => 'yes','english' => 'Dashboard','created_at' => '2019-12-28 21:45:18','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '2','name' => 'App Settings','parent_id' => 'main','sort_order' => '2','route' => NULL,'icon' => 'glyphicon glyphicon-equalizer','show_on_sidebar' => 'yes','english' => 'App Settings','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '3','name' => 'Content Management','parent_id' => '2','sort_order' => '0','route' => 'contentManagementListing','icon' => 'glyphicon glyphicon-cog','show_on_sidebar' => 'yes','english' => 'Content Management','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '4','name' => 'Push Notification','parent_id' => 'main','sort_order' => '3','route' => 'pushNotificationListing','icon' => 'glyphicon glyphicon-envelope','show_on_sidebar' => 'yes','english' => 'Push Notification','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '5','name' => 'Add','parent_id' => '4','sort_order' => '0','route' => 'sendPushNotificationAdd','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Add','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '6','name' => 'Resend','parent_id' => '4','sort_order' => '1','route' => 'resend','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Resend','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '7','name' => 'Shows','parent_id' => 'main','sort_order' => '4','route' => 'showsListing','icon' => 'fa fa-video','show_on_sidebar' => 'yes','english' => 'Shows','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '8','name' => 'Add','parent_id' => '7','sort_order' => '0','route' => 'addShowAdd','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Add','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '9','name' => 'Edit','parent_id' => '7','sort_order' => '1','route' => 'editShow','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Edit','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '10','name' => 'Show Questions','parent_id' => '7','sort_order' => '2','route' => 'showQuestions','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Show Questions','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '11','name' => 'Subscribed Show','parent_id' => '7','sort_order' => '3','route' => 'subscribedShowUsers','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Subscribed Show','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '12','name' => 'Delete','parent_id' => '7','sort_order' => '4','route' => 'deleteShow','icon' => NULL,'show_on_sidebar' => 'no','english' => 'delete','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '13','name' => 'Show Live','parent_id' => '7','sort_order' => '5','route' => 'makeShowLive','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Show Live','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '14','name' => 'Validate team players','parent_id' => '7','sort_order' => '6','route' => 'validateTeamPlayers','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Validate team players','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '15','name' => 'Add','parent_id' => '7','sort_order' => '3','route' => 'showQuestionAdd','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Add','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '16','name' => 'Edit','parent_id' => '7','sort_order' => '4','route' => 'showQuestionEdit','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Edit','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '17','name' => 'Subscriber notification','parent_id' => '7','sort_order' => '5','route' => 'subscriber_notification','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Subscriber notification','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '18','name' => 'Delete','parent_id' => '7','sort_order' => '6','route' => 'showQuestionDelete','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Delete','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '19','name' => 'System','parent_id' => 'Main','sort_order' => '5','route' => '','icon' => 'fa fa-store','show_on_sidebar' => 'yes','english' => 'System','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '20','name' => 'Managers','parent_id' => '19','sort_order' => '0','route' => 'managersListing','icon' => NULL,'show_on_sidebar' => 'yes','english' => 'Managers','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '21','name' => 'System Sections','parent_id' => '19','sort_order' => '1','route' => 'sectionsListing','icon' => NULL,'show_on_sidebar' => 'yes','english' => 'System Sections','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '22','name' => 'Add manager','parent_id' => '20','sort_order' => '0','route' => 'addManagerAdd','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Add manager','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '23','name' => 'Edit Emanager','parent_id' => '20','sort_order' => '1','route' => 'editManager','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Edit Manager','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '24','name' => 'Add manager Type','parent_id' => '20','sort_order' => '2','route' => 'addManagerTypeAdd','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Add manager Type','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '25','name' => 'Edit Manager type','parent_id' => '20','sort_order' => '3','route' => 'editManagerType','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Edit Manager type','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '26','name' => 'Delete Manager type','parent_id' => '20','sort_order' => '4','route' => 'deleteManagerType','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Delete Manager type','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '27','name' => 'Add section','parent_id' => '21','sort_order' => '0','route' => 'addSection','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Add section','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '28','name' => 'Edit Section','parent_id' => '21','sort_order' => '0','route' => 'editSection','icon' => NULL,'show_on_sidebar' => 'no','english' => 'Edit Section','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL),
            array('id' => '29','name' => 'ReOrder Section','parent_id' => '21','sort_order' => '0','route' => 'reOrder','icon' => NULL,'show_on_sidebar' => 'no','english' => 'ReOrder Section','created_at' => '2019-12-29 09:01:59','updated_at' => '2021-07-14 15:22:21','created_by' => NULL,'updated_by' => NULL)
        );

            foreach ($sections as $section) {
                $matchThese=['id' => $section['id']];
                Sections::updateOrCreate($matchThese,$section);
            }
    }
}
