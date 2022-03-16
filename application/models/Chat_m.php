<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chat_m extends MY_Model
{

    protected $_table_name  = 'chat';
    protected $_primary_key = 'chatID';
    protected $_order_by    = "chatID asc";

    public function __construct()
    {
        parent::__construct();
    }

    public function get_chat($array = null, $single = false)
    {
        return parent::get($array, $single);
    }

    public function get_order_by_chat($wherearray = null, $array = null, $single = false)
    {
        return parent::get_order_by($wherearray, $array, $single);
    }

    public function get_chat_by_limit($limit1, $limit2 = null)
    {
        return parent::get_order_by_limit($limit1, $limit2);
    }

    public function get_single_chat($wherearray = null, $array = null, $single = true)
    {
        return parent::get_single($wherearray, $array, $single);
    }

    public function insert_chat($array)
    {
        return parent::insert($array);
    }

    public function update_chat($data, $id = null)
    {
        return parent::update($data, $id);
    }

    public function delete_chat($id)
    {
        return parent::delete($id);
    }

}
