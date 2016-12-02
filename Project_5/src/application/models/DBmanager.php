<!--
  Student Name:  Manakan, Sai Kumar
  ID: 1001236131
  Email: saikumar.manakan@mavs.uta.edu
  Project Name: PHP Scripting with Relational Database with CodeIgniter
  Due date: Dec 5 2016
-->
<?php

class Dbmanager extends CI_MODEL {

    public function __construct() {

        $this->load->database();
        $this->load->helper('date');
    }

    public function checkUser($username, $password){
        $db = $this->db;

        $password = md5($password);
        $sql = 'SELECT password FROM customer WHERE username = ?';
        $result = $db->query($sql, array($username));

        $row = $result->row();

        if($row->password == $password){
            return true;
        } else {
            return false;
        }
    }   

    public function getBasketItemsCount($username){
        $db = $this->db;

        $sql = "SELECT COUNT(ISBN) bCount FROM  contains WHERE basketID = (SELECT basketID FROM shoppingbasket WHERE username='".$username."')";

        $query = $db->query($sql);
        $row = $query->row();

        return $row->bCount;
    }

    public function execBookSearch($searchText, $searchBy){
        $db = $this->db;
        $isbns = '';

        $searchTextQStr = '%'.$searchText.'%';

        if($searchBy == 'title'){
            $sql = "SELECT ISBN FROM book WHERE title LIKE ?";
        } else {
            $sql = "SELECT ISBN FROM book WHERE ISBN IN (SELECT ISBN FROM writtenby WHERE ssn = (SELECT ssn FROM author WHERE name LIKE ?))"; 
        }

        $query = $db->query($sql, array($searchTextQStr));

        $isFirst = true;

        foreach ($query->result() as $row)
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

        $query = $db->query($sql);

        return $query;
    }

    public function addBookToBasket($username, $isbn){
        $db = $this->db;
        $basketID = '';

        $b_sql = 'SELECT basketID FROM shoppingbasket WHERE username = "'.$username.'"';

        $query = $db->query($b_sql);
        
        if($query->num_rows() == 1){
            $row = $query->row();
            $basketID = $row->basketID;
        }
        

        if($basketID == ''){
            $uniqueBasketID = uniqid();
            $data = array(
                    'basketID' => $uniqueBasketID,
                    'username' => $username
                    );

            $db->insert('shoppingbasket', $data);

            $data = array(
                    'basketID' => $uniqueBasketID,
                    'ISBN' => $isbn,
                    'number'=>1
                    );
            
            $db->insert('contains', $data);
        } else {
            $b_sql = 'UPDATE contains SET number = number + 1 WHERE basketID = "'.$basketID.'" AND ISBN = "'.$isbn.'"';

            $query = $db->query($b_sql);

            if($db->affected_rows() == 0){
                $data = array(
                    'basketID' => $basketID,
                    'ISBN' => $isbn,
                    'number'=>1
                    );
            
                $db->insert('contains', $data);
            }
        }
    }

    public function buyBasketItems($username){
        $db = $this->db;

        $w_sql = 'SELECT basketID FROM shoppingbasket WHERE username = "'.$username.'"';

        $query = $db->query($w_sql);
        $row = $query->row();
        $basketID = $row->basketID;

        $w_sql = 'SELECT ISBN, number FROM contains WHERE basketID="'.$basketID.'"';
        $query = $db->query($w_sql);


        foreach ($query->result() as $row){
            $isbn = $row->ISBN;
            $number = $row->number;

            // Update warehouse stock
            $w_sql = 'SELECT warehouseCode FROM stocks WHERE number = (SELECT MAX(number) FROM stocks WHERE ISBN = "'.$isbn.'")';
            $query = $db->query($w_sql);

            $w_row = $query->row();

            if($w_row->warehouseCode != ''){
                $warehouseCode = $w_row->warehouseCode;
                $db->query('UPDATE stocks SET number = number - '.$number.' WHERE  ISBN ="'.$isbn.'" AND warehouseCode='.$warehouseCode);
                $db->query('INSERT INTO shippingorder VALUES("'.$isbn.'", '.$warehouseCode.', "'.$username.'",'.$number.')');
            }
        }

        $db->query('DELETE FROM contains WHERE basketID="'.$basketID.'"');
        $db->query('DELETE FROM shoppingbasket WHERE username="'.$username.'"');
    }

    public function getBasketItems($username){
        $db = $this->db;

        $sql = 'SELECT * FROM (SELECT ISBN, title, price, publisher FROM book) AS bks JOIN (SELECT ISBN, number FROM contains WHERE basketID = (SELECT basketID FROM shoppingbasket WHERE username="'.$username.'")) bk_contains ON bks.ISBN = bk_contains.ISBN';

        $query = $db->query($sql);

        return $query;
    }

    public function saveUser($username, $email, $addr, $phone, $password){
        $db = $this->db;

        $data = array(
                    'username' => $username,
                    'email' => $email,
                    'address' => $addr,
                    'phone' => $phone,
                    'password' => md5($password)
                    );
            
        return $db->insert('customer', $data);
    }
}
?>
