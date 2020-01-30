<?php

class Home extends CI_Controller
{
        // -------------------------------------------------------------------------
	function __construct()
            {
		// Call the Model constructor
		parent::__construct();
                

            }
            
            public function index(){
                $this->load->view('admin_login_view'); 
            }
            
           public function logout(){
                $this->session->sess_destroy();
		$this->load->view('admin_login_view');
            }
            
            
            
            
}

?>
