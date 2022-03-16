<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Classe_m extends MY_Model
{

    protected $_table_name  = 'classe';
    protected $_primary_key = 'classeID';
    protected $_order_by    = "classeID asc";

    public function __construct()
    {
        parent::__construct();
    }

    public function get_classe($array = null, $single = false)
    {
        return parent::get($array, $single);
    }

    public function get_order_by_classe($wherearray = null, $array = null, $single = false)
    {
        return parent::get_order_by($wherearray, $array, $single);
    }

    public function get_single_classe($wherearray = null, $array = null, $single = true)
    {
        return parent::get_single($wherearray, $array, $single);
    }

    public function insert_classe($array)
    {
        return parent::insert($array);
    }

    public function update_classe($data, $id = null)
    {
        return parent::update($data, $id);
    }

    public function delete_classe($id)
    {
        return parent::delete($id);
    }

}
