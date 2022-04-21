<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Libraryconfigure extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('role_m');
        $this->load->model('booktype_m');
        $this->load->model('libraryconfigure_m');

        $lang = $this->session->userdata('language');
        $this->lang->load('libraryconfigure', $lang);
    }

    public function index()
    {
        $this->data['roles']        = pluck($this->role_m->get_role(), 'role', 'roleID');
        $this->data['booktypes']    = pluck($this->booktype_m->get_booktype(), 'name', 'booktypeID');
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
        $this->data['libraryconfigures'] = $this->libraryconfigure_m->get_libraryconfigure_join_type();
        $this->data["subview"]           = "libraryconfigure/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function add()
    {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/custom/css/fastselect.min.css',
            ),
            'headerjs' => array(
                'assets/custom/js/fastselect.standalone.js',
            ),
        );

        $this->data['roles'] = $this->role_m->get_role();
        $this->data['booktypes']    = $this->booktype_m->get_booktype();
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "libraryconfigure/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                           = [];
                $array['roleID']                 = $this->input->post('roleID');
                $array['max_issue_book']         = $this->input->post('max_issue_book');
                $array['max_renewed_limit']      = $this->input->post('max_renewed_limit');
                $array['per_renew_limit_day']    = $this->input->post('per_renew_limit_day');
                $array['book_fine_per_day']      = $this->input->post('book_fine_per_day');
                $array['issue_off_limit_amount'] = $this->input->post('issue_off_limit_amount');
                $array['double_book'] = $this->input->post('double_book');
                $array['booktype']               = implode(',', $this->input->post('booktypeID'));
                $this->libraryconfigure_m->insert_libraryconfigure($array);

                $this->session->set_flashdata('success', 'Success11');
                redirect(base_url('libraryconfigure/index'));
            }
        } else {
            $this->data["subview"] = "libraryconfigure/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/custom/css/fastselect.min.css',
            ),
            'headerjs' => array(
                'assets/custom/js/fastselect.standalone.js',
            ),
        );

        $this->data['booktypes']    = $this->booktype_m->get_booktype();

        $libraryconfigureID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $libraryconfigureID) {
            $libraryconfigure = $this->libraryconfigure_m->get_single_libraryconfigure(array('libraryconfigureID' => $libraryconfigureID));
            $libraryconfigure->booktype = explode(',', $libraryconfigure->booktype);

            $this->data['libraryconfigure'] = $libraryconfigure;

            if (calculate($this->data['libraryconfigure'])) {
                $this->data['roles'] = $this->role_m->get_role();
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false  ||  $this->input->post('booktypeID') == "0") {
                        $this->data["subview"] = "libraryconfigure/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array                           = [];
                        $array['roleID']                 = $this->input->post('roleID');
                        $array['max_issue_book']         = $this->input->post('max_issue_book');
                        $array['max_renewed_limit']      = $this->input->post('max_renewed_limit');
                        $array['per_renew_limit_day']    = $this->input->post('per_renew_limit_day');
                        $array['book_fine_per_day']      = $this->input->post('book_fine_per_day');
                        $array['issue_off_limit_amount'] = $this->input->post('issue_off_limit_amount');
                        $array['double_book'] = $this->input->post('double_book');
                        $array['booktype']               = implode(',', $this->input->post('booktypeID'));

                        $this->libraryconfigure_m->update_libraryconfigure($array, $libraryconfigureID);

                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('libraryconfigure/index'));
                    }
                } else {
                    $this->data["subview"] = "libraryconfigure/edit";
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
        $libraryconfigureID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $libraryconfigureID) {
            $libraryconfigure = $this->libraryconfigure_m->get_single_libraryconfigure(array('libraryconfigureID' => $libraryconfigureID));
            if (calculate($libraryconfigure)) {
                $this->libraryconfigure_m->delete_libraryconfigure($libraryconfigureID);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('libraryconfigure/index'));
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
                'field' => 'roleID',
                'label' => $this->lang->line('libraryconfigure_role'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero|callback_check_unique_role',
            ),
            array(
                'field' => 'max_issue_book',
                'label' => $this->lang->line('libraryconfigure_max_issue_book'),
                'rules' => 'trim|xss_clean|required|integer',
            ),
            array(
                'field' => 'max_renewed_limit',
                'label' => $this->lang->line('libraryconfigure_max_renewed_limit'),
                'rules' => 'trim|xss_clean|required|integer',
            ),
            array(
                'field' => 'per_renew_limit_day',
                'label' => $this->lang->line('libraryconfigure_per_renew_limit_day'),
                'rules' => 'trim|xss_clean|required|integer',
            ),
            array(
                'field' => 'book_fine_per_day',
                'label' => $this->lang->line('libraryconfigure_book_fine_per_day'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'issue_off_limit_amount',
                'label' => $this->lang->line('libraryconfigure_issue_off_limit_amount'),
                'rules' => 'trim|xss_clean|required|numeric',
            ),
            array(
                'field' => 'booktypeID',
                'label' => $this->lang->line('libraryconfigure_booktype'),
                'rules' => 'trim|xss_clean|callback_check_default|required_no_zero',
            ),
        );
        return $rules;
    }

    public function check_unique_role($roleID)
    {
         // ,'booktype ='=>$booktypeID
        $libraryconfigureID = htmlentities(escapeString($this->uri->segment(3)));
        $booktypeID =$this->input->post('booktypeID')[0];
        if ((int) $libraryconfigureID) {
            $libraryconfigure = $this->libraryconfigure_m->get_single_libraryconfigure(array('roleID' => $roleID, 'libraryconfigureID !=' => $libraryconfigureID,'booktype ='=>$booktypeID));
            if (calculate($libraryconfigure)) {
                $this->session->set_flashdata('success', 'The role and book type are already exits.');
                $this->form_validation->set_message("check_unique_role", "The %s  is already exits.");
                return false;
            }
            return true;
        } else {
            $libraryconfigure = $this->libraryconfigure_m->get_single_libraryconfigure(array('roleID' => $roleID,'booktype ='=>$booktypeID));
            if (calculate($libraryconfigure)) {
                $this->session->set_flashdata('success', 'The role and book type are already exits.');
                $this->form_validation->set_message("check_unique_role", "The %s  is already exits.");
                return false;
            }
            return true;
        }
    }

    function check_default()
    {
        $choice = $this->input->post("booktypeID");
        if (empty($choice)) {
            $choice = array();
        }
        $booktypeID = implode(',', $choice);

        if ($booktypeID != '')
            return true;
        else {
            $this->form_validation->set_message("check_default", "The %s field is required.");
            return false;
        }
    }
}
