<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function get_type_name_by_id($type, $type_id = '', $field = 'name') {
        return $this->db->get_where($type, array($type . '_id' => $type_id))->row()->$field;
    }
    function loan_client_info($student_id) {
        $query = $this->db->get_where('loan_clients',  array('student_id' => $student_id));
        return $query->result_array();
    }

    function new_loan_client_list() {
        $data = array();
        $sql = "select * FROM loan_clients order by student_id desc limit 0, 7";
        $rows = $this->db->query($sql)->result_array();
        foreach ($rows as $row) {
            $key = $row['student_id'];
            $face_file = 'uploads/student_image/' . $row['student_id'] . '.jpg';
            if (!file_exists($face_file)) {
                $face_file = 'uploads/default_avatar.jpg';
            }
            $row["face_file"] = base_url() . $face_file;

            array_push($data, $row);
        }
        return $data;
    }

/////////LOAN OFFICER/////////////

 function get_interest_name_by_id($interest_id) {
        $query = $this->db->get_where('loan_interest_rates', array('interest_id' => $interest_id))->row();
        return $query->name;
    }
	
	function get_branch_name_by_id($branch_id) {
        $query = $this->db->get_where('loan_branch', array('branch_id' => $branch_id))->row();
        return $query->name;
    }

  
  
	
	function get_loan_client_name($student_id) {
        $query = $this->db->get_where('loan_clients',  array('student_id' => $student_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['name'];
    }



////////////loan_type///////////
    function get_loan_type_name($class_id) {
        $query = $this->db->get_where('loan_types', array('class_id' => $class_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['name'];
    }

   
   


    function create_log($data) {
        $data['timestamp'] = strtotime(date('Y-m-d') . ' ' . date('H:i:s'));
        $data['ip'] = $_SERVER["REMOTE_ADDR"];
        $location = new SimpleXMLElement(file_get_contents('http://freegeoip.net/xml/' . $_SERVER["REMOTE_ADDR"]));
        $data['location'] = $location->City . ' , ' . $location->CountryName;
        $this->db->insert('log', $data);
    }

   

////////BACKUP RESTORE/////////
    function create_backup($type) {
        $this->load->dbutil();


        $options = array(
            'format' => 'txt', // gzip, zip, txt
            'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE, // Whether to add INSERT data to backup file
            'newline' => "\n"               // Newline character used in backup file
        );


        if ($type == 'all') {
            $tables = array('');
            $file_name = 'system_backup';
        } else {
            $tables = array('tables' => array($type));
            $file_name = 'backup_' . $type;
        }

        $backup = & $this->dbutil->backup(array_merge($options, $tables));


        $this->load->helper('download');
        force_download($file_name . '.sql', $backup);
    }

/////////RESTORE TOTAL DB/ DB TABLE FROM UPLOADED BACKUP SQL FILE//////////
    function restore_backup() {
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/backup.sql');
        $this->load->dbutil();


        $prefs = array(
            'filepath' => 'uploads/backup.sql',
            'delete_after_upload' => TRUE,
            'delimiter' => ';'
        );
        $restore = & $this->dbutil->restore($prefs);
        unlink($prefs['filepath']);
    }

/////////DELETE DATA FROM TABLES///////////////
    function truncate($type) {
        if ($type == 'all') {
            $this->db->truncate('student');
            $this->db->truncate('mark');
            $this->db->truncate('teacher');
            $this->db->truncate('subject');
            $this->db->truncate('class');
            $this->db->truncate('exam');
            $this->db->truncate('grade');
        } else {
            $this->db->truncate($type);
        }
    }

////////IMAGE URL//////////
    function get_image_url($type = '', $id = '') {
        if (file_exists('uploads/' . $type . '_image/' . $id . '.jpg'))
            $image_url = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
        else
            $image_url = base_url() . 'uploads/user.jpg';

        return $image_url;
    }

////////private message//////
    function send_new_private_message() {
        $message = $this->input->post('message');
        $timestamp = strtotime(date("Y-m-d H:i:s"));

        $reciever = $this->input->post('reciever');
        $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

//check if the thread between those 2 users exists, if not create new thread
        $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->num_rows();
        $num2 = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->num_rows();

        if ($num1 == 0 && $num2 == 0) {
            $message_thread_code = substr(md5(rand(100000000, 20000000000)), 0, 15);
            $data_message_thread['message_thread_code'] = $message_thread_code;
            $data_message_thread['sender'] = $sender;
            $data_message_thread['reciever'] = $reciever;
            $this->db->insert('message_thread', $data_message_thread);
        }
        if ($num1 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->row()->message_thread_code;
        if ($num2 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->row()->message_thread_code;


        $data_message['message_thread_code'] = $message_thread_code;
        $data_message['message'] = $message;
        $data_message['sender'] = $sender;
        $data_message['timestamp'] = $timestamp;
        $this->db->insert('message', $data_message);



        return $message_thread_code;
    }

    function send_reply_message($message_thread_code) {
        $message = $this->input->post('message');
        $timestamp = strtotime(date("Y-m-d H:i:s"));
        $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');


        $data_message['message_thread_code'] = $message_thread_code;
        $data_message['message'] = $message;
        $data_message['sender'] = $sender;
        $data_message['timestamp'] = $timestamp;
        $this->db->insert('message', $data_message);


    }

    function mark_thread_messages_read($message_thread_code) {
// mark read only the oponnent messages of this thread, not currently logged in user's sent messages
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $this->db->where('sender !=', $current_user);
        $this->db->where('message_thread_code', $message_thread_code);
        $this->db->update('message', array('read_status' => 1));
    }

    function count_unread_message_of_thread($message_thread_code) {
        $unread_message_counter = 0;
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();
        foreach ($messages as $row) {
            if ($row['sender'] != $current_user && $row['read_status'] == '0')
                $unread_message_counter++;
        }
        return $unread_message_counter;
    }

    function count_unread_message_of_curuser() {
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $sql = "select count(a.message_id) counts from message a "
                . " inner join message_thread b on a.message_thread_code=b.message_thread_code "
                . " where b.reciever='" . $current_user . "' and a.read_status=0";
        $row = $this->db->query($sql)->row_array();
        return $row["counts"];
    }

    function unread_message_of_curuser() {
        $data = array();
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $sql = "select a.*  from message a "
                . " inner join message_thread b on a.message_thread_code=b.message_thread_code "
                . " where b.reciever='" . $current_user . "' and a.read_status=0";
        $rows = $this->db->query($sql)->result_array();
        foreach ($rows as $row) {
            $sender = explode('-', $row['sender']);
            $sender_type = $sender[0];
            $sender_id = $sender[1];

            $sql = "select name from " . $sender_type . " where " . $sender_type . "_id=" . $sender_id;
            $result = $this->db->query($sql)->row_array();
            $row["sender_name"] = $result["name"];

            $key = $row['sender'];
            $face_file = 'uploads/' . $sender_type . '_image/' . $sender_id . '.jpg';
            if (!file_exists($face_file)) {
                $face_file = 'uploads/default_avatar.jpg';
            }
            $row["face_file"] = base_url() . $face_file;

//            $cur_time = date('Y-m-d H:i:s', time());
//            $send_time =date('Y-m-d H:i:s', $row["timestamp"]);
//            echo $cur_time;
//            $diff = date_diff($cur_time, $send_time);
            $ago = '';
            $sec = time() - $row["timestamp"];
            $year = (int) ($sec / 31556926);
            $month = (int) ($sec / 2592000);
            $day = (int) ($sec / 86400);
            $hou = (int) ($sec / 3600);
            $min = (int) ($sec / 60);
            if ($year > 0) {
                $ago = $year . ' year(s)';
            } else if ($month > 0) {
                $ago = $month . ' month(s)';
            } else if ($day > 0) {
                $ago = $day . ' day(s)';
            } else if ($hou > 0) {
                $ago = $hou . ' hour(s)';
            } else if ($min > 0) {
                $ago = $min . ' minute(s)';
            } else {
                $ago = $sec . ' second(s)';
            }

            $row["ago"] = $ago;

            array_push($data, $row);
        }
        return $data;
    }
	
	
	function get_key_val() {
        $query = $this->db->get('valid');
        return $query;
    }
	
/////////////////////////////////////  REPORTS at dashboard  ////////////////////////////////

	 function report_completed_loans() {
			$sql = "SELECT COUNT(*) as 'completeloans' FROM loan WHERE status ='finished'";
			$row = $this->db->query($sql)->row_array();
			return $row["completeloans"];
		}


	 function report_open_loans() {
			 $sql = "SELECT COUNT(*) as 'openloans' FROM loan WHERE status ='running'";
			$row = $this->db->query($sql)->row_array();
			return $row["openloans"];
		}

    function report_paid_amount($branch_id) {
        $sql_1 = "SELECT sum((amount_winterest-due)) as 'paidamount' FROM loan WHERE status='running'";
        $sql_br = "SELECT branch_id, SUM((amount_winterest-due)) as 'paidamount' FROM loan WHERE status='running' AND branch_id='" . $branch_id . "'";   
        $sql = ($branch_id=="")?$sql_1:$sql_br;
		$row = $this->db->query($sql)->row_array();
        return $row["paidamount"];
    }
	
	function report_due_amount($branch_id) {
         $sql_1 = "SELECT sum(due) as 'due_amount' FROM loan WHERE status='running'";
		 $sql_br = "SELECT branch_id,SUM(due) as 'due_amount' FROM loan WHERE status='running' AND branch_id='" . $branch_id . "'";   
		 $sql = ($branch_id=="")?$sql_1:$sql_br;
        $row = $this->db->query($sql)->row_array();
        return $row["due_amount"];
    }
	
	
	
		function report_total_loans($branch_id) {
		$sql_1 = "SELECT SUM(amount_winterest) as 'totalamountloans' FROM loan WHERE status ='running'";
		$sql_br = "SELECT branch_id,SUM(amount_winterest) as 'totalamountloans' FROM loan WHERE status ='running' AND branch_id='" . $branch_id . "'";      
		$sql = ($branch_id=="")?$sql_1:$sql_br;
        $row = $this->db->query($sql)->row_array();
        return $row["totalamountloans"];
    }
	
	
		function report2_total_loans($month_id) {
		$sql_1 = "SELECT SUM(amount_winterest) as 'totalamountloans' FROM loan WHERE status ='running'";
		$sql_br = "SELECT SUM(amount_winterest) as 'totalamountloans' FROM loan WHERE status ='running' AND YEAR(date) = '2019' AND MONTH(date)='" . $month_id . "' GROUP BY MONTH(date)";      
		$sql = ($month_id=="")?$sql_1:$sql_br;
        $row = $this->db->query($sql)->row_array();
        return $row["totalamountloans"];
    }
	
		function report2_due_amount($month_id) {
         $sql_1 = "SELECT sum(due) as 'due_amount' FROM loan WHERE status='running'";
		 $sql_br = "SELECT SUM(due) as 'due_amount' FROM loan WHERE status ='running' AND YEAR(date) = '2019' AND MONTH(date)='" . $month_id . "'
GROUP BY MONTH(date)";   
		 $sql = ($month_id=="")?$sql_1:$sql_br;
        $row = $this->db->query($sql)->row_array();
        return $row["due_amount"];
    }
	
	
	 function report2_paid_amount($month_id) {
        $sql_1 = "SELECT sum((amount_winterest-due)) as 'paidamount' FROM loan WHERE status='running'";
        $sql_br = "SELECT SUM(amount) as 'paidamount' FROM loan_payment WHERE YEAR(timestamp) = '2019' AND MONTH(timestamp)='" . $month_id . "' AND status IN('running','finished') GROUP BY MONTH(timestamp)";   
        $sql = ($month_id=="")?$sql_1:$sql_br;
		$row = $this->db->query($sql)->row_array();
        return $row["paidamount"];
    }

}
