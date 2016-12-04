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

class Page2 extends Controller
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
			$validUser = true;
            $data = array();
            $searchText = '';

			// Search
            if(isset($_POST['searchBy']) && $_POST['searchBy'] != '') {
                $searchText = $_POST['searchText'];
                $searchResults = $this->execBookSearch($searchText, $_POST['searchBy']);

                if($searchResults != null && count($searchResults) > 0)
                    $showSearchTable = true;
            } else if(isset($_POST['addToBasket']) && $_POST['addToBasket'] != ''){
                // Add to Basket
                $isbn = $_POST['addToBasket'];

                $this->addBookToBasket($username, $isbn);
            }

            $basketCount = $this->getBasketItemsCount($username);

            $data['searchResults'] = $searchResults;
            $data['showSearchTable'] = $showSearchTable;
            $data['searchText'] = $searchText;
            $data['validUser'] = $validUser;
            $data['username'] = $username;
            $data['basketCount'] = $basketCount;
			
			return view('page2', $data);
		}
    }
	
	private function execBookSearch($searchText, $searchBy){
		$isbns = '';

        $searchTextQStr = '%'.$searchText.'%';

        if($searchBy == 'title'){
            $sql = "SELECT ISBN FROM book WHERE title LIKE ?";
        } else {
            $sql = "SELECT ISBN FROM book WHERE ISBN IN (SELECT ISBN FROM writtenby WHERE ssn = (SELECT ssn FROM author WHERE name LIKE ?))"; 
        }

        $result = DB::select($sql, array($searchTextQStr));

        $isFirst = true;

        foreach ($result as $row)
        {
            if(!$isFirst){
              $isbns = $isbns.",";
            } else {
              $isFirst = false;
            }
            
            $isbns = $isbns."'".$row->ISBN."'";
        }

        if($isbns == '')
            return null;

        $sql = 'SELECT bk.title, bkstocks.ISBN, bkstocks.stock FROM (SELECT stks.ISBN, SUM(stks.number) as stock FROM stocks stks WHERE stks.ISBN IN ('.$isbns.') AND stks.number > 0 GROUP BY stks.ISBN) bkstocks, book bk WHERE bkstocks.ISBN = bk.ISBN';

        $result = DB::select($sql);

        return $result;
	}
	
	private function getBasketItemsCount($username){
		
		$sql = "SELECT COUNT(ISBN) bCount FROM  contains WHERE basketID = (SELECT basketID FROM shoppingbasket WHERE username='".$username."')";

        $result = DB::select($sql);
        $row = $result[0];

        return $row->bCount;
	}
	
	private function addBookToBasket($username, $isbn){
		$basketID = '';

        $b_sql = 'SELECT basketID FROM shoppingbasket WHERE username = "'.$username.'"';

        $result = DB::select($b_sql);
        
        if(count($result) == 1){
            $row = $result[0];
            $basketID = $row->basketID;
        }
        
        if($basketID == ''){
            $uniqueBasketID = uniqid();
            $data = array(
                    'basketID' => $uniqueBasketID,
                    'username' => $username
                    );

            DB::table('shoppingbasket')->insert($data);

            $data = array(
                    'basketID' => $uniqueBasketID,
                    'ISBN' => $isbn,
                    'number'=>1
                    );
            
            DB::table('contains')->insert($data);
        } else {
			$affected = DB::table('contains')
							->where([
								['basketID', '=', $basketID],
								['ISBN', '=', $isbn]
							])
							->increment('number');

            if($affected == 0){
                $data = array(
                    'basketID' => $basketID,
                    'ISBN' => $isbn,
                    'number'=>1
                    );
            
                $db->insert('contains', $data);
            }
        }
	}
}