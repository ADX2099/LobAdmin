<?php
/*AQUI LO QUE SE ESTA HACIENDO ES TENER UN CRUD QUE PUEDA UTILIZAR EN CUALQUIER LADO, 
LO QUE HIZO ES HACER UN ARCHIVO QUE SE LLAMA CRUD_MODEL Y LO EXTENDIO DE CI_MODEL
 * Y ESTE ES EL QUE TIENE LAS FUNCIONES DE GET,DELETE,INSERT ETC.
 * */
 
class CRUD_model extends CI_Model{
    
    protected $_table = null;
    protected $_primary_key = null;
    // -------------------------------------------------------------------- 
    public function __construct() {
        parent::__construct();
    }
    // --------------------------------------------------------------------
    
    /*
	*@usage
	*Single : $this->user_model->get(2);
	*All : $this->user_model->get();
        *Custom: $this->user_model->get(array('age' => '32','gender' => 'male'))  
	*/
        
         // --------------------------------------------------------------------
	
	public function get($id = null, $order_by = null)
        {
			
				 
     		
            if(is_numeric($id)){
                $this->db->where($this->_primary_key, $id);
            }
            
            if(is_array($id)){
                foreach ($id as $_key => $_value){
                    $this->db->where($_key, $_value);
                }
            }
            
             $q =  $this->db->get($this->_table);
           
             /*
            if($id === null){
			$q = $this->db->get('user');
	    }else if(is_array($id)){
			$q = $this->db->get_where('user',$id);
	   }else{
			$q = $this->db->get_where('user', ['user_id' =>  $id]);
		}*/
		
            return $q->result_array();
	
	}
	/*
	* @param array data
	*@usage : $result = $this->user_model->insert(['login' => 'Yuffie_Kisaragi']);
	*/
        
	// ---------------------------------------------------------------------
	
        public function filter($consulta = NULL){
               
           $fecha_ini  =  $consulta['usuario_fecha_registro'];
           $fecha_fin = $consulta['usuario_opc2']; 
           $sexo = $consulta['usuario_sexo']; 
           $estado = $consulta['usuario_estado'];
           $TIPO = 0;
           //TIPO DE CONSULTA
           if ($sexo == "" && $estado == ""){
               $TIPO = 1;
           }elseif ($sexo == "") {
               $TIPO = 2;
            
           }elseif ($estado == "") {
               $TIPO = 3;
           }
           //echo($TIPO);    
             
           //FILTRA POR FECHAS SE REQUIERE UN RANGO DE FECHA FORZAMENTE
          
           
           switch ($TIPO) {
               case 0:
                   //QUERY CON LOS 4 VALORES
                  $q = $this->db->select('*')->from($this->_table)
                   ->group_start()
                       ->where('usuario_fecha_registro >=',$fecha_ini)
                       ->where('usuario_fecha_registro <=',$fecha_fin)
                       ->where('usuario_sexo',  $sexo)
                       ->where('usuario_estado', $estado)  
                   ->group_end()
                   ->order_by('usuario_nombre', 'ASC')
                   ->get(); 
                  return $q->result_array();
               break;
               case 1:
                    //QUERY SOLO POR FECHAS            
                    $q = $this->db->select('*')->from($this->_table)
                    ->group_start()
                        ->where('usuario_fecha_registro >=',$fecha_ini)
                        ->where('usuario_fecha_registro <=',$fecha_fin)  
                    ->group_end()
                    ->order_by('usuario_nombre', 'ASC')
                    ->get(); 
                    return $q->result_array();
               break;
               case 2:
                   //QUERY PARA TRAER ESTADOS
                    $q = $this->db->select('*')->from($this->_table)
                    ->group_start()
                        ->where('usuario_fecha_registro >=',$fecha_ini)
                        ->where('usuario_fecha_registro <=',$fecha_fin)
                        ->where('usuario_estado', $estado)  
                    ->group_end()
                    ->order_by('usuario_nombre', 'ASC')
                    ->get(); 
                   return $q->result_array();
               break;
               case 3:
                    //QUERY PARA TRAER SEXO
                    $q = $this->db->select('*')->from($this->_table)
                    ->group_start()
                        ->where('usuario_fecha_registro >=',$fecha_ini)
                        ->where('usuario_fecha_registro <=',$fecha_fin)
                        ->where('usuario_sexo',  $sexo)  
                    ->group_end()
                    ->order_by('usuario_nombre', 'ASC')
                    ->get(); 
                   return $q->result_array();
               break;
                 
           }
           
  
            
        }
        
       
        
         // --------------------------------------------------------------------
        public function insert($data){
		$this->db->insert($this->_table,$data);
		return $this->db->insert_id();
                
	
	}
	/*
         * @usage $result = $this->user_model->update(['login' => 'Peggy'],3);
         * $this->user_model->update(['login' => 'Ted'],['date_created' => '0'])
	*/
	
        // ---------------------------------------------------------------------
        
	public function update($new_data, $where){
                if(is_numeric($where)){
                    $this->db->where($this->_primary_key, $where);    
                }elseif(is_array($where)){
                    foreach ($where as $_key => $_value){
                        $this->db->where($_key, $_value);
                    }
                
                }else{
                    die("You must pass a second parameter to the UPDATE method");
                }
		
		$this->db->update($this->_table, $new_data);
		return $this->db->affected_rows();
	}
        
        // ---------------------------------------------------------------------
        /*
         * @usage insertUopdate(['name' => 'ted'],12)
         */
	public function insertUpdate($data,$id = false)
        {
            if(!$id){
                die("You must pass a second parameter to the insertUPDATE method");
            }
            $this->db->select($this->_primary_key);
            $this->db->where($this->_primary_key,$id);
            $q = $this->db->get($this->_table);
            $result = $q->num_rows();
            
            if($result == 0){
                //Update
                 return  $this->insert($data);
            }
            //Insert
            return $this->update($data, $id);
            
            
            
        }
        // ---------------------------------------------------------------------
	/*
	*@usage = $this->user_model->delete(7);
         *        $this->user_model->delete(array('name' => 'Markus'));
	*/
	
        // ---------------------------------------------------------------------
        
	public function delete($id){
                if(is_numeric($id)){
                    $this->db->where($this->_primary_key, $id);
                }elseif(is_array($id)){
                    
                    foreach ($id as $_key => $_value) {
                        $this->db->where($_key, $_value);
                    }
                }else{
                    die("You must pass a parameter to the delete method");
                }
		$this->db->delete($this->_table);
		return $this->db->affected_rows();
	
	}
	
}
