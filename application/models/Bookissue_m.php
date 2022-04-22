<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bookissue_m extends MY_Model
{

    protected $_table_name  = 'bookissue';
    protected $_primary_key = 'bookissueID';
    protected $_order_by    = "bookissueID desc";

    public function __construct()
    {
        parent::__construct();
    }

    public function get_bookissue($array = null, $single = false)
    {
        return parent::get($array, $single);
    }

    public function get_order_by_bookissue($wherearray = null, $array = null, $single = false)
    {
        return parent::get_order_by($wherearray, $array, $single);
    }

    public function get_single_bookissue($wherearray = null, $array = null, $single = true)
    {
        return parent::get_single($wherearray, $array, $single);
    }

    public function insert_bookissue($array)
    {
        return parent::insert($array);
    }

    public function insert_bookissue_batch($array)
    {
        return parent::insert_batch($array);
    }

    public function update_bookissue($data, $id = null)
    {
        return parent::update($data, $id);
    }

    public function delete_bookissue($id)
    {
        return parent::delete($id);
    }

    public function get_where_in_bookissue($column, $whereinarray, $wherearray = null, $array = null)
    {
        return parent::get_where_in($column, $whereinarray, $wherearray, $array);
    }

    public function get_order_by_bookissue_for_report($array)
    {
        $this->db->select('*');
        $this->db->from($this->_table_name);
        if (isset($array['roleID'])) {
            $this->db->where('roleID', $array['roleID']);
            if (isset($array['memberID'])) {
                $this->db->where('memberID', $array['memberID']);
            }
        }
        if (isset($array['fromdate']) && isset($array['todate'])) {
            $this->db->where('issue_date >=', $array['fromdate']);
            $this->db->where('issue_date <=', $array['todate']);
        }
        $this->db->where('deleted_at', 0);
        $this->db->where('paidstatus !=', 2);
        return $this->db->get()->result();
    }

    public function get_order_by_bookissue_for_bookissuereport($array)
    {
        $this->db->select('*');
        $this->db->from($this->_table_name);
        if (isset($array['bookcategoryID'])) {
            $this->db->where('bookcategoryID', $array['bookcategoryID']);
            if (isset($array['bookID'])) {
                $this->db->where('bookID', $array['bookID']);
            }
        }
        if (isset($array['roleID'])) {
            $this->db->where('roleID', $array['roleID']);
            if (isset($array['memberID'])) {
                $this->db->where('memberID', $array['memberID']);
            }
        }
        if (isset($array['status'])) {
            $this->db->where('status', $array['status']);
        }
        if (isset($array['fromdate']) && isset($array['todate'])) {
            $this->db->where('issue_date >=', $array['fromdate']);
            $this->db->where('issue_date <=', $array['todate']);
        }
        $this->db->where('deleted_at', 0);
        return $this->db->get()->result();
    }
    public function test_bookissue($booktypeID,$memberID){
        $sql = "SELECT * FROM bookissue bi  inner join book bo on(bi.bookID = bo.bookID)  where bo.booktypeID = $booktypeID and bi.status = 0 and bi.deleted_at = 0 and bi.memberCode = '$memberID'";
        $query = $this->db->query( $sql );
        return  $query->num_rows();
    }
    // WACH MOKIN HAD item it3ta ba3da wla la
    public function test_bookitem($bookno,$bookID,$bookNovol){
        $sql = "select * from bookissue where bookno='$bookno' and bookID = '$bookID' and deleted_at=0 and booknovol='$bookNovol' and status = 0";
        $query = $this->db->query( $sql );
        return $query;
        if($query->num_rows()!=0)
          return false;
        return true;
        
    }
    // wach user khayd chi haja man had ktab
    public function test_bookitem_v1($bookID,$memberID){
        $sql = "select * from bookissue where  bookID = $bookID and deleted_at=0 and  status = 0  and memberCode = '$memberID'";
        $query = $this->db->query( $sql );
        if($query->num_rows()!=0)
          return false;
        return true;
    }
    // wach user khay
    // public function test_bookitem_v2($bookID,$bookno){
    //     $sql = "select * from bookissue where   bookno='$bookno' and bookID = $bookID and deleted_at=0 and  and status = 0";
    //     $query = $this->db->query( $sql );
    //     if($query->num_rows()!=0)
    //       return false;
    //     return true;
    // }

    // public function test_bookitem_v3($bookID,$bookno){
    //     $sql = "select * from bookissue where bookno='$bookno' and bookID = $bookID and deleted_at=0 and booknovol=$bookNovol and status = 0";
    //     $query = $this->db->query( $sql );
    //     if($query->num_rows()!=0)
    //       return false;
    //     return true;
    // }




}
