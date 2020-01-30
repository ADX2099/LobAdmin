<?php

class datePicker extends CI_Controller
{
        // -------------------------------------------------------------------------
	function __construct()
            {
		// Call the Model constructor
		parent::__construct();
                $this->load->helper('date');
                

            }
            
            public function index(){
                $datestring = '%Y-%m-%d ';
                $fechaRegistro = mdate($datestring);
                //echo ($fechaRegistro);
                
                $this->load->view('datepicker_view'); 
            }
            
           
            
}
?>
