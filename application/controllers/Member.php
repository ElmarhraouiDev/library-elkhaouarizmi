<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('role_m');
        $this->load->model('classe_m');
        $this->load->model('member_m');
        $this->load->model('bookcategory_m');
        $this->load->model('book_m');
        $this->load->model('bookissue_m');

        $lang = $this->session->userdata('language');
        $this->lang->load('member', $lang);
    }

    public function index()
    {
        $setroleID = htmlentities(escapeString($this->uri->segment(3)));
        $setroleID = $setroleID ? $setroleID : 3;

        $this->data['headerassets'] = array(
            'css'      => array(
                'assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css',
                'assets/custom/css/hidetable.css',
            ),
            'headerjs' => array(
                'assets/plugins/datatables.net/js/jquery.dataTables.min.js',
                'assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js',
                'assets/custom/js/member.js',
            ),
        );
        $this->data['members']   = $this->member_m->get_order_by_member(['deleted_at' => 0, 'roleID' => $setroleID]);
        $this->data['classes']   = pluck($this->classe_m->get_classe(), 'classe', 'classeID');
        $this->data['roles']     = pluck($this->role_m->get_role(), 'role', 'roleID');
        $this->data['setroleID'] = $setroleID;
        $this->data["subview"]   = "member/index";
        $this->load->view('_main_layout', $this->data);
    }

    public function add()
    {
        $this->data['headerassets'] = array(
            'css'      => array(
                'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
            ),
            'headerjs' => array(
                'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            ),
            'js'       => array(
                'assets/custom/js/member.js',
                'assets/custom/js/fileupload.js',
            ),
        );

        $class_group    = array('A', 'B','C', 'D');

        $this->data['roles'] = $this->role_m->get_role(array('roleID', 'role'));
        $this->data['classes'] = $this->classe_m->get_classe(array('classeID', 'classe'));
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data["subview"] = "member/add";
                $this->load->view('_main_layout', $this->data);
            } else {
                $array                    = [];
                $array['name']            = $this->input->post('firstname') .' '.$this->input->post('lastname');
                $array['firstname']       = $this->input->post('firstname');
                $array['lastname']        = $this->input->post('lastname');
                $array['code']            = uniqid("",false);
                $array['gender']          = $this->input->post('gender');
                // $array['religion']        = $this->input->post('religion');
                $array['religion']        = 'islam';
                $array['email']           = $this->input->post('email');
                $array['phone']           = $this->input->post('phone');
                // $array['bloodgroup']      = $this->input->post('bloodgroup');
                $array['bloodgroup']      = '-';
                $array['address']         = $this->input->post('address');
                $array['dateofbirth']     = date('Y-m-d', strtotime($this->input->post('dateofbirth')));
                // $array['joinningdate']    = date('Y-m-d', strtotime($this->input->post('joinningdate')));
                $array['joinningdate']    = date('Y-m-d H:i:s');
                $array['photo']           = $this->upload_data['file']['file_name'];
                $array['roleID']          = $this->input->post('roleID');
                $array['classeID']        = $this->input->post('classeID');
                $array['placeofbirth']    = $this->input->post('placeofbirth');
                $array['class_group']     = in_array($this->input->post('class_group'), $class_group) ? $this->input->post('class_group') : 'A';
                $array['status']          = $this->input->post('status');
                $array['username']        = $this->input->post('username');
                $array['password']        = $this->password_hash($this->input->post('password'));
                $array['create_date']     = date('Y-m-d H:i:s');
                $array['create_memberID'] = $this->session->userdata('loginmemberID');
                $array['create_roleID']   = $this->session->userdata('roleID');
                $array['modify_date']     = date('Y-m-d H:i:s');
                $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                $array['modify_roleID']   = $this->session->userdata('roleID');

                $this->member_m->insert_member($array);
                $this->session->set_flashdata('success', 'Success');
                redirect(base_url('member/index'));
            }
        } else {
            $this->data["subview"] = "member/add";
            $this->load->view('_main_layout', $this->data);
        }
    }

    public function edit()
    {
        $class_group    = array('A', 'B','C', 'D');

        $memberID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $memberID) {
            $member = $this->member_m->get_single_member(array('memberID' => $memberID, 'deleted_at' => 0));
            $bookissue = $this->bookissue_m->get_order_by_bookissue(['deleted_at' => 0, 'memberID' => $memberID]);
            $test1 = 0;
            $test2 = 0; 
            foreach ($bookissue as $book){
                if( $book->status==0)
                   $test1+=1;
            }
            if($member->username != $this->input->post('username'))
            $test2 = 1;
            if (calculate($member)) {
                $this->data['headerassets'] = array(
                    'css'      => array(
                        'assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
                    ),
                    'headerjs' => array(
                        'assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
                    ),
                    'js'       => array(
                        'assets/custom/js/member.js',
                        'assets/custom/js/fileupload.js',
                    ),
                );
                $this->data['member'] = $member;
                $this->data['roles']  = $this->role_m->get_role(array('roleID', 'role'));
                $this->data['classes'] = $this->classe_m->get_classe(array('classeID', 'classe'));
                if ($_POST) {
                    $rules = $this->rules();
                    unset($rules['12']);
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == false) {
                        $this->data["subview"] = "member/edit";
                        $this->load->view('_main_layout', $this->data);
                    } else {
                        $array                 = [];
                        $array['name']         = $this->input->post('firstname') .' '.$this->input->post('lastname');
                        $array['firstname']    = $this->input->post('firstname');
                        $array['lastname']     = $this->input->post('lastname');
                        $array['code']         = uniqid("",false);
                        $array['dateofbirth']  = date('Y-m-d', strtotime($this->input->post('dateofbirth')));
                        $array['gender']       = $this->input->post('gender');
                        $array['email']        = $this->input->post('email');
                        $array['phone']        = $this->input->post('phone');
                        $array['address']      = $this->input->post('address');
                        $array['photo']        = $this->upload_data['file']['file_name'];
                        $array['roleID']       = $this->input->post('roleID');
                        $array['classeID']     = $this->input->post('classeID');
                        $array['placeofbirth'] = $this->input->post('placeofbirth');
                        $array['class_group']  = in_array($this->input->post('class_group'), $class_group) ? $this->input->post('class_group') : 'A';
                        $array['status']       = $this->input->post('status');
                        $array['username']     = $this->input->post('username');
                        if ($this->input->post('password') != '') {
                            $array['password'] = $this->password_hash($this->input->post('password'));
                        }
                        $array['modify_date']     = date('Y-m-d H:i:s');
                        $array['modify_memberID'] = $this->session->userdata('loginmemberID');
                        $array['modify_roleID']   = $this->session->userdata('roleID');
                        
                        if($test1 != 0 && $test2 != 0){
                            $this->session->set_flashdata('error', "This account cannot be update username. It has ".$test1." borrowed books");
                            redirect(base_url('member/index'));
                        }
                        else{
                            $this->member_m->update_member($array, $memberID);
                            $this->session->set_flashdata('success', 'Success');
                            redirect(base_url('member/index'));
                        }
                    }
                } else {
                    $this->data["subview"] = "member/edit";
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
        $memberID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $memberID) {
            $member = $this->member_m->get_single_member(array('memberID' => $memberID));
            if (calculate($member)) {
                $this->data['member']       = $member;
                $this->data['bookcategory'] = pluck($this->bookcategory_m->get_bookcategory(), 'name', 'bookcategoryID');
                $this->data['book']         = pluck($this->book_m->get_book(), 'name', 'bookID');
                $this->data['bookissues']   = $this->bookissue_m->get_order_by_bookissue(['deleted_at' => 0, 'memberID' => $memberID]);
                $this->data['role']         = $this->role_m->get_single_role(array('roleID' => $member->roleID));
                $this->data['classe']       = $this->classe_m->get_single_classe(array('classeID' => $member->classeID));
                $this->data["subview"]      = "member/view";
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
        $memberID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $memberID) {
            $member = $this->member_m->get_single_member(array('memberID' => $memberID));
            $bookissue = $this->bookissue_m->get_order_by_bookissue(['deleted_at' => 0, 'memberID' => $memberID]);
            $test = 0;
            foreach ($bookissue as $book){
                if( $book->status==0)
                   $test+=1;
            }
            if (calculate($member)) {
                if($test == 0){
                    $this->member_m->update_member(['deleted_at' => 1], $memberID);
                    $this->session->set_flashdata('success', 'Success');
                    redirect(base_url('member/index'));
                }
                else{
                    $this->session->set_flashdata('error', "This account cannot be deleted. It has ".$test." borrowed books",);
                    redirect(base_url('member/index'));
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

    public function import()
    {
        $gender         = array('Female', 'Male');
        $class_group    = array('A', 'B','C', 'D');

        if ($this->input->post('submit')) 
        {            
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
            if(empty($error)){
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
                    $i=0;

                    $membres_count = count($allDataInSheet) - 1;
                    $membres_error_count = 0;

                    foreach ($allDataInSheet as $value) {
                        if($flag){
                            $flag =false;
                            continue;
                        }

                        if (!$this->check_unique_email($value['F'])) {
                            $membres_error_count++;
                            continue;
                        }

                        if (!$this->check_unique_username($value['J'])) {
                            $membres_error_count++;
                            continue;
                        }

                        if (!$this->password_required_check($value['K'])) {
                            $membres_error_count++;
                            continue;
                        }

                        if ($value['A'] == '' || $value['B'] == '') {
                            $membres_error_count++;
                            continue;
                        }
                        
                        $inserdata[$i]['name']              = $value['A'].' '.$value['B'];
                        $inserdata[$i]['firstname']         = $value['A'];
                        $inserdata[$i]['lastname']          = $value['B'];
                        $inserdata[$i]['code']              = uniqid("",false);
                        $inserdata[$i]['dateofbirth']       = $value['C'];
                        $inserdata[$i]['placeofbirth']      = $value['D'];
                        $inserdata[$i]['gender']            = in_array($value['E'], $gender) ? $value['E'] : 'Male';
                        $inserdata[$i]['religion']          = 'islam';
                        $inserdata[$i]['email']             = $value['F'];
                        $inserdata[$i]['phone']             = $value['G'];
                        $inserdata[$i]['bloodgroup']        = '-';
                        $inserdata[$i]['address']           = $value['H'];
                        $inserdata[$i]['joinningdate']      = date('Y-m-d H:i:s');
                        $inserdata[$i]['photo']             = $value['I'] == '' ? 'default.png' : $value['I'];
                        $inserdata[$i]['username']          = $value['J'];
                        $inserdata[$i]['password']          = $this->password_hash($value['K']);
                        $inserdata[$i]['roleID']            = 3;
                        $inserdata[$i]['classeID']          = $value['L'];
                        $inserdata[$i]['class_group']       = in_array($value['M'], $class_group) ? $value['M'] : 'A';
                        $inserdata[$i]['status']            = '1';
                        $inserdata[$i]['deleted_at']        = 0;
                        $inserdata[$i]['create_date']       = date('Y-m-d H:i:s');
                        $i++;
                    } 

                $result = $this->member_m->import_member_batch($inserdata);

                if($result){
                    $membres_success = $membres_count - $membres_error_count;

                    $this->session->set_flashdata('success', $membres_success.'/'.$membres_count.' Books Success');

                    redirect('/member', '');
                }            
                
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                . '": ' .$e->getMessage());
                }
            }else{
                 $error['error'];
                 $this->session->set_flashdata('error', $error['error']);
            }
            redirect('/member', '');
        }
        redirect('/member', '');
    }

    private function rules()
    {
        $rules = array(
            array(
                'field' => 'firstname',
                'label' => $this->lang->line('member_firstname'),
                'rules' => 'trim|xss_clean|required|max_length[60]',
            ),
            array(
                'field' => 'lastname',
                'label' => $this->lang->line('member_lastname'),
                'rules' => 'trim|xss_clean|required|max_length[60]',
            ),
            array(
                'field' => 'dateofbirth',
                'label' => $this->lang->line('member_date_of_birth'),
                'rules' => 'trim|xss_clean|required|valid_date',
            ),
            array(
                'field' => 'gender',
                'label' => $this->lang->line('member_gender'),
                'rules' => 'trim|xss_clean|required|required_no_zero',
            ),
            // array(
            //     'field' => 'religion',
            //     'label' => $this->lang->line('member_religion'),
            //     'rules' => 'trim|xss_clean|required|max_length[30]',
            // ),
            array(
                'field' => 'email',
                'label' => $this->lang->line('member_email'),
                'rules' => 'trim|xss_clean|required|max_length[60]|valid_email|callback_check_unique_email',
            ),
            array(
                'field' => 'phone',
                'label' => $this->lang->line('member_phone'),
                'rules' => 'trim|xss_clean|required|max_length[15]',
            ),
            // array(
            //     'field' => 'bloodgroup',
            //     'label' => $this->lang->line('member_blood_group'),
            //     'rules' => 'trim|xss_clean|max_length[15]|required_no_zero',
            // ),
            // array(
            //     'field' => 'address',
            //     'label' => $this->lang->line('member_address'),
            //     'rules' => 'trim|xss_clean|required',
            // ),
            // array(
            //     'field' => 'joinningdate',
            //     'label' => $this->lang->line('member_joinning_date'),
            //     'rules' => 'trim|xss_clean|required|valid_date',
            // ),
            array(
                'field' => 'photo',
                'label' => $this->lang->line('member_photo'),
                'rules' => 'trim|xss_clean|max_length[200]|callback_photo_upload',
            ),
            array(
                'field' => 'status',
                'label' => $this->lang->line('member_status'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero',
            ),
            array(
                'field' => 'roleID',
                'label' => $this->lang->line('member_role'),
                'rules' => 'trim|xss_clean|required|numeric|required_no_zero',
            ),
            array(
                'field' => 'username',
                'label' => $this->lang->line('member_username'),
                'rules' => 'trim|xss_clean|required|min_length[4]|max_length[60]|valid_username|callback_check_unique_username',
            ),
            array(
                'field' => 'password',
                'label' => $this->lang->line('member_password'),
                'rules' => 'trim|xss_clean|max_length[128]|callback_password_required_check',
            ),
        );
        return $rules;
    }

    public function photo_upload()
    {
        $memberID = htmlentities(escapeString($this->uri->segment(3)));
        $member   = array();
        if ((int) $memberID) {
            $member = $this->member_m->get_single_member(array('memberID' => $memberID));
        }

        $new_file = "default.png";
        if ($_FILES["photo"]['name'] != "") {
            $file_name        = $_FILES["photo"]['name'];
            $random           = rand(1, 10000000000000000);
            $file_name_rename = hash('sha512', $random . $this->input->post('username') . config_item("encryption_key"));
            $explode          = explode('.', $file_name);
            if (calculate($explode) >= 2) {
                $new_file                = $file_name_rename . '.' . end($explode);
                $config['upload_path']   = "./uploads/member";
                $config['allowed_types'] = "gif|jpg|png";
                $config['file_name']     = $new_file;
                $config['max_size']      = '2048';
                $config['max_width']     = '2000';
                $config['max_height']    = '2000';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload("photo")) {
                    $this->form_validation->set_message("photo_upload", $this->upload->display_errors());
                    return false;
                } else {
                    $this->upload_data['file'] = $this->upload->data();
                    return true;
                }
            } else {
                $this->form_validation->set_message("photo_upload", "Invalid file");
                return false;
            }
        } else {
            if (calculate($member)) {
                $this->upload_data['file'] = array('file_name' => $member->photo);
                return true;
            } else {
                $this->upload_data['file'] = array('file_name' => $new_file);
                return true;
            }
        }
    }

    public function check_unique_email($email)
    {
        $memberID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $memberID) {
            $member = $this->member_m->get_single_member(array('email' => $email, 'memberID !=' => $memberID));
            if (calculate($member)) {
                $this->form_validation->set_message("check_unique_email", "The %s is already exits.");
                return false;
            }
            return true;
        } else {
            $member = $this->member_m->get_single_member(array('email' => $email));
            if (calculate($member)) {
                $this->form_validation->set_message("check_unique_email", "The %s is already exits.");
                return false;
            }
            return true;
        }
    }

    public function check_unique_username($username)
    {
        $memberID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $memberID) {
            $member = $this->member_m->get_single_member(array('username' => $username, 'memberID !=' => $memberID));
            if (calculate($member)) {
                $this->form_validation->set_message("check_unique_username", "The %s is already exits.");
                return false;
            }
            return true;
        } else {
            $member = $this->member_m->get_single_member(array('username' => $username));
            if (calculate($member)) {
                $this->form_validation->set_message("check_unique_username", "The %s is already exits.");
                return false;
            }
            return true;
        }
    }

    public function password_required_check($password)
    {
        $memberID = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $memberID) {
            return true;
        } else {
            if ($password == '') {
                $this->form_validation->set_message("password_required_check", "The %s is already exits.");
                return false;
            }
            return true;
        }
    }

}
