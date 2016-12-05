<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table="customer";
	
	public function isValidCustomer($username, $password){
		$password = md5($password);
		
		$customer = $this->where('username', $username)
						->first();
        
        if($customer == null)
            return false;

        if($customer->password == $password){
            return true;
        } else {
            return false;
        }
	}
}
