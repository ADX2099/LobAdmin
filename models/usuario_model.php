<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
 */
 class Usuario_model extends CRUD_model{
     
     protected $_table = 'Usuario';
     protected $_primary_key = 'usuario_id';
     
      // -------------------------------------------------------------------
    
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		

	}

        
        // -------------------------------------------------------------------
		
	function mail_exists($key)
	{
		$this->db->where('usuario_email',$key);
		$query = $this->db->get('Usuario');
		if ($query->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
        
        
 }
?>
