<?php

class Api extends CI_Controller{
    // -------------------------------------------------------------------------
    
    public  function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		
		$config['mailtype'] = "html";
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp.sparkpostmail.com';
		$config['smtp_user'] = 'SMTP_injection';
		$config['smtp_pass'] = '377533508b9c1ba63026ec80ab00652d43a1dce7';
		$config['smtp_port'] = '587';
		$config['smtp_crypto'] = 'tls';
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		
		//AQUI REVISO QUE LA SESION ESTE ACTIVA 
        $this->load->model('usuario_model');
		//$this->email->initialize($config);
		$this->load->library('email',$config);
		//$this->email->set_newline("\r\n");
        // $this->load->model('todo_model');
        // <$this->load->model('note_model');
                
	}
     // -------------------------------------------------------------------------
        
    private function required_login(){
        
        
        if($this->session->userdata('usuario_id') == false ){      
            $this->output->set_output(json_encode(['result' => 0,'error' => 'You are not authorized.']));
            return false; 
	}
    }
    
    // --------------------------------------------------------------------------
    
    public function get_filter(){
         $fechaInicial = $this->input->post('fecha_inicial');  
         $fechaFinal = $this->input->post('fecha_final');
         $sexo = $this->input->post('sexo');
         $estado = $this->input->post('estado');
        
     
         
         
         $result = $this->usuario_model->filter([
            'usuario_fecha_registro' => $fechaInicial,
            'usuario_opc2' => $fechaFinal,
            'usuario_sexo' => $sexo,
            'usuario_estado' => $estado
          ]);
         
         $this->output->set_content_type('application_json');        
         
         //print_r($result);
         
        $this->output->set_output(json_encode($result));
         
        
        
        
    }
    
     // -------------------------------------------------------------------------
    
    public function login(){                
			
			$email = $this->input->post('email_login');  
			$password = $this->input->post('password');
			
			
			
			//hash('sha256', $password . SALT)
			$result = $this->usuario_model->get([
				'usuario_email' => $email,
				'usuario_password' => hash('sha256', $password . SALT),
	
			]);
                        
			$output = array();
			//print_r($output);
			$this->output->set_content_type('application_json');
			
			
			
			if($result){	
				$this->session->set_userdata(['usuario_id' => $result[0]['usuario_id']]);
				$this->output->set_output(json_encode(['result' => 1]));
				return false;
			}else{
				$this->output->set_output(json_encode(['result' => 0]));
				return true;
			}
			
            //print_r($password);
            //print_r($result);
			//die
			//REMEMBER YOU MUST INCLUDE SESSION LIBRARY ON AUTOLOAD FILE
			//$this->session->set_userdata(['user' => 1]);
			//$session = $this->session->all_userdata();
			//print_r($session);
	}
        
         // -------------------------------------------------------------------------
	
	public function register(){	
			
			$this->output->set_content_type('application_json');
			//$this->form_validation->set_rules('login','Login','required|min_length[4]|max_length[16]|is_unique[user.login]');	
			$this->form_validation->set_rules('email_register','Email','required|valid_email');	
			//$this->form_validation->set_rules('password','Password','required|min_length[4]|max_length[16]|matches[confirm_password]')
			//$this->form_validation->message('required','You`ve missed some fields');
			//$this->form_validation->message('valid_email','Email wrong format');
			
			if($this->form_validation->run() === true){	
				$email = $this->input->post('email_register'); 
				$check_email = $this->usuario_model->get([
					'usuario_email' => $email,					
				]);
				
				if($check_email){
					
					$this->output->set_output(json_encode(['result' => 2, 'error' =>  'El email ya esta registrado' ]));	
					return false;
				}else{
					$password = $this->input->post('password');
					$nombre = $this->input->post('nombre');  
					$apellido = $this->input->post('apellidos');
					$sexo = $this->input->post('sexo');
					$estado = $this->input->post('estado');
					$cumple = $this->input->post('anio').'-'.$this->input->post('mes').'-'.$this->input->post('dia');
					
					$user_id = $this->usuario_model->insert([
									'usuario_email' => $email,
									'usuario_password' => hash('sha256', $password . SALT),
									'usuario_nombre' => $nombre,
									'usuario_apellido' => $apellido,
									'usuario_sexo' => $sexo,
									'usuario_estado' => $estado,
									'usuario_cumple' => $cumple                                                
					]);
					
					$this->session->set_userdata(array(
						'usuario_email' => $email,
						'usuario_password' => hash('sha256', $password . SALT),
						'usuario_nombre' => $nombre,
						'usuario_apellido' => $apellido,
						'usuario_sexo' => $sexo,
						'usuario_estado' => $estado,
						'usuario_cumple' => $cumple                
           		 	 ));
					 
					  
					$data = array(
						'email_register' => $email, 
						'password' => $password,
						'nombre' => $nombre,
						'ap_paterno' => $apellido,
						'sexo' => $sexo,
						'estado' => $estado,
						'cumple' => $cumple
					 ); 
					 
					 if($user_id){				
						$this->session->set_userdata(['usuario_id' => $user_id]);
						$toEmail = $email;
						$mensaje = $this->load->view('home/template_welcome',$data,true);
						$this->email->from('lobshop@lob.com.mx', 'Lob Store');
						$this->email->to($toEmail);
						$this->email->subject('Lobstore – Contacto');
						$this->email->message($mensaje);
						$this->email->send();					   
						$this->output->set_output(json_encode(['result' => 1]));
						return false;
					}else{
						$this->output->set_output(json_encode(['result' => 0, 'error' => 'Error al crear usuario ']));
					}	 
				}
				
			}else{
				$this->output->set_output(json_encode(['result' => 0, 'error' =>$this->form_validation->error_array()]));	
				return false;
			}		
			
	}
			
			
			
			/*
				
			if($this->form_validation->run() === true){			
				$email = $this->input->post('email_register');  
				$password = $this->input->post('password');
            	$nombre = $this->input->post('nombre');  
            	$apellido = $this->input->post('apellidos');
            	$sexo = $this->input->post('sexo');
            	$estado = $this->input->post('estado');
				$cumple = $this->input->post('anio').'-'.$this->input->post('mes').'-'.$this->input->post('dia');
				
				$user_id = $this->usuario_model->insert([
                                'usuario_email' => $email,
                                'usuario_password' => hash('sha256', $password . SALT),
								'usuario_nombre' => $nombre,
                                'usuario_apellido' => $apellido,
                                'usuario_sexo' => $sexo,
                                'usuario_estado' => $estado,
                                'usuario_cumple' => $cumple
                                                    
				]);
				
				   $this->session->set_userdata(array(
					'usuario_email' => $email,
					'usuario_password' => hash('sha256', $password . SALT),
					'usuario_nombre' => $nombre,
					'usuario_apellido' => $apellido,
					'usuario_sexo' => $sexo,
					'usuario_estado' => $estado,
              	  	'usuario_cumple' => $cumple                
           		  ));
				  
				   $data = array(
					'email_register' => $email, 
					'password' => $password,
					'nombre' => $nombre,
					'ap_paterno' => $apellido,
					'sexo' => $sexo,
					'estado' => $estado,
					'cumple' => $cumple
				); 
			
				if($user_id){
					
					$this->session->set_userdata(['usuario_id' => $user_id]);
					$toEmail = $email;
					$mensaje = $this->load->view('home/template_welcome',$data,true);
					$this->email->from('lobshop@lob.com.mx', 'Lob Store');
					$this->email->to($toEmail);
					$this->email->subject('Lobstore – Contacto');
					$this->email->message($mensaje);
					$this->email->send();
						   
					$this->output->set_output(json_encode(['result' => 1]));
					return false;
				}
				$this->output->set_output(json_encode(['result' => 0, 'error' => 'User not created ']));
							
			
				
			}else{
				
				$this->output->set_output(json_encode(['result' => 0, 'error' =>$this->form_validation->error_array()]));	
				return false;
			}
			
			*/
			//DESCOMENTAR PARA QUE JALE
			
			
			
			/*
			*
			*
			
			if($this->form_validation->run() === false){			
				$this->output->set_output(json_encode(['result' => 0, 'error' =>$this->form_validation->error_array()]));
				return false;
			}
			
			
			$email = $this->input->post('email_register');  
            $password = $this->input->post('password');
            $nombre = $this->input->post('nombre');  
            $apellido = $this->input->post('apellidos');
            $sexo = $this->input->post('sexo');
            $estado = $this->input->post('estado');
			$cumple = $this->input->post('anio').'-'.$this->input->post('mes').'-'.$this->input->post('dia');
                    */   
                        
                       
                        //$edad = $this->input->post('edad');
			//$confirm_password = $this->input->post('confirm_password');
                        //$pais = $this->input->post('pais');
                     
			//die('not yet ready');
			//hash('sha256', $password . SALT)
                         //'usuario_pais' => $pais,
                                //'usuario_edad' => $edad,
                                //'usuario_sexo' => $sexo,
                                //'usuario_cumple' => $fecha
			/*
			$user_id = $this->usuario_model->insert([
                                'usuario_email' => $email,
                                'usuario_password' => hash('sha256', $password . SALT),
								'usuario_nombre' => $nombre,
                                'usuario_apellido' => $apellido,
                                'usuario_sexo' => $sexo,
                                'usuario_estado' => $estado,
                                'usuario_cumple' => $cumple
                                                    
			]);*/
			
			
			//$output = array();
			
			//ARREGLO CON LOS DATOS DE LA SESION DEL USUARIO
            
			/*            
            $this->session->set_userdata(array(
            	'usuario_email' => $email,
            	'usuario_password' => hash('sha256', $password . SALT),
				'usuario_nombre' => $nombre,
               	'usuario_apellido' => $apellido,
                'usuario_sexo' => $sexo,
                'usuario_estado' => $estado,
                'usuario_cumple' => $cumple                
             ));*/
						
			//ARREGLO CON LOS DATOS QUE SE ENVIARAN EN EL CORREO 	
			/*		
            $data = array(
				'email_register' => $email, 
				'password' => $password,
				'nombre' => $nombre,
				'ap_paterno' => $apellido,
				'sexo' => $sexo,
                'estado' => $estado,
                'cumple' => $cumple
			); 
			
			if($user_id){
				
				$this->session->set_userdata(['usuario_id' => $user_id]);
            	$toEmail = $email;
				$mensaje = $this->load->view('home/template_welcome',$data,true);
				$this->email->from('lobshop@lob.com.mx', 'Lob Store');
            	$this->email->to($toEmail);
            	$this->email->subject('Lobstore – Contacto');
           		$this->email->message($mensaje);
            	$this->email->send();
                       
				$this->output->set_output(json_encode(['result' => 1]));
				return false;
			}
			$this->output->set_output(json_encode(['result' => 0, 'error' => 'User not created ']));*/
				
//	}
        
         // -------------------------------------------------------------------------
        
        public function create_todo(){
            $this->required_login();
            $this->output->set_content_type('application_json');
            
            
             $this->form_validation->set_rules('content','Content','required|max_length[255]');
            
             if($this->form_validation->run() == false){
                $this->output->set_output(json_encode(['result' => 0, 'error' =>$this->form_validation->error_array()]));
                return false;
            }
            /*
             * SIN USAR EL MODELO SE HACEN LOS INSERT A TRAVES DE LOS METODOS 
             * NATIVOS
            $result = $this->db->insert('todo',[
                'content' => $this->input->post('content'),
                'user_id' => $this->session->userdata('user_id')
            ]);*/
            
            $result = $this->todo_model->insert([
                'content' => $this->input->post('content'),
                'user_id' => $this->session->userdata('user_id')
            ]);
            
            if($result){
                //Obtener las ultimas entradas para el dom
                //$query = $this->db->get_where('todo',['todo_id' => $this->db->insert_id()]);
                $this->output->set_output(json_encode([
                    'result' => 1,
                    'data' => array(
                        'todo_id' => $result,
                        'content' => $this->input->post('content'),
                        'complete' => 0
                
                    )  
                    //'data' => $query->result()
                    ]));
                return false;
            }
            
            $this->output->set_output(json_encode(['result' => 0]));
        }
        
         // -------------------------------------------------------------------------
        
         public function delete_todo(){
             $this->required_login();
             $todo_id = $this->input->post('todo_id');
             $user_id = $this->session->userdata('user_id') ;
             
             
            $result = $this->todo_model->delete([
                'todo_id' => $todo_id ,
                 'user_id' => $user_id
                     
             ]);
              
             
             if($result){
                 $this->output->set_output(json_encode(['result' => 1]));
                 return false;
             }
             $this->output->set_output(json_encode([
                 'result' => 0,
                 'message' => 'Could not delete'
             ]));
             
             /*
             $result = $this->db->delete('todo',[
                'todo_id' => $this->input->post('todo_id'),
                 'user_id' => $this->session->userdata('user_id')
                     
             ]);*/
             
            
        }
        
         // -------------------------------------------------------------------------
        
         public function  update_todo(){
             $this->required_login();
             $todo_id = $this->input->post('todo_id');
             $completed = $this->input->post('completed');
             
             $result = $this->todo_model->update([
                 'completed' => $completed
             ],$todo_id);
             /*
              * SE HACEN LOS UPDATES SIN EL MODELO 
             $this->db->where(['todo_id' => $todo_id]);
             $result = $this->db->update('todo',[
                 'completed' => $completed
             ]);*/
             
             //$result = $this->db->affected_rows();
            
             
             if($result){
                 $this->output->set_output(json_encode(['result' => 1]));
                 return false;
             }
             
             $this->output->set_output(json_encode(['result' => 0]));
             return false;
             
            
        }
        
         // -----------------------------------------------------------------------------------------------------------------------------------
        
        public function get_todo($id = null){
            $this->required_login();
            //CON ESTA CONDICIONAL OBTENGO SOLO LOS REGISTROS QUE TIENEN EL ID ASIGNADO
            //PARA OBTENERLO LE TIENES QUE PASAR ASI 
            //http://localhost/LearnCodeigniter/index.php/api/get_todo/12
            
            if($id != null){
                //USANDO EL MODELO
                $this->todo_model->get([
                    'todo_id' => $id,
                    'user_id' => $this->session->userdata('user_id')
                ]);
                
                //SIN USAR EL MODELO
                //$this->db->where([
                  //  'todo_id' => $id,
                    //'user_id' => $this->session->userdata('user_id')
                //]);
            }else{
                $result = $this->todo_model->get([
                    'user_id' => $this->session->userdata('user_id') 
                ]); 
                
                //$this->db->where('user_id', $this->session->userdata('user_id'));
            }
            
            //$query = $this->db->get('todo');
            //$result = $query->result();
            $this->output->set_output(json_encode($result));
             
        }
        
        // -------------------------------------------------------------------------
        
        public function create_note(){
            $this->required_login();
            $this->output->set_content_type('application_json');
            
            
             $this->form_validation->set_rules('title','title','required|max_length[50]');
             $this->form_validation->set_rules('content','content','required|max_length[550]');
            
             if($this->form_validation->run() == false){
                $this->output->set_output(json_encode(['result' => 0, 'error' =>$this->form_validation->error_array()]));
                return false;
            }
          
            
            $result = $this->note_model->insert([
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'user_id' => $this->session->userdata('user_id')
            ]);
            
            if($result){
                
                $this->output->set_output(json_encode([
                    'result' => 1,
                    'data' =>  array(
                        'note_id' => $result,
                        'title' => $this->input->post('title'),
                         'content' => $this->input->post('content')
                
                    )  
                    
                    
                    ]));
                return false;
            }
            $this->output->set_output(json_encode(['result' => 0]));
        }
        
         // -------------------------------------------------------------------------
        
         public function delete_note(){
            $this->required_login();
             $note_id = $this->input->post('note_id');
             $user_id = $this->session->userdata('user_id') ;
             
             
            $result = $this->note_model->delete([
                'note_id' => $note_id ,
                 'user_id' => $user_id
                     
             ]);
              
             
             if($result){
                 $this->output->set_output(json_encode(['result' => 1]));
                 return false;
             }
             $this->output->set_output(json_encode([
                 'result' => 0,
                 'message' => 'Could not delete'
             ]));
             
            
        }
        
         // -------------------------------------------------------------------------
        
         public function update_note(){
             $this->required_login();
            $note_id = $this->input->post('note_id');
            
            $result = $this->note_model->update([
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content')
                
            ], $note_id);
            
            
            
            
             //Do not chech the result because if no affected row happend it will think 
            //that its an error
             /*if($result){
                 $this->output->set_output(json_encode(['result' => 1]));
                 return false;
             }*/
             
             $this->output->set_output(json_encode(['result' => 1]));
             return false;
            
        }
        
        public function get_note($id = null){
            $this->required_login();
          
            
            if($id != null){
                //USANDO EL MODELO
                $this->note_model->get([
                    'note_id' => $id,
                    'user_id' => $this->session->userdata('user_id')
                ]);
                
               
            }else{
                $result = $this->note_model->get([
                    'user_id' => $this->session->userdata('user_id')
                ]); 
            }
            $this->output->set_output(json_encode($result));
            
 
        }
	
	// -----------------------------------------------------------------------------------------------------------------------------------
	
	public function do_upload(){
		   $config['upload_path']          = 'http://www.lob.com.mx/public/cv/';
           $config['allowed_types']        = 'gif|jpg|png';
           $config['max_size']             = 200;
           $config['max_width']            = 1024;
           $config['max_height']           = 768;
		   
		   $this->load->library('upload', $config);
		   
		    if ( ! $this->upload->do_upload('userfile')){
            	$error = array('error' => $this->upload->display_errors());
				
            }else{
          		$data = array('upload_data' => $this->upload->data());
               
            }
			
			
	} 
	
	// -------------------------------------------------------------------------------------------------------------------------------------

	public function update_password(){
			$email = $this->input->post('email');
			$password = sha1(SALT.$this->input->post('password'));
			
			  $result = $this->usuario_model->update([
                'usuario_password' => $password
            ], ['usuario_email' => $email]);
			
			  if($result){
				 $this->output->set_output(json_encode(['result' => 1]));
			   }else{
					$this->output->set_output(json_encode(['result' => 0]));
				}
	
	}
	
	// -------------------------------------------------------------------------------------------------------------------------------------

	public function verify_reset_password_code($email, $code){
		 $result = $this->usuario_model->get([
                    'usuario_email' => $email,  
          ]);
		  
		  if($result){
		  	//$firstname = $result[0]['usuario_nombre'];
			//echo($firstname);
			$md5Code = md5(SALT.$result[0]['usuario_nombre']);
			//$md5Code = substr($md5Code,  0, strlen($md5Code) - 1);
			if($code === $md5Code){
				return true;
			}else{
				return false;
			}
			
			//return ($code == md5(SALT.$result[0]['usuario_nombre'])) true : false;
			return true;
		  }else{
		  	return false;
		  }
			
	}
	
	// -------------------------------------------------------------------------------------------------------------------------------------
	
	public function reset_password_form($email, $email_code){
		if(isset($email,$email_code)){
			$email = trim($email);
			$email_hash = sha1($email.$email_code);
			$verified = $this->verify_reset_password_code($email, $email_code);
			//echo($verified);
			
			if($verified){
				$this->load->view('home/inc/header_view');
		    	$this->load->view('home/cambia_pass_view',array('email_hash' => $email_hash,'email_code' => $email_code,'email' => $email));
		    	$this->load->view('home/inc/footer_view');	
			}else{
				$this->load->view('home/inc/header_view');
		    	$this->load->view('home/recupera_view');
		    	$this->load->view('home/inc/footer_view');
				$this->output->set_output(json_encode(['result' => 3]));
					
			}
			
			
		}
		
		
	
	}
	
	// -------------------------------------------------------------------------------------------------------------------------------------
	
	  private function send_email_pass($email, $userData){
			  $fromEmail = "lobshop@lob.com.mx";
			  $firstname = $userData[0]['usuario_nombre'];
			  //print_r($firstname);
			  $email_code = md5(SALT.$firstname);
			  $subject = 'Lobstore – Cambio de Contraseña';
			  $toEmail = $email;
			  $mensaje = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
						  "http://www.w3.org/TR/xhtml1-strct.dtd"><html>
						  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
						  </head></body>';
			  $mensaje .= '<p>Estimado(a): '.$firstname.',</p>';
			  $mensaje .= '<p>Da click en el link para recuperar tu contraseña <strong><a href="' .base_url(). 'api/reset_password_form/'. $email . '/'. 	$email_code .'">   
					 click here</a></strong>  ';
			  $mensaje .= '</body></html>';
			  
			  $this->email->from($fromEmail, 'Lob Store');
			   $this->email->to($toEmail);
			   $this->email->subject($subject);
			   $this->email->message($mensaje);
			   $sent = $this->email->send();
			  if($sent == true){
				$this->output->set_output(json_encode(['result' => 1]));
		  		return false;
		  	  }else{
		  		$this->output->set_output(json_encode(['result' => 0]));
			  } 
			 
	
			 
		  }
		
	// -----------------------------------------------------------------------------------------------------------------------------------
	
	   public function reset_password(){
            if(isset($_POST['email']) && !empty($_POST['email'])){
                $this->load->library('form_validation');
                //first chweck if email is valid or not
                
                $this->form_validation->set_rules('email','Email Address', 'trim|required|min_length[6]|max_length[50]|valid_email|xss_clean');
                
                if($this->form_validation->run() == FALSE){
                    
					
					//email didnt validate send back to the reset password and show errors
				   $this->load->view('home/inc/header_view');
                   $this->load->view('home/recupera_view');
                   $this->load->view('home/inc/footer_view');
				   
				   $this->output->set_output(json_encode(['result' => 0]));
                   
                }else{
                    $email = trim ($this->input->post('email'));
                    $result = $this->email_exists($email);
                    
                    if($result){
                       
						$this->send_email_pass($email, $result);
	
                    }else{
                        $this->load->view('home/inc/header_view');
                        $this->load->view('home/recupera_view');
                        $this->load->view('home/inc/footer_view');
						
						 $this->output->set_output(json_encode(['result' => 2]));
                        
                    }   
                    
                }
                
            }else{
               $this->load->view('home/inc/header_view');
               $this->load->view('cambia_pass_view');
               $this->load->view('home/inc/footer_view'); 
                
            }
			
			
             
			 
			 
            
        }
		
		// -----------------------------------------------------------------------------------------------------------------------------------
		
		 public function email_exists($email){
            $result = $this->usuario_model->get([
                    'usuario_email' => $email,  
            ]);
			
			$this->output->set_content_type('application_json');
            
			//print_r($result);
            if($result){
				return $result;
            }else{
                return false;
            }
            
        }
		
		// -----------------------------------------------------------------------------------------------------------------------------------
        
        public function mail_sender(){
			
			$tipo = $this->input->post('tipo');
            $area = $this->input->post('area');  
            $nombre = $this->input->post('nombre');
            $ap_paterno = $this->input->post('ap_paterno');  
            $ap_materno = $this->input->post('ap_materno');
            $email = $this->input->post('email');
            $telefono = $this->input->post('tel');
            $movil = $this->input->post('movil');
            $fecha_nac = $this->input->post('fecha_nac');
            $sexo = $this->input->post('sexo');
            $edo_civil = $this->input->post('edo_civil');
            $direccion = $this->input->post('direccion');
            $cp = $this->input->post('cp');
            $colonia = $this->input->post('colonia');
            $ciudad = $this->input->post('ciudad');
            $pais = $this->input->post('pais');
            $estado = $this->input->post('estado');
            $grado = $this->input->post('grado');
            $linkedin = $this->input->post('linkedin');
			$asunto = $this->input->post('asunto');
			$comentarios = $this->input->post('comentarios');
			$talla = $this->input->post('talla');
			$color = $this->input->post('color');
			$newsletter = $this->input->post('newsletter');
			$aviso = $this->input->post('aviso');
			$sku = $this->input->post('sku');
			$cv = $this->input->post('cv');
			$fromEmail = "lobshop@lob.com.mx";
			$toEmail;
			$subject; 
			
			
			switch($tipo){
				case "contacto":
					$subject = 'Lobstore – Contacto';
					//$toEmail = "wlodtzun@gmail.com";
					//$toEmail = "agomez.arbiec@gmail.com";
					//$toEmail = "dg.estefany.avila@gmail.com";
					$toEmail = "lobstore@lob.com.mx";
					$dataUser = array(
						'area' => $area,
						'nombre' => $nombre,
						'ap_paterno' => $ap_paterno,
						'email' => $email,
						'telefono' =>  $telefono,
						'movil' => $movil,
						'asunto' => $asunto,
						'comentarios' => $comentarios,
						'estado' => $estado,
						'newsletter' => $newsletter,
						'aviso' => $aviso
						
					);
					
					$mensaje = $this->load->view('home/template_contact',$dataUser,true);
					$this->email->from($fromEmail, 'Lob Store');
					$this->email->to($toEmail);
					$this->email->subject($subject);
					$this->email->message($mensaje);
					$sent = $this->email->send();
					if($sent == true){
           				$this->output->set_output(json_encode(['result' => 1]));
						return false;
					}else{
						$this->output->set_output(json_encode(['result' => 0]));
					} 
					
				break;
				case "mayoreo":
					$subject = 'Lobstore – Mayoreo';
					//$toEmail = "agomez.arbiec@gmail.com";
					$toEmail = "mayoreo@lob.com.mx";
					$dataUser = array(
						
						'nombre' => $nombre,
						'ap_paterno' => $ap_paterno,
						'ap_materno' => $ap_materno,
						'email' => $email,
						'telefono' =>  $telefono,
						'movil' => $movil,
						'comentarios' => $comentarios,
						'estado' => $estado
					);
					
					$mensaje = $this->load->view('home/template_mayoreo',$dataUser,true);
					
					$this->email->from($fromEmail, 'Lob Store');
					$this->email->to($toEmail);
					$this->email->subject($subject);
					$this->email->message($mensaje);
					$sent = $this->email->send();
					if($sent == true){
           			$this->output->set_output(json_encode(['result' => 1]));
						return false;
					}else{
						$this->output->set_output(json_encode(['result' => 0]));
					} 
				break;
				case "trabajo":
					
					$subject = 'Lobstore – Bolsa de Trabajo';
					//$toEmail = "agomez.arbiec@gmail.com";
					$toEmail = "capitalhumano@lob.com.mx";
					$dataUser = array(
						'area' => $area,
						'nombre' => $nombre,
						'ap_paterno' => $ap_paterno,
						'ap_materno' => $ap_materno,
						'email' => $email,
						'telefono' =>  $telefono,
						'movil' => $movil,
						'fecha_nac' => $fecha_nac,
						'sexo' => $sexo,
						'edo_civil' => $edo_civil,
						'direccion' => $direccion,
						'ciudad' => $ciudad,
						'estado' => $estado,
						'grado' => $grado,
						'linkedin' => $linkedin
					);
					
					if($cv == "on"){
						$this->do_upload();
					}
					
					
									
					$mensaje = $this->load->view('home/template_trabajo',$dataUser,true);
					$this->email->from($fromEmail, 'Lob Store');
					$this->email->to($toEmail);
					$this->email->subject($subject);
					$this->email->message($mensaje);
					$sent = $this->email->send();
					if($sent == true){
           			$this->output->set_output(json_encode(['result' => 1]));
						return false;
					}else{
						$this->output->set_output(json_encode(['result' => 0]));
					} 
					
				break;
				case "tallas":
					
					$subject = 'Lobstore – Tallas Lob';
					//$toEmail = "agomez.arbiec@gmail.com";
					$toEmail = "lobstore@lob.com.mx";
					$dataUser = array(
						'nombre' => $nombre,
						'ap_paterno' => $ap_paterno,
						'ap_materno' => $ap_materno,
						'email' => $email,
						'telefono' =>  $telefono,
						'movil' => $movil,
						'sku' => $sku,
						'sexo' => $sexo,
						'talla' => $talla,
						'color' => $color,	
					);
					
									
					$mensaje = $this->load->view('home/template_talla',$dataUser,true);
					
					$this->email->from($fromEmail, 'Lob Store');
					$this->email->to($toEmail);
					$this->email->subject($subject);
					$this->email->message($mensaje);
					$sent = $this->email->send();
					if($sent == true){
           			$this->output->set_output(json_encode(['result' => 1]));
						return false;
					}else{
						$this->output->set_output(json_encode(['result' => 0]));
					} 
					
				break;
			
			}
			
			// -----------------------------------------------------------------------------------------------------------------------------------
            
            
            
            
       
		}
        
        
}