<?php
use Illuminate\Database\Seeder;
class GroupSeeder extends Seeder {

    public function run()
    {
    	$groups = array(
    		            array(
                            array('name' => 'System Administrator', 'description' => 'Full Admin Access'),
                            array(array('route_class' => '*', 'route_function' => '', 'route_access'=> 1)),
                            array(array('model_name' => '*', 'read' => 1, 'create' => 1, 'update' => 1, 'delete' => 1, 'identifiable' => 1)),
                        ),
                        array(
                            array('name' => 'Doctor', 'description' => 'Doctors Group'),
                            array(
                                array('route_class' => '*', 'route_function' => '', 'route_access' => 1),
                                array('route_class' => 'LogsController@getIndex', 'route_function' => '', 'route_access' => 0),
                                array('route_class' => 'CurrentUsersController@currentUsersIndex', 'route_function' => '', 'route_access' => 0),
                                array('route_class' => 'UserAdminController@getIndex', 'route_function' => '', 'route_access' => 0),
                                array('route_class' => 'GroupAdminController@getIndex', 'route_function' => '', 'route_access' => 0),
                                array('route_class' => 'EncountersController@getIndex', 'route_function' => '', 'route_access' => 0),
                                array('route_class' => 'ReportsController@getIndex', 'route_function' => '', 'route_access' => 0),
                                array('route_class' => 'DataController@getIndex', 'route_function' => '', 'route_access' => 0)
                            
                            ),
                            array(
                                array('model_name' => '*', 'read' => 1, 'create' => 1, 'update' => 1, 'delete' => 1, 'identifiable' => 1),

                                //read only perms
                                array('model_name' => 'DrugName', 'read' => 1, 'create' => 1),
                                array('model_name' => 'AvailableSuggestion', 'read' => 1, 'create' => 1),
                                array('model_name' => 'PermissionGroup', 'read' => 1),
                                array('model_name' => 'GroupModelPermission', 'read' => 1),
                                array('model_name' => 'GroupRoutePermission', 'read' => 1),
                                array('model_name' => 'CommunityServiceType', 'read' => 1),
                                array('model_name' => 'ResearchTrial', 'read' => 1),
                                array('model_name' => 'Clinic', 'read' => 1),
                                array('model_name' => 'News', 'read' => 1),
                                array('model_name' => 'User', 'read' => 1),


                                //tmp - make sure only can be updated if related EncounterTemplate has is_patient == 1
                                array('model_name' => 'EncounterTemplate', 'read' => 1, 'create' => 1, 'update' => 1, 'delete' => 1, 'identifiable' => 1),
                                array('model_name' => 'EncounterView', 'read' => 1, 'create' => 1, 'update' => 1, 'delete' => 1, 'identifiable' => 1),
                                array('model_name' => 'EncounterViewset', 'read' => 1, 'create' => 1, 'update' => 1, 'delete' => 1, 'identifiable' => 1),
                                array('model_name' => 'ViewsetForm', 'read' => 1, 'create' => 1, 'update' => 1, 'delete' => 1, 'identifiable' => 1),


                                array('model_name' => 'LogEntry', 'create' => 1),
                                
                                array('model_name' => 'Doctor', 'read' => 1, 'create' => 1),
                                array('model_name' => 'GaitAid', 'read' => 1),


                                ),
                        ),
                        array(
                            array('name' => 'Research Registry', 'description' => 'Basic Research Access'),
                            array(
                                array('route_class' => '*', 'route_function' => '', 'route_access'=> 1),
                                array('route_class' => 'PatientsController@getRegistration', 'route_function' => '', 'route_access'=> 0),
                                array('route_class' => 'PatientsReportsController@getIndex', 'route_function' => '', 'route_access'=> 0),
                                array('route_class' => 'PatientsFilesController@getManage', 'route_function' => '', 'route_access'=> 0),
                                array('route_class' => 'PatientsResearchTrialsController@getIndex', 'route_function' => '', 'route_access'=> 0),
                                array('route_class' => 'PatientReferralsController@getIndex', 'route_function' => '', 'route_access'=> 0),
                                array('route_class' => 'PatientsCommunityServicesController@getIndex', 'route_function' => '', 'route_access'=> 0),
                                array('route_class' => 'LogsController@getIndex', 'route_function' => '', 'route_access' => 0),
                                array('route_class' => 'CurrentUsersController@currentUsersIndex', 'route_function' => '', 'route_access' => 0),
                                array('route_class' => 'UserAdminController@getIndex', 'route_function' => '', 'route_access' => 0),
                                array('route_class' => 'GroupAdminController@getIndex', 'route_function' => '', 'route_access' => 0),
                                array('route_class' => 'EncountersController@getIndex', 'route_function' => '', 'route_access' => 0),
                                array('route_class' => 'ReportsController@getIndex', 'route_function' => '', 'route_access' => 0),
                                ),
                            array(
                                array('model_name' => '*', 'read' => 1, 'create' => 0, 'update' => 0, 'delete' => 0, 'identifiable' => 0),
                                array('model_name' => 'LogEntry', 'create' => 1),
                                ),
                        ),
		);

        foreach($groups as $info) {
        	$group = new App\PermissionGroup($info[0]);
            $group->save();
            foreach($info[1] as $route_perms) {
                $g_perms = new App\GroupRoutePermission($route_perms);
                $g_perms->group_id = $group->id;
                $g_perms->save();
            }
            foreach($info[2] as $model_perms) {
                $m_perms = new App\GroupModelPermission($model_perms);
                $m_perms->group_id = $group->id;
                $m_perms->save();
            }
        }
    }

}