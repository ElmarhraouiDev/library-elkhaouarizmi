<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booktype_m extends MY_Model
{

    protected $_table_name  = 'booktype';
    protected $_primary_key = 'booktypeID';
    protected $_order_by    = "booktypeID desc";

    public function __construct()
    {
        parent::__construct();
    }

    public function get_booktype($array = null, $single = false)
    {
        return parent::get($array, $single);
    }

    public function get_order_by_booktype($wherearray = null, $array = null, $single = false)
    {
        return parent::get_order_by($wherearray, $array, $single);
    }

    public function get_single_booktype($wherearray = null, $array = null, $single = true)
    {
        return parent::get_single($wherearray, $array, $single);
    }

    public function insert_booktype($array)
    {
        return parent::insert($array);
    }

    public function update_booktype($data, $id = null)
    {
        return parent::update($data, $id);
    }

    public function delete_booktype($id)
    {
        return parent::delete($id);
    }

    public function get_where_in_booktype($column, $whereinarray, $wherearray = null, $array = null)
    {
        return parent::get_where_in($column, $whereinarray, $wherearray, $array);
    }

}
