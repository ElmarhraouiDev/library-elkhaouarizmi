<?php

use Mpdf\Tag\Option;

defined('BASEPATH') or exit('No direct script access allowed');

class Bookbarcodereport extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('book_m');
        $this->load->model('bookitem_m');
        $this->load->model('bookcategory_m');
        $this->load->model('booktype_m');
        $this->load->model('rack_m');
        $this->load->library('barcode');
        $this->load->library('pdf');

        $lang = $this->session->userdata('language');
        $this->lang->load('bookbarcodereport', $lang);
    }

    public function index()
    {
        $this->data['headerassets'] = array(
            'css'      => array(
                'assets/custom/css/fastselect.min.css',
            ),
            'headerjs' => array(
                'assets/custom/js/fastselect.standalone.js',
            ),
            'js' => array(
                'assets/custom/js/bookbarcodereport.js',
            ),
        );

        $this->data['flag']           = 0;
        $this->data['bookcategoryID'] = 0;
        $this->data['bookID']         = 0;

        $this->data['books']         = [];
        $this->data['booktypes']     = $this->booktype_m->get_booktype();
        $this->data['bookcategorys'] = pluck($this->bookcategory_m->get_bookcategory(), 'obj', 'bookcategoryID');
        $this->data['bookcategory_all'] = $this->bookcategory_m->get_bookcategory_orderby(null, 'level_in_catagory asc');
        unset($_SESSION['error']);

        if ($_POST && isset($_POST['print_pdf'])) {
            $bookcategoryID     = $this->input->post('bookcategoryID') ? $this->input->post('bookcategoryID') : [];
            $booktypeID         = $this->input->post('booktypeID') ? $this->input->post('booktypeID') : null;
            $bookID             = $this->input->post('bookID') ? $this->input->post('bookID') : null;

            $options[0]         = $this->input->post('ck_name');
            $options[1]         = $this->input->post('ck_type');
            $options[2]         = $this->input->post('ck_author');
            $options[3]         = $this->input->post('ck_catagory');
            $options[4]         = $this->input->post('ck_rack');
            $options[5]         = $this->input->post('ck_isbn');
            
            $array['status']         = 0;
            $array['deleted_at']     = 0;

            if ((int) $bookcategoryID || (int) $bookID || (int) $booktypeID) {
                // $this->data['books'] = $this->book_m->get_order_by_book($array, array('bookID', 'name', 'codeno'));
                $this->data['books'] = $this->book_m->get_like_in_book('bookcategoryID',$bookcategoryID,'bookID',$bookID, $array, array('bookID', 'name', 'codeno'));
            }

            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $message = implode('<br/>', $this->form_validation->error_array());
                $this->session->set_flashdata('error', $message);
                $this->data["subview"] = "report/bookbarcode/index";
            } else {

                if (((int) $bookcategoryID || $bookcategoryID == 0) && ((int) $bookID || $bookID == 0)) {

                    $this->_queryArray(['bookcategoryID' => $bookcategoryID, 'bookID' => $bookID, 'booktypeID' => $booktypeID, 'options' => $options]);
        
                    $this->pdf->create(['stylesheet' => 'bookbarcodereport.css', 'view' => 'report/bookbarcode/pdf.php', 'data' => $this->data]);
                } else {
                    $this->data["subview"] = "_not_found";
                    $this->load->view('_main_layout', $this->data);
                }

            }
            return;
        }

        if ($_POST) {

            $bookcategoryID     = $this->input->post('bookcategoryID') ? $this->input->post('bookcategoryID') : [];
            $booktypeID         = $this->input->post('booktypeID') ? $this->input->post('booktypeID') : null;
            $bookID             = $this->input->post('bookID') ? $this->input->post('bookID') : null;

            $options[0]         = $this->input->post('ck_name');
            $options[1]         = $this->input->post('ck_type');
            $options[2]         = $this->input->post('ck_author');
            $options[3]         = $this->input->post('ck_catagory');
            $options[4]         = $this->input->post('ck_rack');
            $options[5]         = $this->input->post('ck_isbn');

            $array['status']         = 0;
            $array['deleted_at']     = 0;
            // $array['bookcategoryID'] = $bookcategoryID;
            if ((int) $bookcategoryID || (int) $bookID || (int) $booktypeID) {
                // $this->data['books'] = $this->book_m->get_order_by_book($array, array('bookID', 'name', 'codeno'));
                $this->data['books'] = $this->book_m->get_like_in_book('bookcategoryID',$bookcategoryID,'bookID',$bookID, $array, array('bookID', 'name', 'codeno'));
            }


            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $message = implode('<br/>', $this->form_validation->error_array());
                $this->session->set_flashdata('error', $message);
                $this->data["subview"] = "report/bookbarcode/index";
            } else {

                $this->_queryArray(['bookcategoryID' => $bookcategoryID, 'bookID' => $bookID, 'booktypeID' => $booktypeID, 'options' => $options]);

                $this->data["subview"] = "report/bookbarcode/index";
            }
        } else {
            $this->data["subview"] = "report/bookbarcode/index";
        }
        $this->load->view('_main_layout', $this->data);
    }

    // public function pdf()
    // {
    //     $bookcategoryID = htmlentities(escapeString($this->uri->segment(3)));
    //     $bookID         = htmlentities(escapeString($this->uri->segment(4)));

    //     if (((int) $bookcategoryID || $bookcategoryID == 0) && ((int) $bookID || $bookID == 0)) {

    //         $this->_queryArray(['bookcategoryID' => $bookcategoryID, 'bookID' => $bookID, 'booktypeID' => $booktypeID]);

    //         $this->pdf->create(['stylesheet' => 'bookbarcodereport.css', 'view' => 'report/bookbarcode/pdf.php', 'data' => $this->data]);
    //     } else {
    //         $this->data["subview"] = "_not_found";
    //         $this->load->view('_main_layout', $this->data);
    //     }
    // }

    private function _queryArray($queryArr)
    {
        extract($queryArr);

        $queryArray = [];
        $queryArray['status !=']  = 2;
        $queryArray['deleted_at'] = 0;
        $arraybookIDs = array();

        $arrayBookcategoryID = $bookcategoryID;
        $arrayBookcategoryID = empty($bookcategoryID) ? [] : array_map(function($value) { return ','.$value.','; }, $arrayBookcategoryID);
        
        if (empty($bookID) && $bookcategoryID == null && $booktypeID == null) {
            $bookitems = $this->bookitem_m->get_order_by_bookitem($queryArray);
        } else
        if (empty($bookID)) {
            if ((int) $bookcategoryID || (int) $booktypeID) {
                $books = $this->book_m->get_like_in_book('bookcategoryID',$arrayBookcategoryID,'booktypeID',$booktypeID, $queryArray, array('bookID', 'name', 'codeno'));
                if (calculate($books)) {
                    foreach ($books as $book) {
                        array_push($arraybookIDs, $book->bookID);
                    }
                }
            }
            if (empty($arraybookIDs)) {
                array_push($arraybookIDs, '');
            }
            $bookitems = $this->bookitem_m->get_where_in_bookitem('bookID',$arraybookIDs, $queryArray);
        } else {
            $bookitems = $this->bookitem_m->get_where_in_bookitem('bookID',$bookID, $queryArray);
        }
        
        // print_r($bookitems);
        // exit;
        
        $this->generatebarcode($bookitems);

        // print_r($bookitems);
        // return;
        $this->data['flag']           = 1;
        $this->data['bookcategoryID'] = $bookcategoryID;
        $this->data['bookID']         = $bookID;
        $this->data['options']        = $options;
        $this->data['bookitems']      = $bookitems;
    }

    public function get_book()
    {
        echo "<option value='0'>" . $this->lang->line('bookbarcodereport_please_select') . "</option>";
        if ($_POST && permissionChecker('bookbarcodereport')) {
            $bookcategoryID          = $this->input->post('bookcategoryID');
            $booktypeID              = $this->input->post('booktypeID');
            $array['status']         = 0;
            $array['deleted_at']     = 0;
            // $array['bookcategoryID'] = $bookcategoryID;

            $arrayBookcategoryID = $bookcategoryID;
            $arrayBookcategoryID = empty($bookcategoryID) ? [] : array_map(function($value) { return ','.$value.','; }, $arrayBookcategoryID);

            if ((int) $bookcategoryID || (int) $booktypeID) {
                $books = $this->book_m->get_like_in_book('bookcategoryID',$arrayBookcategoryID,'booktypeID',$booktypeID, $array, array('bookID', 'name', 'codeno'));
                if (calculate($books)) {
                    foreach ($books as $book) {
                        echo "<option value='" . $book->bookID . "'>" . $book->name . ' - ' . $book->codeno . "</option>";
                    }
                }
            }
        }
    }

    private function rules()
    {
        $rules = array(
            array(
                'field' => 'bookcategoryID',
                'label' => $this->lang->line('bookbarcodereport_book_category'),
                'rules' => 'trim|xss_clean',
            ),
            array(
                'field' => 'bookID',
                'label' => $this->lang->line('bookbarcodereport_book'),
                'rules' => 'trim|xss_clean',
            ),
        );
        return $rules;
    }

    private function generatebarcode($bookitems)
    {        
        if (calculate($bookitems)) {
            foreach ($bookitems as $bookitem) {
                $book      = $this->book_m->get_single_book(['bookID' => $bookitem->bookID]);
                if(!calculate($book)) {
                    continue;
                }
                $bookitembarcode = $book->codeno.'-'.$bookitem->bookno.'-'.$bookitem->booknovol.'/'.$book->volume;
                $bookitembarcode_img = $book->codeno.'-'.$bookitem->bookno.'-'.$bookitem->booknovol;
                $this->barcode->generate($bookitembarcode, $bookitembarcode_img, 'uploads/bookbarcode/');
            }
        }
    }

}
