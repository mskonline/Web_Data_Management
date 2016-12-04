<?php
namespace App\Http\Controllers;

/*
  Student Name:  Manakan, Sai Kumar
  ID: 1001236131
  Email: saikumar.manakan@mavs.uta.edu
  Project Name: PHP Scripting with Relational Database with Laravel
  Due date: Dec 5 2016
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Page4 extends Controller
{
    public function index(Request $request)
    {
        $userSaved = false;
        $data = array();

        if(isset($_POST['usrname'])){

            $username = $_POST['usrname'];
            $email = $_POST['email'];
            $addr = $_POST['addr'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];

            $userSaved = $this->saveUser($username, $email, $addr, $phone, $password);
        }

        $data['userSaved'] = $userSaved;
        return view('page4', $data);
    }
	
	private function saveUser($username, $email, $addr, $phone, $password)
	{
		$data = array(
                    'username' => $username,
                    'email' => $email,
                    'address' => $addr,
                    'phone' => $phone,
                    'password' => md5($password)
                    );
            
        return DB::table('customer')->insert($data);
	}
}