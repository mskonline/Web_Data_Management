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

class Page3 extends Controller
{
    public function index(Request $request)
    {
		$validUser = false;
        $showSearchTable = false;
        $searchResults = null;
        $searchText = '';
        $username = $request->session()->get('username', null);
		
		if($username == null){
			return view('no_user_session');
		} else {
			
			if(isset($_POST['basketAction'])){
                $this->buyBasketItems($username);
            }

            $basketItems = $this->getBasketItems($username);

            $data['basketItems'] = $basketItems;
            $data['username'] = $username;
			
			return view('page3', $data);
		}
    }
	
	private function getBasketItems($username){
		
		$sql = 'SELECT * FROM (SELECT ISBN, title, price, publisher FROM book) AS bks JOIN (SELECT ISBN, number FROM contains WHERE basketID = (SELECT basketID FROM shoppingbasket WHERE username="'.$username.'")) bk_contains ON bks.ISBN = bk_contains.ISBN';

        $result = DB::select($sql);

        return $result;
	}
	
	private function buyBasketItems($username){
		$w_sql = 'SELECT basketID FROM shoppingbasket WHERE username = "'.$username.'"';

        $result = DB::select($w_sql);
        $row = $result[0];
        $basketID = $row->basketID;

        $w_sql = 'SELECT ISBN, number FROM contains WHERE basketID="'.$basketID.'"';
        $result = DB::select($w_sql);

        foreach ($result as $row){
            $isbn = $row->ISBN;
            $number = $row->number;

            // Update warehouse stock
            $w_sql = 'SELECT warehouseCode FROM stocks WHERE number = (SELECT MAX(number) FROM stocks WHERE ISBN = "'.$isbn.'")';
            $w_result = DB::select($w_sql);

            $w_row = $w_result[0];

            if($w_row->warehouseCode != ''){
                $warehouseCode = $w_row->warehouseCode;
                DB::update('UPDATE stocks SET number = number - '.$number.' WHERE  ISBN ="'.$isbn.'" AND warehouseCode='.$warehouseCode);
                DB::update('INSERT INTO shippingorder VALUES("'.$isbn.'", '.$warehouseCode.', "'.$username.'",'.$number.')');
            }
        }

        DB::delete('DELETE FROM contains WHERE basketID="'.$basketID.'"');
        DB::delete('DELETE FROM shoppingbasket WHERE username="'.$username.'"');
	}
}