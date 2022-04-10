<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booktype extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('booktype_m');

        $lang = $this->session->userdata('language');
        $this->lang->load('booktype', $lang);
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

        $this->data['booktypes']   = $this->booktype_m->get_booktype();
        $this->data["subview"] = "booktype/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function add()
    {
        var_dump("ok");
        die;
        $this->data['headerassets'] = array(
            'css'      => array(
                'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            ),
            'headerjs' => array(
                'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            ),
        );

        $bookissue_type = array(0,1,2);

        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "booktype/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                    = [];
                $array['name']            = $this->input->post('name');
                $array['description']     = $this->input->post('description');
                $array['bookissue_type']  = in_array($this->input->post('bookissue_type'), $bookissue_type) ? $this->input->post('bookissue_type') : 0;
                $array['bookissue_date']  = $this->input->post('bookissue_date');
                $array['create_date']     = date('Y-m-d H:i:s');
                $array['create_memberID'] = $this->session->userdata('loginmemberID');
                $array['create_roleID']   = $this->session->userdata('roleID');
                $array['modify_date']     = date('Y-m-d H:i:s');
                $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                $array['modify_roleID']   = $this->session->userdata('roleID');

                $this->booktype_m->insert_booktype($array);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('booktype/index'));
            }
        } else {
            $this->data["subview"] = "booktype/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $this->data['headerassets'] = array(
            'css'      => array(
                'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            ),
            'headerjs' => array(
                'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            ),
        );

        $bookissue_type = array(0,1,2);

        $booktypeID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $booktypeID) {
            $this->data['booktype'] = $this->booktype_m->get_single_booktype(array('booktypeID' => $booktypeID));
            if (calculate($this->data['booktype'])) {
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "booktype/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array                    = [];
                        $array['name']            = $this->input->post('name');
                        $array['description']     = $this->input->post('description');
                        $array['bookissue_type']  = in_array($this->input->post('bookissue_type'), $bookissue_type) ? $this->input->post('bookissue_type') : 0;
                        $array['bookissue_date']  = $this->input->post('bookissue_date');
                        $array['modify_date']     = date('Y-m-d H:i:s');
                        $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                        $array['modify_roleID']   = $this->session->userdata('roleID');

                        $this->booktype_m->update_booktype($array, $booktypeID);
                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('booktype/index'));
                    }
                } else {
                    $this->data["subview"] = "booktype/edit";
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

    public function delete()
    {
        $booktypeID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $booktypeID) {
            $booktype = $this->booktype_m->get_single_booktype(array('booktypeID' => $booktypeID));
            if (calculate($booktype)) {
                $this->booktype_m->delete_booktype($booktypeID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('booktype/index'));
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    private function rules()
    {
        $rules = array(
            array(
                'field' => 'name',
                'label' => $this->lang->line('booktype_name'),
                'rules' => 'trim|xss_clean|required|max_length[100]|callback_check_unique_booktype',
            ),
            array(
                'field' => 'description',
                'label' => $this->lang->line('booktype_description'),
                'rules' => 'trim|xss_clean|required',
            ),
            array(
                'field' => 'bookissue_type',
                'label' => $this->lang->line('booktype_bookissue_type'),
                'rules' => 'trim|required|xss_clean',
            ),
            array(
                'field' => 'bookissue_date',
                'label' => $this->lang->line('bookissue_date'),
                'rules' => $this->input->post('bookissue_type') == 2 ? 'trim|xss_clean|valid_date_month_day_only|required' : 'trim|xss_clean',
            ),
        );
        return $rules;
    }

    public function check_unique_booktype($name)
    {
        $booktypeID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $booktypeID) {
            $booktype = $this->booktype_m->get_single_booktype(array('name' => $name, 'booktypeID !=' => $booktypeID));
            if (calculate($booktype)) {
                $this->form_validation->set_message("check_unique_booktype", "The %s is already exits.");
                return false;
            }
            return true;
        } else {
            $booktype = $this->booktype_m->get_single_booktype(array('name' => $name));
            if (calculate($booktype)) {
                $this->form_validation->set_message("check_unique_booktype", "The %s is already exits.");
                return false;
            }
            return true;
        }
    }

}
