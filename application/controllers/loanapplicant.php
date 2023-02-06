<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');




class loanapplicant extends CI_Controller
{
    
    
    function __construct()
    {
        parent::__construct();
		$this->load->database();
        $this->load->library('session');
        /*cache control*/
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }
    
    /***default functin, redirects to login page if no teacher logged in yet***/
    public function index()
    {
        if ($this->session->userdata('loanapplicant_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('loanapplicant_login') == 1)
            redirect(base_url() . 'index.php?loanapplicant/dashboard', 'refresh');
    }
    
    /***TEACHER DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('loanapplicant_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('Applicant_dashboard');
        $this->load->view('backend/index', $page_data);
    }
    
      
    /****MANAGE STUDENTS CLASSWISE*****/
    function loan_client_add($param1 = '', $param2 = '', $param3 = '')
	{
		if ($this->session->userdata('loanapplicant_login') != 1)
            redirect(base_url(), 'refresh');
		
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
            $data['nationalid']       = $this->input->post('nationalid');
            $this->db->insert('loan_clients', $data);
            $student_id = $this->db->insert_id();
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $student_id . '.jpg');
            $this->session->set_flashdata('flash_message' , get_phrase('Client_information_submitted_successfully'));
			$this->email_model->account_opening_email('student', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            redirect(base_url() . 'index.php?loanapplicant/loan_client_add/' , 'refresh');
        }
			
		$page_data['page_name']  = 'loan_client_add';
		$page_data['page_title'] = get_phrase('Register');
		$this->load->view('backend/index', $page_data);
	}
	
	function loan_client_information()
	{
		if ($this->session->userdata('loanapplicant_login') != 1)
            redirect('login', 'refresh');
			
		$page_data['page_name']  	= 'loan_client_information';
		$page_data['page_title'] 	= get_phrase('Personal_information').
											
		$this->load->view('backend/index', $page_data);
	}
	
	
    /**********MANAGE LOAN APPLICATIONS *******************/
    function loan_manage_newapplication($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('loanapplicant_login') != 1)
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
			$data['branch_id']       	= $this->input->post('branch_id');
			
			$data['g_name']     		= $this->input->post('g_name');
            $data['g_relationship']     = $this->input->post('g_relationship');
            $data['g_number']     		= $this->input->post('g_number');			
			$data['g_address']     		= $this->input->post('g_address');
            $data['g_country']         	= $this->input->post('g_country');
			
        
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
            redirect(base_url() . 'index.php?loanapplicant/loan_manage_newapplication' , 'refresh');
          }
	
		
		
        $page_data['page_name']  = 'loan_manage_newapplication';
        $page_data['page_title'] = get_phrase('manage_loan_applicants');
        $page_data['loan_applicants']  = $this->db->get('loan')->result_array();
        $this->load->view('backend/index', $page_data);
    }
	

    function loan_manage_approveloans($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('loanapplicant_login') != 1)
            redirect('login', 'refresh');

		
        $page_data['page_name']  = 'loan_manage_approveloans';
        $page_data['page_title'] = get_phrase('manage_loan_approval');
        $page_data['loan_approvals']  = $this->db->get('loan')->result_array();
        $this->load->view('backend/index', $page_data);
    }
	
  
   
    function noticeboard($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('loanapplicant_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($param1 == 'create') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->insert('noticeboard', $data);
            redirect(base_url() . 'index.php?loanapplicant/noticeboard/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', $data);
            $this->session->set_flashdata('flash_message', get_phrase('notice_updated'));
            redirect(base_url() . 'index.php?loanapplicant/noticeboard/', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('noticeboard', array(
                'notice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('notice_id', $param2);
            $this->db->delete('noticeboard');
            redirect(base_url() . 'index.php?loanapplicant/noticeboard/', 'refresh');
        }
        $page_data['page_name']  = 'noticeboard';
        $page_data['page_title'] = get_phrase('manage_noticeboard');
        $page_data['notices']    = $this->db->get('noticeboard')->result_array();
        $this->load->view('backend/index', $page_data);
    }
    
	
	   /* private messaging */

    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('loanapplicant_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?loanapplicant/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?loanapplicant/message/message_read/' . $param2, 'refresh');
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

/******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('loanapplicant_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($param1 == 'update_profile_info') {
            $data['name']        = $this->input->post('name');
            $data['email']       = $this->input->post('email');
            
            $this->db->where('student_id', $this->session->userdata('student_id'));
            $this->db->update('loan_clients', $data);
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $this->session->userdata('student_id') . '.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            redirect(base_url() . 'index.php?loanapplicant/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            $data['password']             = $this->input->post('password');
            $data['new_password']         = $this->input->post('new_password');
            $data['confirm_new_password'] = $this->input->post('confirm_new_password');
            
            $current_password = $this->db->get_where('loan_clients',  array(
                'student_id' => $this->session->userdata('student_id')
            ))->row()->password;
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('student_id', $this->session->userdata('student_id'));
                $this->db->update('loan_clients', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?loanapplicant/manage_profile/', 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('loan_clients',  array(
            'student_id' => $this->session->userdata('student_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }



}