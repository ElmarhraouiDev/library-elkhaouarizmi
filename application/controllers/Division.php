<?php
defined('BASEPATH') or exit('No direct script access allowed');

class division extends Admin_Controller
{
    public $notdeleteArray = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('classe_m');

        $lang = $this->session->userdata('language');
        $this->lang->load('classe', $lang);
    }

    protected function rules()
    {
        $rules = array(
            array(
                'field' => 'classe',
                'label' => $this->lang->line('classe_classe'),
                'rules' => 'trim|xss_clean|required|max_length[30]|callback_check_unique_classe',
            ),
        );
        return $rules;
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
        $this->data['classes'] = $this->classe_m->get_classe(array('classeID', 'classe', 'create_date'));

        $this->data["subview"] = "classe/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function add()
    {
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "classe/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                    = [];
                $array['classe']            = $this->input->post('classe');
                $array['create_date']     = date('Y-m-d H:i:s');
                $array['create_memberID'] = $this->session->userdata('loginmemberID');
                $array['create_roleID']   = $this->session->userdata('roleID');
                $array['modify_date']     = date('Y-m-d H:i:s');
                $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                $array['modify_roleID']   = $this->session->userdata('roleID');

                $this->classe_m->insert_classe($array);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('division/index'));
            }
        } else {
            $this->data["subview"] = "classe/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $classeID = escapeString($this->uri->segment('3'));
        if ((int) $classeID) {
            $this->data['classe'] = $this->classe_m->get_single_classe($classeID);
            if (calculate($this->data['classe'])) {
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "classe/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array                    = [];
                        $array['classe']            = $this->input->post('classe');
                        $array['modify_date']     = date('Y-m-d H:i:s');
                        $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                        $array['modify_roleID']   = $this->session->userdata('roleID');

                        $this->classe_m->update_classe($array, $classeID);
                        $this->session->set_flashdata('success', 'Success');
                        redirect(base_url('division/index'));
                    }
                } else {
                    $this->data["subview"] = "classe/edit";
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
        $classeID = escapeString($this->uri->segment('3'));
        if ((int) $classeID) {
            $classe = $this->classe_m->get_single_classe(array('classeID' => $classeID));
            if (calculate($classe)) {
                if (!in_array($classeID, $this->notdeleteArray)) {
                    $this->classe_m->delete_classe($classeID);
                    $this->session->set_flashdata('success', 'Success');
                } else {
                    $this->session->set_flashdata('error', 'The classe Can\'t delete.');
                }
                redirect(base_url('division/index'));
            } else {
                $this->data["subview"] = "_not_found";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "_not_found";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function check_unique_classe($classe)
    {
        $classeID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $classeID) {
            $classe = $this->classe_m->get_single_classe(array('classe' => $classe, 'classeID !=' => $classeID));
            if (calculate($classe)) {
                $this->form_validation->set_message("check_unique_classe", "The %s is already exits.");
                return false;
            }
            return true;
        } else {
            $classe = $this->classe_m->get_single_classe(array('classe' => $classe));
            if (calculate($classe)) {
                $this->form_validation->set_message("check_unique_classe", "The %s is already exits.");
                return false;
            }
            return true;
        }
    }

}
