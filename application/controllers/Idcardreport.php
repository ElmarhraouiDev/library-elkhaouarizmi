<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Idcardreport extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct(); 
        $this->load->model('role_m');
        $this->load->model('member_m');
        $this->load->model('classe_m');
        $this->load->library('barcode');
        $this->load->library('pdf');

        $lang = $this->session->userdata('language');
        $this->lang->load('idcardreport', $lang);
    }

    public function index()
    {
        $this->data['headerassets'] = array(
            'css'      => array(
                'assets/custom/css/fastselect.min.css',
            ),
            'js' => array(
                'assets/custom/js/idcardreport.js',
            ),
            
            'headerjs' => array(
                'assets/custom/js/fastselect.standalone.js',
            ),
            
        );
        $this->data['flag']     = 0;
        $this->data['type']     = 0;
        $this->data['roleID']   = 0;
        $this->data['memberID'] = 0;
        $this->data['members']  = [];
        $this->data['roles']    = $this->role_m->get_role();
        $this->data['classes']  = $this->classe_m->get_classe();
        
        if ($_POST && isset($_POST['print_pdf'])) {
            $this->pdf();
            return;
        }

        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $message = implode('<br/>', $this->form_validation->error_array());
                $this->session->set_flashdata('error', $message);
                $this->data["subview"] = "report/idcard/index";
                $this->load->view('_main_layout', $this->data);
            } else {
                // $roleID   = $this->input->post('roleID');
                // $memberID = $this->input->post('memberID');

                $mode     = $this->input->post('rd_mode') == 2 ? 2 : 1;
                $type     = $this->input->post('type');
                $roleID     = $this->input->post('roleID') ? $this->input->post('roleID') : null;
                $classesID  = $this->input->post('classeID') ? $this->input->post('classeID') : null;
                $memberID  =    $this->input->post('memberID') ? $this->input->post('memberID') : null;
                $roleIDField = $roleID == null ? null : 'roleID';
                $classeIDField = $classesID == null ? null : 'classeID';
                $memberIDField = $memberID == null ? null : 'memberID';

                $options[0]         = $this->input->post('ck_username');
                $options[1]         = $this->input->post('ck_class');
                $options[2]         = $this->input->post('ck_role');
                $options[3]         = $this->input->post('ck_phone');
                $options[4]         = $this->input->post('ck_address');
                $options[5]         = $this->input->post('ck_email');
                $options[6]         = $this->input->post('ck_fbarcode');
                $options[7]         = $this->input->post('ck_class_group');
                $options[8]         = $this->input->post('ck_birthday');
                $options[9]         = $this->input->post('ck_birthplace');

                $queryArray['roleID'] = $roleID;
                if ((int) $memberID) {
                    $queryArray['memberID'] = $memberID;
                }
                $queryArray['status']     = 1;
                $queryArray['deleted_at'] = 0;
                $members = $this->member_m->get_3where_in_member($roleIDField ,$roleID, $classeIDField, $classesID,$memberIDField,$memberID, array('status' => 1, 'deleted_at' => 0), array('memberID', 'name', 'dateofbirth', 'gender', 'photo', 'bloodgroup', 'phone', 'email', 'classeID', 'username', 'roleID', 'address', 'code', 'class_group', 'dateofbirth', 'placeofbirth'));
                // $members                  = $this->member_m->get_order_by_member($queryArray);
                $this->generatebarcode($members);

                // print_r($members);
                // exit;

                $this->data['mode']     = $mode;
                $this->data['flag']     = 1;
                $this->data['type']     = $type;
                $this->data['roleID']   = $roleID;
                $this->data['memberID'] = $memberID;
                $this->data['members']  = $members;
                $this->data['options']  = $options;
                $this->data["subview"]  = "report/idcard/index";
                $this->load->view('_main_layout', $this->data);
            }
        } else {
            $this->data["subview"] = "report/idcard/index";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function pdf()
    {
        $mode     = $this->input->post('rd_mode') == 2 ? 2 : 1;
        $type     = $this->input->post('type');
        $roleID     = $this->input->post('roleID') ? $this->input->post('roleID') : null;
        $classesID  = $this->input->post('classeID') ? $this->input->post('classeID') : null;
        $memberID  =    $this->input->post('memberID') ? $this->input->post('memberID') : null;
        $roleIDField = $roleID == null ? null : 'roleID';
        $classeIDField = $classesID == null ? null : 'classeID';
        $memberIDField = $memberID == null ? null : 'memberID';

        $options[0]         = $this->input->post('ck_username');
        $options[1]         = $this->input->post('ck_class');
        $options[2]         = $this->input->post('ck_role');
        $options[3]         = $this->input->post('ck_phone');
        $options[4]         = $this->input->post('ck_address');
        $options[5]         = $this->input->post('ck_email');
        $options[6]         = $this->input->post('ck_fbarcode');
        $options[7]         = $this->input->post('ck_class_group');
        $options[8]         = $this->input->post('ck_birthday');
        $options[9]         = $this->input->post('ck_birthplace');

        $queryArray['roleID'] = $roleID;
        if ((int) $memberID) {
            $queryArray['memberID'] = $memberID;
        }
        $queryArray['status']     = 1;
        $queryArray['deleted_at'] = 0;
        $members = $this->member_m->get_3where_in_member($roleIDField ,$roleID, $classeIDField, $classesID,$memberIDField,$memberID, array('status' => 1, 'deleted_at' => 0), array('memberID', 'name', 'dateofbirth', 'gender', 'photo', 'bloodgroup', 'phone', 'email', 'classeID', 'username', 'roleID', 'address', 'code', 'class_group', 'dateofbirth', 'placeofbirth'));

        $this->generatebarcode($members);

        $this->data['mode']     = $mode;
        $this->data['type']     = $type;
        $this->data['roleID']   = $roleID;
        $this->data['memberID'] = $memberID;
        $this->data['members']  = $members;
        $this->data['options']  = $options;

        $this->pdf->create(['stylesheet2' => 'kv-mpdf-bootstrap.css', 'stylesheet' => 'idcardreport.css',  'view' => 'report/idcard/pdf.php', 'data' => $this->data]);
    }

    private function generatebarcode($members)
    {
        if (calculate($members)) {
            foreach ($members as $member) {
                $memberCode = $member->code;
                $this->barcode->generate($memberCode, $memberCode);
            }
        }
    }

    public function get_member()
    {
        echo "<option value='0'>" . $this->lang->line('idcardreport_please_select') . "</option>";
        if ($_POST && permissionChecker('idcardreport')) {
            $roleID     = $this->input->post('roleID') ? $this->input->post('roleID') : null;
            $classesID  = $this->input->post('classeID') ? $this->input->post('classeID') : null;
            $roleIDField = $roleID == null ? null : 'roleID';
            $classeIDField = $classesID == null ? null : 'classeID';

            if ((int) $roleID || (int) $classesID) {
                $members = $this->member_m->get_3where_in_member($roleIDField ,$roleID, $classeIDField, $classesID,null,null, array('status' => 1, 'deleted_at' => 0), array('memberID', 'name'));
                if (calculate($members)) {
                    foreach ($members as $member) {
                        echo "<option value='" . $member->memberID . "'>" . $member->name . "</option>";
                    }
                }
            }
        }
    }

    private function rules()
    {
        $rules = array(
            array(
                'field' => 'roleID',
                'label' => $this->lang->line('idcardreport_role'),
                'rules' => 'trim|xss_clean',
            ),
            array(
                'field' => 'classeID',
                'label' => $this->lang->line('idcardreport_member'),
                'rules' => 'trim|xss_clean',
            ),
            array(
                'field' => 'memberID',
                'label' => $this->lang->line('idcardreport_member'),
                'rules' => 'trim|xss_clean',
            ),
            array(
                'field' => 'type',
                'label' => $this->lang->line('idcardreport_type'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero',
            ),
        );
        return $rules;
    }

}
