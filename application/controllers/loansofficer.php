<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class loansofficer extends CI_Controller
{
    
    
	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
		
       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
    }
    
    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('loansofficer_login') == 1)
            redirect(base_url() . 'index.php?loansofficer/dashboard', 'refresh');
    }
    
    /***ADMIN DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/index', $page_data);
    }
    
    /****MANAGE STUDENTS CLASSWISE*****/
	function loan_client_add()
	{
		if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url(), 'refresh');
			
		$page_data['page_name']  = 'loan_client_add';
		$page_data['page_title'] = get_phrase('Register');
		$this->load->view('backend/index', $page_data);
	}
	
	
	function loan_client_information()
	{
		if ($this->session->userdata('loansofficer_login') != 1)
            redirect('login', 'refresh');
			
		$page_data['page_name']  	= 'loan_client_information';
		$page_data['page_title'] 	= get_phrase('Clients_information');
											
		$page_data['class_id'] 	= $class_id;
		$this->load->view('backend/index', $page_data);
	}

 

    function loan_client($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['name']       = $this->input->post('name');
            $data['birthday']   = $this->input->post('birthday');
            $data['sex']        = $this->input->post('sex');
            $data['address']    = $this->input->post('address');
            $data['phone']      = $this->input->post('phone');
			$data['phone2']      = $this->input->post('phone2');
            $data['email']      = $this->input->post('email');
            $data['password']   = $this->input->post('password');
            $data['branch_id']   = $this->input->post('branch_id');
            $data['nationalid']  = $this->input->post('nationalid');
            $this->db->insert('loan_clients', $data);
            $student_id = $this->db->insert_id();
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $student_id . '.jpg');
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            $this->email_model->account_opening_email('student', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
             redirect(base_url() . 'index.php?loansofficer/loan_client_information/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']       = $this->input->post('name');
            $data['birthday']   = $this->input->post('birthday');
            $data['sex']        = $this->input->post('sex');
            $data['address']    = $this->input->post('address');
            $data['phone']      = $this->input->post('phone');
			$data['phone2']      = $this->input->post('phone2');
            $data['email']      = $this->input->post('email');
            $data['password']   = $this->input->post('password');
            $data['branch_id']   = $this->input->post('branch_id');
            $data['nationalid']       = $this->input->post('nationalid');
            
            $this->db->where('student_id', $param2);
            $this->db->update('loan_clients', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $param3 . '.jpg');
            $this->crud_model->clear_cache();
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?loansofficer/loan_client_information/', 'refresh');
        } 
		
        if ($param1 == 'delete') {
            $this->db->where('student_id', $param2);
            $this->db->delete('loan_clients');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?loansofficer/loan_client_information/' , 'refresh');
        }
    }
	
	 
 
    function loan_officer($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']        = $this->input->post('name');
            $data['birthday']    = $this->input->post('birthday');
            $data['sex']         = $this->input->post('sex');
			$data['branch_id']   = $this->input->post('branch_id');
            $data['address']     = $this->input->post('address');
            $data['phone']       = $this->input->post('phone');
            $data['email']       = $this->input->post('email');
            $data['password']    = $this->input->post('password');
            $this->db->insert('loan_officer', $data);
            $teacher_id = $this->db->insert_id();
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $teacher_id . '.jpg');
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            $this->email_model->account_opening_email('teacher', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            redirect(base_url() . 'index.php?loansofficer/loan_officer/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']        = $this->input->post('name');
            $data['birthday']    = $this->input->post('birthday');
            $data['sex']         = $this->input->post('sex');
			$data['branch_id']   = $this->input->post('branch_id');
            $data['address']     = $this->input->post('address');
            $data['phone']       = $this->input->post('phone');
            $data['email']       = $this->input->post('email');
            
            $this->db->where('teacher_id', $param2);
            $this->db->update('loan_officer', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $param2 . '.jpg');
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?loansofficer/loan_officer/', 'refresh');
        } else if ($param1 == 'personal_profile') {
            $page_data['personal_profile']   = true;
            $page_data['current_teacher_id'] = $param2;
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('loan_officer', array(
                'teacher_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('teacher_id', $param2);
            $this->db->delete('loan_officer');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?loansofficer/loan_officer/', 'refresh');
        }
        $page_data['teachers']   = $this->db->get('loan_officer')->result_array();
        $page_data['page_name']  = 'loan_officer';
        $page_data['page_title'] = get_phrase('manage_loan_officers');
        $this->load->view('backend/index', $page_data);
    }
	
	
	
	     /****MANAGE LOAN SETTINGS*****/
    function loan_settings($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url(), 'refresh');
        
		$page_data['classes']    = $this->db->get('loan_types')->result_array();
		$page_data['branches']    = $this->db->get('loan_branch')->result_array();
		$page_data['paymentmodes']    = $this->db->get('loan_paymentmodes')->result_array();
		$page_data['propertyconditions']    = $this->db->get('loan_property_conditions')->result_array();
		$page_data['generalnterest']    = $this->db->get('loan_interest_rates')->result_array();
        $page_data['page_name']  = 'loan_settings';
        $page_data['page_title'] = get_phrase('manage_loan_settings');
        $this->load->view('backend/index', $page_data);
    }
	
	
     /****MANAGE LOAN TYPES*****/
    function loan_settings_loan_types($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']         = $this->input->post('name');
            
           
            $this->db->insert('loan_types', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?loansofficer/loan_settings_loan_types/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']         = $this->input->post('name');
            
            $this->db->where('class_id', $param2);
            $this->db->update('loan_types', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?loansofficer/loan_settings_loan_types/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('loan_types', array(
                'class_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('class_id', $param2);
            $this->db->delete('loan_types');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?loansofficer/loan_settings_loan_types/', 'refresh');
        }
        $page_data['classes']    = $this->db->get('loan_types')->result_array();
        $page_data['page_name']  = 'loan_settings_loan_types';
        $page_data['page_title'] = get_phrase('manage_loan_types');
        $this->load->view('backend/index', $page_data);
    }
	
	
	     /****MANAGE BRANCHES*****/
    function loan_settings_branches($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']         = $this->input->post('name');
            
           
            $this->db->insert('loan_branch', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?loansofficer/loan_settings_branches/', 'refresh');
			//redirect(base_url() . 'index.php?loansofficer/parent/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']         = $this->input->post('name');
            
            $this->db->where('branch_id', $param2);
            $this->db->update('loan_branch', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?loansofficer/loan_settings_branches/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('loan_branch', array(
                'branch_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('branch_id', $param2);
            $this->db->delete('loan_branch');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?loansofficer/loan_settings_branches/', 'refresh');
        }
        $page_data['branches']    = $this->db->get('loan_branch')->result_array();
        $page_data['page_name']  = 'loan_settings_branches';
        $page_data['page_title'] = get_phrase('manage_branches');
        $this->load->view('backend/index', $page_data);
    }
	
	     /****MANAGE PAYMENTMODES*****/
    function loan_settings_paymentmodes($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']         = $this->input->post('name');
            
           
            $this->db->insert('loan_paymentmodes', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?loansofficer/loan_settings_paymentmodes/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']         = $this->input->post('name');
            
            $this->db->where('paymentmodes_id', $param2);
            $this->db->update('loan_paymentmodes', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?loansofficer/loan_settings_paymentmodes/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('loan_paymentmodes', array(
                'paymentmodes_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('paymentmodes_id', $param2);
            $this->db->delete('loan_paymentmodes');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?loansofficer/loan_settings_paymentmodes/', 'refresh');
        }
        $page_data['paymentmodes']    = $this->db->get('loan_paymentmodes')->result_array();
        $page_data['page_name']  = 'loan_settings_paymentmodes';
        $page_data['page_title'] = get_phrase('loan_payment_methods');
        $this->load->view('backend/index', $page_data);
    }
	
	
	     /****MANAGE PROPERTYCONDITION*****/
    function loan_settings_propertycondtion($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']         = $this->input->post('name');
            
           
            $this->db->insert('loan_property_conditions', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?loansofficer/loan_settings_propertycondtion/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']         = $this->input->post('name');
            
            $this->db->where('condition_id', $param2);
            $this->db->update('loan_property_conditions', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?loansofficer/loan_settings_propertycondtion/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('loan_property_conditions', array(
                'condition_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('condition_id', $param2);
            $this->db->delete('loan_property_conditions');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?loansofficer/loan_settings_propertycondtion/', 'refresh');
        }
        $page_data['propertyconditions']    = $this->db->get('loan_property_conditions')->result_array();
        $page_data['page_name']  = 'loan_settings_propertycondtion';
        $page_data['page_title'] = get_phrase('accepted_property_conditions');
        $this->load->view('backend/index', $page_data);
    }
	
	
	     /****MANAGE INTERSET*****/
    function loan_settings_generalnterest($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']         = $this->input->post('name');
            
           
            $this->db->insert('loan_interest_rates', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?loansofficer/loan_settings_generalnterest/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']         = $this->input->post('name');
             $param2         = $this->input->post('interest_id');
            $this->db->where('interest_id', $param2);
            $this->db->update('loan_interest_rates', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?loansofficer/loan_settings_generalnterest/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('loan_interest_rates', array(
                'interest_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('interest_id', $param2);
            $this->db->delete('loan_interest_rates');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?loansofficer/loan_settings_generalnterest/', 'refresh');
        }
        $page_data['generalnterest']    = $this->db->get('loan_interest_rates')->result_array();
        $page_data['page_name']  = 'loan_settings_generalnterest';
        $page_data['page_title'] = get_phrase('accepted_interest_rates');
        $this->load->view('backend/index', $page_data);
    }
	
	
	/****MANAGE SESSION HERE *****/
    function session($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']         = $this->input->post('name');
            $this->db->insert('session', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?loansofficer/session', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']         = $this->input->post('name');
            
            $this->db->where('session_id', $param2);
            $this->db->update('session', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?loansofficer/session', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('session', array(
                'session_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('session_id', $param2);
            $this->db->delete('session');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?loansofficer/session', 'refresh');
        }
        $page_data['sessions']    = $this->db->get('session')->result_array();
        $page_data['page_name']  = 'session';
        $page_data['page_title'] = get_phrase('manage_session');
        $this->load->view('backend/index', $page_data);
    }
	
	
	/**********MANAGE LOANS *******************/
    function loan_manage_newapplication($param1 = '', $param2 = '' , $param3 = '')
    {
       if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url(), 'refresh');
       
	 /*  if ($param1 == 'create') {
		    $data['staff_name']     	    = $this->input->post('staff_name');
            $data['amount']        	 	= $this->input->post('amount');
            $data['purpose']    	  	= $this->input->post('purpose');
            $data['l_duration']       	= $this->input->post('totalmonths');
			$data['interest']       	= $this->input->post('intereset');
            $data['mop']       			= ($this->input->post('mop')==1)?"Daily":"weekly";			
			$data['amount_winterest']   = $this->input->post('total_paid');
			$data['dailypay']       	= $this->input->post('emi_per_month');
			$data['branch_id']       	= $this->input->post('branch_id');
			
			$data['g_name']     		= $this->input->post('g_name');
            $data['g_relationship']     = $this->input->post('g_relationship');
            $data['g_number']     		= $this->input->post('g_number');
			
			$data['g_address']     		= $this->input->post('g_address');
            $data['g_country']         	= $this->input->post('g_country');
            $data['c_name']     		= $this->input->post('c_name');
			
			$data['c_type']     		= $this->input->post('c_type');
            $data['model']         		= $this->input->post('model');
            $data['make']     			= $this->input->post('make');
			
			$data['serial_number']     	= $this->input->post('serial_number');
            $data['value']   			= $this->input->post('value');
            $data['condition']     		= $this->input->post('condition');
			$data['date']         		= $this->input->post('date');
            $data['status']     		= $this->input->post('status');
			 $data['loantype']     		= $this->input->post('loantype');
			$data['creator']            = $this->session->userdata('name');
            $this->db->insert('loan', $data);
            //$assignment_id = $this->db->insert_id();
			
            $ext= end(explode(".",$_FILES["file_name"]["name"]));
			$data['file_name'] 			= h_generate_id($_FILES["file_name"]["name"]).".$ext";			
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/loan_applicant/" . h_generate_id($_FILES["file_name"]["name"]).".$ext");
			
			$this->session->set_flashdata('flash_message' , get_phrase('loan_application_submitted_successfully'));
            redirect(base_url() . 'index.php?loansofficer/loan_manage_newapplication' , 'refresh');
        }

		 */
		 if ($param1 == 'create') {
		    $data['staff_name']     	    = $this->input->post('staff_name');
            $data['amount']        	 	= $this->input->post('amount');
            $data['purpose']    	  	= $this->input->post('purpose');
            $data['l_duration']       	= $this->input->post('totalmonths');
			$data['interest']       	= $this->input->post('intereset');
            $data['mop']       			= ($this->input->post('mop')==1)?"Daily":"weekly";			
			$data['amount_winterest']   = $this->input->post('total_paid');
			$data['dailypay']       	= $this->input->post('emi_per_month');
			$data['branch_id']       	= $this->input->post('branch_id');
			
			$data['g_name']     		= $this->input->post('g_name');
            $data['g_relationship']     = $this->input->post('g_relationship');
            $data['g_number']     		= $this->input->post('g_number');
			
			$data['g_address']     		= $this->input->post('g_address');
            $data['g_country']         	= $this->input->post('g_country');
			
         /* $data['c_name']     		= $this->input->post('c_name');			
			$data['c_type']     		= $this->input->post('c_type');
            $data['model']         		= $this->input->post('model');
            $data['make']     			= $this->input->post('make');			
			$data['serial_number']     	= $this->input->post('serial_number');
            $data['value']   			= $this->input->post('value');
            $data['condition']     		= $this->input->post('condition');
			*/
			$data['date']         		= $this->input->post('date');
            $data['status']     		= $this->input->post('status');
			$data['loantype']     		= $this->input->post('loantype');
			$data['creator']            = $this->session->userdata('name');
            $this->db->insert('loan', $data);
            $loan_id	= $this->db->insert_id();	
		   
			$data2['client_id']  		= $this->input->post('staff_name');
			$data2['branch_id']       	= $this->input->post('branch_id');
			$data2['c_type']     		= $this->input->post('c_type');
			$data2['loan_id']			= $loan_id;		
			$data2['c_name']     		= $this->input->post('c_name');
            $data2['model']         	= $this->input->post('model');
            $data2['make']     			= $this->input->post('make');			
			$data2['serial_number']     = $this->input->post('serial_number');
            $data2['value']   			= $this->input->post('value');
            $data2['condition']     	= $this->input->post('condition');
			$data2['date']         		= $this->input->post('date');
            $data2['status']     		= $this->input->post('status');
			$data2['creator']           = $this->session->userdata('name');
			$ext= end(explode(".",$_FILES["file_name"]["name"]));
			
			$data2['file_name'] 			=!empty($_FILES["file_name"]["name"])? h_generate_id($_FILES["file_name"]["name"]).".$ext":$_FILES["file_name"]["name"];			
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/loan_applicant/" . h_generate_id($_FILES["file_name"]["name"]).".$ext");
			 
			$this->db->insert('loan_collateral', $data2);
			 
			 
			$this->session->set_flashdata('flash_message' , get_phrase('loan_application_submitted_successfully'));
             redirect(base_url() . 'index.php?loansofficer/loan_manage_newapplication' , 'refresh');
        }
		
		
        $page_data['page_name']  = 'loan_manage_newapplication';
        $page_data['page_title'] = get_phrase('manage_loan_applicants');
        $page_data['loan_applicants']  = $this->db->get('loan')->result_array();
        $this->load->view('backend/index', $page_data);
    }
	
		
	
	function loan_manage_approveloans_details($param1 = '' , $param2 = '' , $param3 = '', $param4 = '')
	{

        if ($this->session->userdata('loansofficer_login') != 1)
            redirect('login', 'refresh');
		
		
		
		if ($param1 == 'save_collateral') {
            
			 if ($this->input->post('action')== 0){
			//$action     	        = $this->input->post('action');
			$data['client_id']     	= $this->input->post('staff_name');
            $data['c_name']     		= $this->input->post('c_name');
			$data['loan_id']     		= $this->input->post('loan_id');
			$loan_id     		        = $this->input->post('loan_id');
			$data['c_type']     		= $this->input->post('c_type');
            $data['model']         		= $this->input->post('model');
            $data['make']     			= $this->input->post('make');
			
			$data['serial_number']     	= $this->input->post('serial_number');
            $data['value']   			= $this->input->post('value');
            $data['condition']     		= $this->input->post('condition');
			$data['date']         		= $this->input->post('date');
            $data['status']     		= $this->input->post('status');
			$data['creator']            = $this->session->userdata('name');			
			$ext= end(explode(".",$_FILES["file_name"]["name"]));
			
			$data['file_name'] 			=!empty($_FILES["file_name"]["name"])? h_generate_id($_FILES["file_name"]["name"]).".$ext":$_FILES["file_name"]["name"];			
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/loan_applicant/" . h_generate_id($_FILES["file_name"]["name"]).".$ext");
			 
			 $this->db->insert('loan_collateral', $data);}
			 else {
			$data['client_id']     	= $this->input->post('staff_name');
            $data['c_name']     		= $this->input->post('c_name');
			$data['loan_id']     		= $this->input->post('loan_id');
			$loan_id     		        = $this->input->post('loan_id');
			$data['c_type']     		= $this->input->post('c_type');
            $data['model']         		= $this->input->post('model');
            $data['make']     			= $this->input->post('make');			
			$data['serial_number']     	= $this->input->post('serial_number');
            $data['value']   			= $this->input->post('value');
            $data['condition']     		= $this->input->post('condition');
			$data['date']         		= $this->input->post('date');
            $data['status']     		= $this->input->post('status');
			$data['creator']            = $this->session->userdata('name');	
			$ext= end(explode(".",$_FILES["file_name"]["name"]));
					
            if(!empty($_FILES["file_name"]["name"])){
			$data['file_name'] 			= h_generate_id($_FILES["file_name"]["name"]).".$ext";	
			 
			 }		
            
			  
			move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/loan_applicant/" . h_generate_id($_FILES["file_name"]["name"]).".$ext");
			 
			
            $this->db->where('collateral_id', $this->input->post('action'));
			$this->db->update('loan_collateral', $data);
			
			}
			$this->session->set_flashdata('flash_message' , get_phrase('data_updated_successfully'));
            redirect(base_url() . 'index.php?loansofficer/loan_manage_approveloans_details/'.$loan_id, 'refresh');
			}
			
			
			if ($param1 == 'delete') {
				
				if ($param2 == 'collateral') {
                $this->db->where('collateral_id' , $param3);
				$this->db->delete('loan_collateral');
				}
				
				if ($param2 == 'removefile') {
				$data['file_name']     = "";
                $this->db->where('collateral_id' , $param3);
				$this->db->update('loan_collateral', $data);
				}
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?loansofficer/loan_manage_approveloans_details/'.$param4, 'refresh');
        }
		
		//$this->db->query('SELECT * FROM loan_collateral where file_name!=""')->result_array();

        $page_data['page_name']  = 'loan_manage_approveloans_details';
        $page_data['page_title'] = get_phrase('loan_details');
		$page_data['client_id'] = $this->db->get_where('loan' , array('loan_id' => $param1))->row()->staff_name;
		$page_data['collateral_data'] = $this->db->get_where('loan_collateral' , array('loan_id' => $param1))->result_array();
        $page_data['collateral_files'] = $this->db->query('SELECT * FROM loan_collateral where loan_id="'.$param1.'" and file_name!=""')->result_array();
        $page_data['loan_data'] = $this->db->get_where('loan' , array('loan_id' => $param1))->result_array();
        
		$this->load->view('backend/index', $page_data); 
    
	
	}
	
	
	function loan_manage_approveloans_detailsalloans($param1 = '' , $param2 = '' , $param3 = '', $param4 = '')
	{
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect('login', 'refresh');
		
		$page_data['page_name']  = 'loan_manage_approveloans_detailsalloans';
        $page_data['page_title'] = get_phrase('loan_details');
		 // $this->db->get_where('loan' , array('loan_id' => $param1))->result_array();
        $page_data['loan_data']= $this->db->get_where('loan_clients' , array('student_id'=>$param1))->result_array();
		$this->load->view('backend/index', $page_data); 
	}
	
	
    
    function loan_manage_approveloans($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
			$data['staff_name']     	= $this->input->post('staff_name');
            $data['amount']        	 	= $this->input->post('amount');
            $data['purpose']    	  	= $this->input->post('purpose');
            $data['l_duration']       	= $this->input->post('totalmonths');
			$data['interest']       	= $this->input->post('intereset');
            $data['mop']       			= ($this->input->post('mop')==1)?"Daily":"weekly";			
			$data['amount_winterest']   = $this->input->post('total_paid');
			$data['dailypay']       	= $this->input->post('emi_per_month');
			$data['due']       	        = $this->input->post('total_paid');
			
			$data['g_name']     		= $this->input->post('g_name');
            $data['g_relationship']     = $this->input->post('g_relationship');
            $data['g_number']     		= $this->input->post('g_number');
			
			$data['g_address']     		= $this->input->post('g_address');
            $data['g_country']         	= $this->input->post('g_country');
            $data['c_name']     		= $this->input->post('c_name');
			
			$data['c_type']     		= $this->input->post('c_type');
            $data['model']         		= $this->input->post('model');
            $data['make']     			= $this->input->post('make');
			
			$data['serial_number']     	= $this->input->post('serial_number');
            $data['value']   			= $this->input->post('value');
            $data['condition']     		= $this->input->post('condition');
			$data['date']         		= $this->input->post('date');
            $data['status']     		= $this->input->post('status');
			 $data['loantype']     		= $this->input->post('loantype');
			$data['creator']            = $this->session->userdata('name');
            $this->db->insert('loan', $data);
            $assignment_id = $this->db->insert_id();
			$ext= end(explode(".",$_FILES["file_name"]["name"]));
			$data['file_name'] 			= h_generate_id($_FILES["file_name"]["name"]).".$ext";			
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/loan_applicant/" . h_generate_id($_FILES["file_name"]["name"]).".$ext");
			$this->session->set_flashdata('flash_message' , get_phrase('loan_application_submitted_successfully'));
            redirect(base_url() . 'index.php?loansofficer/loan_manage_approveloans' , 'refresh');
        }
		
		if ($param1 == 'changeamount') {
			$data['due']       	        = $this->input->post('due');
			if($this->input->post('due')==0){
			$data['status']     		= "finished";}
			$this->db->where('loan_id', $param2);
            $this->db->update('loan', $data);
			 redirect(base_url() . 'index.php?loansofficer/loan_manage_approveloans_details/'.$param2, 'refresh');
		}
		if ($param1 == 'do_update') {
            
			$data['staff_name']     	= $this->input->post('staff_name');
            $data['amount']        	 	= $this->input->post('amount');
            $data['purpose']    	  	= $this->input->post('purpose');
            $data['l_duration']       	= $this->input->post('totalmonths');
			$data['interest']       	= $this->input->post('intereset');            
			$data['mop']       			= ($this->input->post('mop')==1)?"Daily":"weekly";			
			$data['amount_winterest']   = $this->input->post('total_paid');
			$data['dailypay']       	= $this->input->post('emi_per_month');
			$data['due']       	        = $this->input->post('total_paid');
			$data['g_name']     		= $this->input->post('g_name');
            $data['g_relationship']     = $this->input->post('g_relationship');
            $data['g_number']     		= $this->input->post('g_number');
			$data['branch_id']       	= $this->input->post('branch_id');
			$data['g_address']     		= $this->input->post('g_address');
            $data['g_country']         	= $this->input->post('g_country');
			
           /* $data['c_name']     		= $this->input->post('c_name');			
			$data['c_type']     		= $this->input->post('c_type');
            $data['model']         		= $this->input->post('model');
            $data['make']     			= $this->input->post('make');			
			$data['serial_number']     	= $this->input->post('serial_number');
            $data['value']   			= $this->input->post('value');
            $data['condition']     		= $this->input->post('condition'); 
			*/
			
			$data['date']         		= $this->input->post('date');
            $data['status']     		= $this->input->post('status');
			$data['loantype']     		= $this->input->post('loantype');
            $data['creator']            = $this->session->userdata('name');
			$data['starting_date']     = $this->input->post('starting_date');
			$data['maturity_date']     = $this->input->post('maturity_date');
			
			//$data['file_name'] 			= $_FILES["file_name"]["name"];
			$ext= end(explode(".",$_FILES["file_name"]["name"]));
			$data['file_name'] 			= h_generate_id($_FILES["file_name"]["name"]).".$ext";			
            move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/loan_applicant/" . h_generate_id($_FILES["file_name"]["name"]).".$ext");
			
            $this->db->where('loan_id', $param2);
            $this->db->update('loan', $data);
			 $this->session->set_flashdata('flash_message' , get_phrase('data_updated_successfully'));
            redirect(base_url() . 'index.php?loansofficer/loan_manage_approveloans', 'refresh');
			}
			
       if ($param1 == 'delete') {
            $this->db->where('loan_id' , $param2);
            $this->db->delete('loan');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?loansofficer/loan_manage_approveloans' , 'refresh');
        }
		
		
		
		
		
		
        $page_data['page_name']  = 'loan_manage_approveloans';
        $page_data['page_title'] = get_phrase('manage_loan_approval');
        //$page_data['loan_approvals']  = $this->db->get('loan')->result_array();
		$page_data['loan_approvals']  = $this->db->query('SELECT * FROM loan WHERE status = "verifying" OR status = "Approved" OR status = "Pending" ORDER BY status desc')->result_array();
        
        $this->load->view('backend/index', $page_data);
    }
	
	
	function loan_manage_makepayments_files($param1 = '' , $param2 = '')
    {
       if ($this->session->userdata('loansofficer_login') != 1)
            redirect('login', 'refresh');
		  $page_data['page_name']  = 'loan_manage_makepayments_files';
        $page_data['page_title'] = get_phrase('make_loan_payments');
        //$page_data['loan_approvals']  = $this->db->get('loan')->result_array();
		$page_data['loan_approvals']  = $this->db->query('SELECT * FROM loan WHERE status = "finished" OR status = "running" ORDER BY status desc')->result_array();
        
        $this->load->view('backend/index', $page_data);
    }
	
	
	
	function loan_manage_makepayments_veiw($param1 = '' , $param2 = '' , $param3 = '') 
	{

        if ($this->session->userdata('loansofficer_login') != 1)
            redirect('login', 'refresh');
        $page_data['page_name']  = 'loan_manage_makepayments_veiw';
        $page_data['page_title'] = get_phrase('loan_payment');
		$page_data['loan_data'] = $this->db->get_where('loan' , array('loan_id' => $param1))->result_array();
        $this->load->view('backend/index', $page_data); 
    }


	
	function loan_manage_makepayments($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($param1 == 'create') {
            $data['student_id']         = $this->input->post('staff_name');
            $data['title']              = $this->input->post('title');
            $data['description']        = $this->input->post('description');
            $data['amount']             = $this->input->post('amount');
            $data['amount_paid']        = $this->input->post('amount_paid');
            $data['due']                = $data['amount'] - $data['amount_paid'];
            $data['status']             = $this->input->post('status');
			$data['branch_id']          = $this->input->post('branch_id');
			$data['loan_id']            = $this->input->post('loan_id');
			$loan_id                    = $this->input->post('loan_id');
			$dueamount                  = $data['amount'] - $data['amount_paid'];
			$status                     = $this->input->post('status');
			$data['creator']            = $this->session->userdata('name');
            $data['creation_timestamp'] = $this->input->post('date');
            		
            $this->db->insert('loan_invoice', $data);
            $invoice_id = $this->db->insert_id();			
			$this->db->update('loan', array('due' => $dueamount,'status'=> $status), array('loan_id' => $loan_id));
			
            $data2['invoice_id']        =   $invoice_id;
            $data2['student_id']        =   $this->input->post('staff_name');
            $data2['title']             =   $this->input->post('title');
            $data2['description']       =   $this->input->post('description');
            $data2['payment_type']      =  'income';
            $data2['method']            =   $this->input->post('method');
            $data2['amount']            =   $this->input->post('amount_paid');
			$data2['branch_id']             = $this->input->post('branch_id');
            $data2['timestamp']         =   $this->input->post('date');
            $data2['loan_id']           = $this->input->post('loan_id');
			$data2['creator']            = $this->session->userdata('name');
            $this->db->insert('loan_payment' , $data2);

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?loansofficer/loan_manage_makepayments_veiw/'.$loan_id, 'refresh');
        }

    }

  
    function loan_manage_historypayments($param1 = '' , $param2 = '')
    {
       if ($this->session->userdata('loansofficer_login') != 1)
            redirect('login', 'refresh');
		
		if ($param1 == 'delete') {
            $this->db->where('invoice_id', $param2);
            $this->db->delete('loan_invoice');
			$this->db->where('invoice_id', $param2);
			$this->db->delete('loan_payment');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?loansofficer/loan_manage_historypayments', 'refresh');
        }
		
		
        $page_data['page_name']  = 'loan_manage_historypayments';
        $page_data['page_title'] = get_phrase('loan payment history');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('loan_invoice')->result_array();
		$page_data['loan_approvals']  = $this->db->query('SELECT * FROM loan WHERE status = "finished" OR status = "running" ORDER BY status desc')->result_array();

        $this->load->view('backend/index', $page_data); 
    }

 

  /***MANAGE EVENT / NOTICEBOARD, WILL BE SEEN BY ALL ACCOUNTS DASHBOARD**/
    function noticeboard($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($param1 == 'create') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->insert('noticeboard', $data);

            $check_sms_send = $this->input->post('check_sms');

            if ($check_sms_send == 1) {
                // sms sending configurations

                $parents  = $this->db->get('parent')->result_array();
                $students = $this->db->get('loan_clients')->result_array();
                $teachers = $this->db->get('loan_officer')->result_array();
                $date     = $this->input->post('create_timestamp');
                $message  = $data['notice_title'] . ' ';
                $message .= get_phrase('on') . ' ' . $date;
                foreach($parents as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($students as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($teachers as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
            }

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?loansofficer/noticeboard/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', $data);

            $check_sms_send = $this->input->post('check_sms');

            if ($check_sms_send == 1) {
                // sms sending configurations

                $parents  = $this->db->get('parent')->result_array();
                $students = $this->db->get('loan_clients')->result_array();
                $teachers = $this->db->get('loan_officer')->result_array();
                $date     = $this->input->post('create_timestamp');
                $message  = $data['notice_title'] . ' ';
                $message .= get_phrase('on') . ' ' . $date;
                foreach($parents as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($students as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($teachers as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
            }

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?loansofficer/noticeboard/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('noticeboard', array(
                'notice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('notice_id', $param2);
            $this->db->delete('noticeboard');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?loansofficer/noticeboard/', 'refresh');
        }
        $page_data['page_name']  = 'noticeboard';
        $page_data['page_title'] = get_phrase('manage_noticeboard');
        $page_data['notices']    = $this->db->get('noticeboard')->result_array();
        $this->load->view('backend/index', $page_data);
    }
    
    /* private messaging */

     function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('loansofficer_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?loansofficer/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?loansofficer/message/message_read/' . $param2, 'refresh');
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name']   = $param1;
        $page_data['page_name']                 = 'message';
        $page_data['page_title']                = get_phrase('private_messaging');
        $this->load->view('backend/index', $page_data);
    }


    
    /*****SITE/SYSTEM SETTINGS*********/
    function system_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        
        if ($param1 == 'do_update') {
			 
            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_title');
            $this->db->where('type' , 'system_title');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('address');
            $this->db->where('type' , 'address');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('phone');
            $this->db->where('type' , 'phone');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('paypal_email');
            $this->db->where('type' , 'paypal_email');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('currency');
            $this->db->where('type' , 'currency');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_email');
            $this->db->where('type' , 'system_email');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('language');
            $this->db->where('type' , 'language');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('text_align');
            $this->db->where('type' , 'text_align');
            $this->db->update('settings' , $data);
			
			$data['description'] = $this->input->post('running_session');
            $this->db->where('type' , 'session');
            $this->db->update('settings' , $data);
			
			$data['description'] = $this->input->post('system_footer');
            $this->db->where('type' , 'footer');
            $this->db->update('settings' , $data);
			
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated')); 
            redirect(base_url() . 'index.php?loansofficer/system_settings', 'refresh');
        }
        if ($param1 == 'upload_logo') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?loansofficer/system_settings', 'refresh');
        }
        if ($param1 == 'change_skin') {
            $data['description'] = $param2;
            $this->db->where('type' , 'skin_colour');
            $this->db->update('settings' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('theme_selected')); 
            redirect(base_url() . 'index.php?loansofficer/system_settings', 'refresh'); 
        }
        $page_data['page_name']  = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }
	
	/***** UPDATE PRODUCT *****/
	
	function update( $task = '', $purchase_code = '' ) {
        
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url(), 'refresh');
            
        // Create update directory.
        $dir    = 'update';
        if ( !is_dir($dir) )
            mkdir($dir, 0777, true);
        
        $zipped_file_name   = $_FILES["file_name"]["name"];
        $path               = 'update/' . $zipped_file_name;
        
        move_uploaded_file($_FILES["file_name"]["tmp_name"], $path);
        
        // Unzip uploaded update file and remove zip file.
        $zip = new ZipArchive;
        $res = $zip->open($path);
        if ($res === TRUE) {
            $zip->extractTo('update');
            $zip->close();
            unlink($path);
        }
        
        $unzipped_file_name = substr($zipped_file_name, 0, -4);
        $str                = file_get_contents('./update/' . $unzipped_file_name . '/update_config.json');
        $json               = json_decode($str, true);
        

			
		// Run php modifications
		require './update/' . $unzipped_file_name . '/update_script.php';
        
        // Create new directories.
        if(!empty($json['directory'])) {
            foreach($json['directory'] as $directory) {
                if ( !is_dir( $directory['name']) )
                    mkdir( $directory['name'], 0777, true );
            }
        }
        
        // Create/Replace new files.
        if(!empty($json['files'])) {
            foreach($json['files'] as $file)
                copy($file['root_directory'], $file['update_directory']);
        }
        
        $this->session->set_flashdata('flash_message' , get_phrase('product_updated_successfully'));
        redirect(base_url() . 'index.php?loansofficer/system_settings');
    }

    /*****SMS SETTINGS*********/
    function sms_settings($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($param1 == 'clickatell') {

            $data['description'] = $this->input->post('clickatell_user');
            $this->db->where('type' , 'clickatell_user');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('clickatell_password');
            $this->db->where('type' , 'clickatell_password');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('clickatell_api_id');
            $this->db->where('type' , 'clickatell_api_id');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?loansofficer/sms_settings/', 'refresh');
        }

        if ($param1 == 'twilio') {

            $data['description'] = $this->input->post('twilio_account_sid');
            $this->db->where('type' , 'twilio_account_sid');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('twilio_auth_token');
            $this->db->where('type' , 'twilio_auth_token');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('twilio_sender_phone_number');
            $this->db->where('type' , 'twilio_sender_phone_number');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?loansofficer/sms_settings/', 'refresh');
        }

        if ($param1 == 'active_service') {

            $data['description'] = $this->input->post('active_sms_service');
            $this->db->where('type' , 'active_sms_service');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?loansofficer/sms_settings/', 'refresh');
        }

        $page_data['page_name']  = 'sms_settings';
        $page_data['page_title'] = get_phrase('sms_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }
    
    /*****LANGUAGE SETTINGS*********/
    function manage_language($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
			redirect(base_url() . 'index.php?login', 'refresh');
		
		if ($param1 == 'edit_phrase') {
			$page_data['edit_profile'] 	= $param2;	
		}
		if ($param1 == 'update_phrase') {
			$language	=	$param2;
			$total_phrase	=	$this->input->post('total_phrase');
			for($i = 1 ; $i < $total_phrase ; $i++)
			{
				//$data[$language]	=	$this->input->post('phrase').$i;
				$this->db->where('phrase_id' , $i);
				$this->db->update('language' , array($language => $this->input->post('phrase'.$i)));
			}
			redirect(base_url() . 'index.php?loansofficer/manage_language/edit_phrase/'.$language, 'refresh');
		}
		if ($param1 == 'do_update') {
			$language        = $this->input->post('language');
			$data[$language] = $this->input->post('phrase');
			$this->db->where('phrase_id', $param2);
			$this->db->update('language', $data);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(base_url() . 'index.php?loansofficer/manage_language/', 'refresh');
		}
		if ($param1 == 'add_phrase') {
			$data['phrase'] = $this->input->post('phrase');
			$this->db->insert('language', $data);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(base_url() . 'index.php?loansofficer/manage_language/', 'refresh');
		}
		if ($param1 == 'add_language') {
			$language = $this->input->post('language');
			$this->load->dbforge();
			$fields = array(
				$language => array(
					'type' => 'LONGTEXT'
				)
			);
			$this->dbforge->add_column('language', $fields);
			
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(base_url() . 'index.php?loansofficer/manage_language/', 'refresh');
		}
		if ($param1 == 'delete_language') {
			$language = $param2;
			$this->load->dbforge();
			$this->dbforge->drop_column('language', $language);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			
			redirect(base_url() . 'index.php?loansofficer/manage_language/', 'refresh');
		}
		$page_data['page_name']        = 'manage_language';
		$page_data['page_title']       = get_phrase('manage_language');
		//$page_data['language_phrases'] = $this->db->get('language')->result_array();
		$this->load->view('backend/index', $page_data);	
    }
    
    /*****BACKUP / RESTORE / DELETE DATA PAGE**********/
    function backup_restore($operation = '', $type = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($operation == 'create') {
            $this->crud_model->create_backup($type);
        }
        if ($operation == 'restore') {
            $this->crud_model->restore_backup();
            $this->session->set_flashdata('backup_message', 'Backup Restored');
            redirect(base_url() . 'index.php?loansofficer/backup_restore/', 'refresh');
        }
        if ($operation == 'delete') {
            $this->crud_model->truncate($type);
            $this->session->set_flashdata('backup_message', 'Data removed');
            redirect(base_url() . 'index.php?loansofficer/backup_restore/', 'refresh');
        }
        
        $page_data['page_info']  = 'Create backup / restore from backup';
        $page_data['page_name']  = 'backup_restore';
        $page_data['page_title'] = get_phrase('manage_backup_restore');
        $this->load->view('backend/index', $page_data);
    }
	
	    
    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('loansofficer_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($param1 == 'update_profile_info') {
            $data['name']        = $this->input->post('name');
            $data['email']       = $this->input->post('email');
            
            $this->db->where('teacher_id', $this->session->userdata('teacher_id'));
            $this->db->update('loan_officer', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $this->session->userdata('teacher_id') . '.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            redirect(base_url() . 'index.php?loansofficer/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            $data['password']             = $this->input->post('password');
            $data['new_password']         = $this->input->post('new_password');
            $data['confirm_new_password'] = $this->input->post('confirm_new_password');
            
            $current_password = $this->db->get_where('loan_officer', array(
                'teacher_id' => $this->session->userdata('teacher_id')
            ))->row()->password;
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('teacher_id', $this->session->userdata('teacher_id'));
                $this->db->update('loan_officer', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?loansofficer/manage_profile/', 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('loan_officer', array(
            'teacher_id' => $this->session->userdata('teacher_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }


}
