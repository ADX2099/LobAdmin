<?php

class panel extends CI_Controller
{
        // -------------------------------------------------------------------------
	function __construct()
            {
		// Call the Model constructor
		parent::__construct();

            }
            
         private function required_login()
            {
                if($this->session->userdata('usuario_id') == false ){         
                    return false; 
                }else{
                    return true;
                }
            }
            
            public function index(){
                if($this->required_login()){
                   
                    $this->load->view('panel_admin_view');
                }  else {
                    $this->logout();
                }
                 
            }
            
            public function logout(){
		$this->session->sess_destroy();
		$this->load->view("admin_login_view");
		
            }
                
            
}




?>
