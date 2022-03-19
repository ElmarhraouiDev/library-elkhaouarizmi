<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Book extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('book_m');
        $this->load->model('bookitem_m');
        $this->load->model('rack_m');
        $this->load->model('booktype_m');
        $this->load->model('bookcategory_m');
        $this->load->model('bookissue_m');
        $lang = $this->session->userdata('language');
        $this->lang->load('book', $lang);
    }

    public function index()
    {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css',
                'assets/custom/css/hidetable.css',
            ),
            'js'  => array(
                'assets/plugins/datatables.net/js/jquery.dataTables.min.js',
                'assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js',
            ),
        );
        $this->data['books']   = $this->book_m->get_order_by_book(['deleted_at' => 0]);
        $this->data["subview"] = "book/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function add()
    {
        $this->data['headerassets'] = array(
            'css'      => array(
                'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
                'assets/custom/css/fastselect.min.css',
            ),
            'headerjs' => array(
                'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
                'assets/custom/js/fastselect.standalone.js',
            ),
            'js'       => array(
                'assets/custom/js/fileupload.js',
            ),
        );
        $this->data['booktypes']     = $this->booktype_m->get_booktype();
        $this->data['racks']         = $this->rack_m->get_rack();
        $this->data['bookcategorys'] = $this->bookcategory_m->get_order_by_bookcategory_orderby(array('status' => 1), null, 'level_in_catagory asc');
        if ($_POST) {

            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "book/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                    = [];
                $array['name']            = $this->input->post('name');
                $array['booktypeID']      = $this->input->post('booktypeID');
                $array['author']          = $this->input->post('author');
                $array['bookcategoryID']  = ',' . implode(',', $this->input->post('bookcategoryID')) . ',';
                $array['quantity']        = $this->input->post('quantity');
                $array['volume']          = empty($this->input->post('volume')) ? 1 : ($this->input->post('volume') == 0 ? 1 : $this->input->post('volume'));
                $array['price']           = $this->input->post('price');
                $array['codeno']          = $this->input->post('codeno');
                $array['coverphoto']      = $this->upload_data['coverphoto']['file_name'];
                $array['isbnno']          = $this->input->post('isbnno');
                $array['rackID']          = ($this->input->post('rackID')) ? $this->input->post('rackID') : null;
                $array['editionnumber']   = $this->input->post('editionnumber');
                $array['editiondate']     = (($this->input->post('editiondate')) ? date('Y-m-d', strtotime($this->input->post('editiondate'))) : null);
                $array['publisher']       = $this->input->post('publisher');
                $array['publisheddate']   = (($this->input->post('publisheddate')) ? date('Y-m-d', strtotime($this->input->post('publisheddate'))) : null);
                $array['notes']           = $this->input->post('notes');
                $array['create_date']     = date('Y-m-d H:i:s');
                $array['create_memberID'] = $this->session->userdata('loginmemberID');
                $array['create_roleID']   = $this->session->userdata('roleID');
                $array['modify_date']     = date('Y-m-d H:i:s');
                $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                $array['modify_roleID']   = $this->session->userdata('roleID');
                $this->book_m->insert_book($array);
                $bookID = $this->db->insert_id();

                $bookitemArray = [];
                $bookno = 1;
                $booknovol = 1;

                for ($i = 1; $i <= $array['quantity'] * $array['volume']; $i++) {
                    $booknovol = 1;
                    for ($j = 1; $j <= $array['volume']; $j++) {
                        $bookitemArray[$i]['bookID']     = $bookID;
                        $bookitemArray[$i]['bookno']     = $bookno;
                        $bookitemArray[$i]['booknovol']  = $booknovol;
                        $bookitemArray[$i]['status']     = 0;
                        $bookitemArray[$i]['deleted_at'] = 0;
                        $booknovol++;
                        $i++;
                    }
                    $bookno++;
                    $i--;
                }
                $this->bookitem_m->insert_bookitem_batch($bookitemArray);

                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('book/index'));
            }
        } else {
            $this->data["subview"] = "book/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $bookID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $bookID) {
            $book = $this->book_m->get_single_book(array('bookID' => $bookID, 'deleted_at' => 0));
            if (calculate($book)) {

                $this->data['headerassets'] = array(
                    'css'      => array(
                        'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
                        'assets/custom/css/fastselect.min.css',
                    ),
                    'headerjs' => array(
                        'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
                        'assets/custom/js/fastselect.standalone.js',
                    ),
                    'js'       => array(
                        'assets/custom/js/fileupload.js',
                    ),
                );

                $book->bookcategoryID = explode(',', $book->bookcategoryID);

                $this->data['book']          = $book;
                $this->data['booktypes']     = $this->booktype_m->get_booktype();
                $this->data['racks']         = $this->rack_m->get_rack();
                $this->data['bookcategorys'] = $this->bookcategory_m->get_order_by_bookcategory_orderby(array('status' => 1), null, 'level_in_catagory asc');
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "book/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array                    = [];
                        $array['name']            = $this->input->post('name');
                        $array['booktypeID']      = $this->input->post('booktypeID');
                        $array['author']          = $this->input->post('author');
                        $array['bookcategoryID']  = ',' . implode(',', $this->input->post('bookcategoryID')) . ',';
                        $array['quantity']        = $this->input->post('quantity');
                        $array['volume']          = empty($this->input->post('volume')) ? 1 : ($this->input->post('volume') == 0 ? 1 : $this->input->post('volume'));
                        $array['price']           = $this->input->post('price');
                        $array['codeno']          = $this->input->post('codeno');
                        $array['coverphoto']      = $this->upload_data['coverphoto']['file_name'];
                        $array['isbnno']          = $this->input->post('isbnno');
                        $array['rackID']          = ($this->input->post('rackID')) ? $this->input->post('rackID') : null;
                        $array['editionnumber']   = $this->input->post('editionnumber');
                        $array['editiondate']     = (($this->input->post('editiondate')) ? date('Y-m-d', strtotime($this->input->post('editiondate'))) : null);
                        $array['publisher']       = $this->input->post('publisher');
                        $array['publisheddate']   = (($this->input->post('publisheddate')) ? date('Y-m-d', strtotime($this->input->post('publisheddate'))) : null);
                        $array['notes']           = $this->input->post('notes');
                        $array['modify_date']     = date('Y-m-d H:i:s');
                        $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                        $array['modify_roleID']   = $this->session->userdata('roleID');

                        $arrayBookID = array('bookID' => $bookID);

                        $test1 = 0;
                        $test2 = 0;
                        // && $this->input->post('quantity')> $book->quantity
                        if ($this->input->post('quantity') != $book->quantity)
                            $test2 = 1;
                        $bookissue = $this->bookissue_m->get_order_by_bookissue(['deleted_at' => 0, 'bookID' => $bookID]);
                        foreach ($bookissue as $book) {
                            if ($book->status == 0)
                                $test1 += 1;
                        }
        

                        if ($test1 != 0 && $test2 != 0) {
                            $this->session->set_flashdata('error', "This book cannot be update quantity. It has " . $test1 . " borrowed account");
                            redirect(base_url('book/index'));
                        } else {
                            $this->bookitem_m->delete_bookitem_by_bookID($arrayBookID);
                            $bookitemArray = [];
                            $bookno = 1;
                            $booknovol = 1;

                            for ($i = 1; $i <= $array['quantity'] * $array['volume']; $i++) {
                                $booknovol = 1;
                                for ($j = 1; $j <= $array['volume']; $j++) {
                                    $bookitemArray[$i]['bookID']     = $bookID;
                                    $bookitemArray[$i]['bookno']     = $bookno;
                                    $bookitemArray[$i]['booknovol']  = $booknovol;
                                    $bookitemArray[$i]['status']     = 0;
                                    $bookitemArray[$i]['deleted_at'] = 0;
                                    $booknovol++;
                                    $i++;
                                }
                                $bookno++;
                                $i--;
                            }
                            $this->bookitem_m->insert_bookitem_batch($bookitemArray);
                            $this->book_m->update_book($array, $bookID);
                            $this->session->set_flashdata('success', 'Success');
                            redirect(base_url('book/index'));
                        }
                    }
                } else {
                    $this->data["subview"] = "book/edit";
                    $this->load->view('_main_layout', $this->data);
                }
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function view()
    {
        $bookID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $bookID) {
            $book = $this->book_m->get_single_book(array('bookID' => $bookID));
            if (calculate($book)) {
                $this->data['book'] = $book;
                $book->bookcategoryID = explode(',', $book->bookcategoryID);

                $this->data['bookcategory'] = [];
                if ((int) $book->bookcategoryID) {
                    $this->data['bookcategory'] = $this->bookcategory_m->get_where_in_bookcategory('bookcategoryID', $book->bookcategoryID);
                }

                $this->data['rack'] = [];
                if ((int) $book->rackID) {
                    $this->data['rack'] = $this->rack_m->get_single_rack(['rackID' => $book->rackID]);
                }

                $this->data['booktype'] = [];
                if ((int) $book->booktypeID) {
                    $this->data['booktype'] = $this->booktype_m->get_single_booktype(['booktypeID' => $book->booktypeID]);
                }

                $this->data['racks']         = $this->rack_m->get_rack();
                $this->data['booktypes']         = $this->booktype_m->get_booktype();
                $this->data['bookcategorys'] = $this->bookcategory_m->get_order_by_bookcategory(array('status' => 1));

                $this->data["subview"] = "book/view";
                $this->load->view('_main_layout', $this->data);
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function delete()
    {
        $bookID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $bookID) {
            $book = $this->book_m->get_single_book(array('bookID' => $bookID, 'deleted_at !=' => 1));
            if (calculate($book)) {
                $this->book_m->update_book(['deleted_at' => 1], $bookID);
                $this->bookitem_m->update_bookitem_by_bookID(['deleted_at' => 1], $bookID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('book/index'));
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function import()
    {
        if ($this->input->post('submit')) {
            $inserdata = [];
            $path = 'uploads/';
            require_once APPPATH . "/third_party/PHPExcel.php";
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls|csv';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('fileupload')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if (empty($error)) {
                // if (!empty($data['upload_data']['file_name'])) {
                // } else {
                //     $import_xls_file = 0;
                // }

                $import_xls_file = $data['upload_data']['file_name'];

                $inputFileName = $path . $import_xls_file;

                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $flag = true; // Header in Xls
                    $i = 0;

                    $bookCodes_count = count($allDataInSheet) - 1;
                    $bookCodes_error_count = 0;

                    foreach ($allDataInSheet as $value) {
                        if ($flag) {
                            $flag = false;
                            continue;
                        }

                        $book = $this->book_m->get_single_book(array('codeno' => $value['I'], 'deleted_at !=' => 1));

                        if (empty($value['I']) || calculate($book)) {
                            echo '0';
                            $bookCodes_error_count++;
                            continue;
                        }

                        $bookcategory = $this->bookcategory_m->get_single_bookcategory(array('bookcategoryID' => $value['C']));

                        if (empty($value['C']) || !calculate($bookcategory)) {
                            echo '1';
                            $bookCodes_error_count++;
                            continue;
                        }

                        $booktype = $this->booktype_m->get_single_booktype(['booktypeID' => $value['K']]);

                        if (empty($value['K']) || !calculate($booktype)) {
                            echo '2';
                            $bookCodes_error_count++;
                            continue;
                        }

                        $rack = $this->rack_m->get_single_rack(['rackID' => $value['J']]);

                        if (!empty($value['J']) && !calculate($rack)) {
                            echo '3';
                            $bookCodes_error_count++;
                            continue;
                        }

                        if (empty($value['D']) || $value['D'] == 0 || !filter_var($value['D'], FILTER_VALIDATE_INT)) {
                            echo '4';
                            $bookCodes_error_count++;
                            continue;
                        }

                        if (empty($value['A']) || empty($value['B'])) {
                            echo '5';
                            $bookCodes_error_count++;
                            continue;
                        }

                        if (!empty($value['E']) && !filter_var($value['E'], FILTER_VALIDATE_INT)) {
                            echo '6';
                            $bookCodes_error_count++;
                            continue;
                        }

                        $inserdata[$i]['name']              = $value['A'];
                        $inserdata[$i]['author']            = $value['B'];
                        $inserdata[$i]['bookcategoryID']    = ',' . $value['C'] . ',';
                        $inserdata[$i]['quantity']          = $value['D'];
                        $inserdata[$i]['volume']            = empty($value['E']) ? 1 : ($value['E'] == 0 ? 1 : $value['E']);
                        $inserdata[$i]['price']             = $value['F'];
                        $inserdata[$i]['isbnno']            = $value['G'];
                        $inserdata[$i]['coverphoto']        = empty($value['H']) ? 'book.jpg' : $value['H'];
                        $inserdata[$i]['codeno']            = $value['I'];
                        $inserdata[$i]['rackID']            = $value['J'];
                        $inserdata[$i]['booktypeID']        = $value['K'];
                        $inserdata[$i]['editionnumber']     = $value['L'];
                        $inserdata[$i]['editiondate']       = $value['M'];
                        $inserdata[$i]['publisher']         = $value['N'];
                        $inserdata[$i]['publisheddate']     = $value['O'];
                        $inserdata[$i]['notes']             = $value['P'];
                        $inserdata[$i]['status']            = 0;
                        $inserdata[$i]['deleted_at']        = 0;
                        $inserdata[$i]['create_date']       = date('Y-m-d H:i:s');
                        $i++;
                    }

                    $result = $this->book_m->import_book_batch($inserdata);

                    // print_r($result);
                    // return;

                    if ($result[1] >= 1) {
                        for ($b = $result[0]; $b < $result[0] + $result[1]; $b++) {
                            $book = $this->book_m->get_single_book(array('bookID' => $b));
                            $bookID     = $book->bookID;
                            $quantity   = $book->quantity;
                            $volume     = $book->volume;
                            $bookitemArray = [];
                            $bookno = 1;
                            $booknovol = 1;

                            for ($i = 1; $i <= $quantity * $volume; $i++) {
                                $booknovol = 1;
                                for ($j = 1; $j <= $volume; $j++) {
                                    $bookitemArray[$i]['bookID']     = $bookID;
                                    $bookitemArray[$i]['bookno']     = $bookno;
                                    $bookitemArray[$i]['booknovol']  = $booknovol;
                                    $bookitemArray[$i]['status']     = 0;
                                    $bookitemArray[$i]['deleted_at'] = 0;
                                    $booknovol++;
                                    $i++;
                                }
                                $bookno++;
                                $i--;
                            }

                            $this->bookitem_m->insert_bookitem_batch($bookitemArray);
                        }
                    }

                    if ($result) {

                        $books_success = $bookCodes_count - $bookCodes_error_count;

                        $this->session->set_flashdata('success', $books_success . '/' . $bookCodes_count . ' Books Success');

                        redirect('/book', '');
                    }
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                        . '": ' . $e->getMessage());
                }
            } else {
                $error['error'];
                $this->session->set_flashdata('error', $error['error']);
            }
            redirect('/book', '');
        }
        redirect('/book', '');
    }

    private function rules()
    {
        $rules = array(
            array(
                'field' => 'name',
                'label' => $this->lang->line('book_name'),
                'rules' => 'trim|xss_clean|required|max_length[100]',
            ),
            array(
                'field' => 'author',
                'label' => $this->lang->line('book_author'),
                'rules' => 'trim|xss_clean|required|max_length[100]',
            ),
            array(
                'field' => 'quantity',
                'label' => $this->lang->line('book_quantity'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'volume',
                'label' => $this->lang->line('book_volume'),
                'rules' => 'trim|xss_clean|numeric|required_no_zero',
            ),
            array(
                'field' => 'price',
                'label' => $this->lang->line('book_price'),
                'rules' => 'trim|xss_clean|required|max_length[100]|numeric',
            ),
            array(
                'field' => 'codeno',
                'label' => $this->lang->line('book_code_no'),
                'rules' => 'trim|xss_clean|required|max_length[100]|callback_check_unique_bookno',
            ),
            array(
                'field' => 'coverphoto',
                'label' => $this->lang->line('book_cover_photo'),
                'rules' => 'trim|xss_clean|callback_coverphoto_upload',
            ),
            array(
                'field' => 'isbnno',
                'label' => $this->lang->line('book_isbn_no'),
                'rules' => 'trim|xss_clean|max_length[100]',
            ),
            array(
                'field' => 'rackID',
                'label' => $this->lang->line('book_rack'),
                'rules' => 'trim|xss_clean|numeric',
            ),
            array(
                'field' => 'bookcategoryID',
                'label' => $this->lang->line('book_book_category'),
                'rules' => 'trim|xss_clean|callback_check_default',
            ),
            array(
                'field' => 'booktypeID',
                'label' => $this->lang->line('book_booktype'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'editionnumber',
                'label' => $this->lang->line('book_edition_number'),
                'rules' => 'trim|xss_clean|max_length[100]',
            ),
            array(
                'field' => 'editiondate',
                'label' => $this->lang->line('book_edition_date'),
                'rules' => 'trim|xss_clean|valid_date',
            ),
            array(
                'field' => 'publisher',
                'label' => $this->lang->line('book_publisher'),
                'rules' => 'trim|xss_clean|max_length[200]',
            ),
            array(
                'field' => 'publisheddate',
                'label' => $this->lang->line('book_published_date'),
                'rules' => 'trim|xss_clean|valid_date',
            ),
            array(
                'field' => 'notes',
                'label' => $this->lang->line('book_notes'),
                'rules' => 'trim|xss_clean|max_length[1000]',
            ),
        );
        return $rules;
    }

    public function coverphoto_upload()
    {
        $bookID = htmlentities(escapeString($this->uri->segment(3)));
        $book   = array();
        if ((int) $bookID) {
            $book = $this->book_m->get_single_book(array('bookID' => $bookID));
        }

        $new_file = "";
        if ($_FILES["coverphoto"]['name'] != "") {
            $file_name        = $_FILES["coverphoto"]['name'];
            $random           = rand(1, 10000000000000000);
            $file_name_rename = hash('sha512', $random . config_item("encryption_key"));
            $explode          = explode('.', $file_name);
            if (calculate($explode) >= 2) {
                $new_file                = $file_name_rename . '.' . end($explode);
                $config['upload_path']   = "./uploads/book";
                $config['allowed_types'] = "gif|jpg|png";
                $config['file_name']     = $new_file;
                $config['max_size']      = "2048";
                $config['max_width']     = "2000";
                $config['max_height']    = "2000";
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload("coverphoto")) {
                    $this->form_validation->set_message("coverphoto_upload", $this->upload->display_errors());
                    return false;
                } else {
                    $this->upload_data['coverphoto'] = $this->upload->data();
                    return true;
                }
            } else {
                $this->form_validation->set_message("coverphoto_upload", "Invalid file");
                return false;
            }
        } else {
            if (calculate($book)) {
                $this->upload_data['coverphoto'] = array('file_name' => $book->coverphoto);
                return true;
            } else {
                $this->form_validation->set_message("coverphoto_upload", "The %s field is required.");
                return false;
            }
        }
    }

    function check_default()
    {
        $choice = $this->input->post("bookcategoryID");
        if (empty($choice)) {
            $choice = array();
        }
        $bookcategoryID = implode(',', $choice);

        if ($bookcategoryID != '')
            return true;
        else {
            $this->form_validation->set_message("check_default", "The %s field is required.");
            return false;
        }
    }

    public function check_unique_bookno($bookno)
    {
        $bookID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $bookID) {
            $bookByID = $this->book_m->get_single_book(array('bookID' => $bookID));
            $book = $this->book_m->get_single_book(array('codeno =' => $bookno, 'bookID !=' => $bookByID->bookID));

            if (calculate($book)) {
                $this->form_validation->set_message("check_unique_bookno", "The %s is already exits.");
                return false;
            }
            return true;
        } else {
            $book = $this->book_m->get_single_book(array('codeno =' => $bookno));
            if (calculate($book)) {
                $this->form_validation->set_message("check_unique_bookno", "The %s is already exits.");
                return false;
            }
            return true;
        }
    }
}
