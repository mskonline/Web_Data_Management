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

use App\Customers;
use App\Http\Controllers\Controller;

class Page1 extends Controller
{
    public function index(Request $request)
    {
		$data = array('errorMessage'=>'');
        $validUser = false;

		if(isset($_POST['username'])){
			$username = $_POST['username'];
            $password = $_POST['password'];
			
			$customers = new Customers();
            $validUser = $customers->isValidCustomer($username, $password);

            if($validUser == true){
				$request->session()->put('username', $username);
				return redirect('/page2');
            } else {
                $data['errorMessage'] = 'Invalid User name or Password';
                return view('page1', $data);
            }
        } else {
			$request->session()->forget('username');
			$data['validUser'] = $validUser;
			return view('page1', $data);
		}
    }   
}