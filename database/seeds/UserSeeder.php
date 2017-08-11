<?php
use Illuminate\Database\Seeder;
class UserSeeder extends Seeder {

    public function run()
    {
        if(Config::get('auth.driver') == 'lhsso') {
            $users = array(
                     array('username' => 'lindsayj', 'first_name' => 'Joe','last_name' => 'Lindsay', 'email' => 'Joseph.Lindsay@sjhc.london.on.ca', 'password' => 'root', 'title' => 'Root User', 'actions' => 'Manager', 'position' => 'System Admin', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'lawsonk', 'first_name' => 'Keith','last_name' => 'Lawson', 'email' => 'Keith.Lawson@sjhc.london.on.ca', 'password' => 'root', 'title' => 'Root User', 'actions' => 'Manager', 'position' => 'System Admin', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'borriem', 'first_name' => 'Michael','last_name' => 'Borrie', 'email' => 'Michael.Borrie@sjhc.london.on.ca', 'password' => 'root', 'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'sargeanp','title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'manne', 'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'bests', 'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'SJ99434E',  'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'colemakr', 'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'truemnej', 'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'woolgoos', 'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'mccallju', 'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'jenniew',  'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'carrolsu',  'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'leblansi',  'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'mccarthe',  'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'mowatj',  'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'mcdonche',  'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'FOGARTYJ',  'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),

            );
        } else {
            $users = array(
                     array('username' => 'root', 'email' => 'root@root.com', 'password' => 'root', 'title' => 'Root User', 'actions' => 'root', 'group_name' => 'System Administrator','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'doctor', 'first_name' => 'The','last_name' => 'Doctor', 'email' => 'doctor@doctor.com', 'password' => 'doctor', 'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'Doctor','api_key' => sha1(mt_rand(1000,1000000000))),
                     array('username' => 'Research', 'first_name' => 'The','last_name' => 'Researcher', 'email' => 'doctor@doctor.com', 'password' => 'research', 'title' => 'Doctor', 'actions' => 'Geriatrician', 'position' => 'Doctor', 'group_name' => 'Research Registry','api_key' => sha1(mt_rand(1000,1000000000)))
            );
        }

        foreach($users as $user) {
            $group_name = $user['group_name'];
            unset($user['group_name']);
            $u = new App\User($user);

        if(Config::get('auth.driver') != 'lhsso') {
            $u->password = $user['password']; //password isn't fillable
        }
            $group = App\PermissionGroup::where('name','=',$group_name)->get()->first();
                $u->group_id = $group->id;
                $u->save();
        }
    }

}
