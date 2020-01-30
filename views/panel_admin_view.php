<!DOCTYPE html>
<!--  This site was created in Webflow. http://www.webflow.com -->
<!--  Last Published: Sat Dec 17 2016 18:54:00 GMT+0000 (UTC)  -->
<html data-wf-page="582a436569fd20902f668d02" data-wf-site="57c06862922ca65171ab0b1c">
<head>
  <meta charset="utf-8">
  <title>Panel Admin</title>
  <meta content="Panel Admin" property="og:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta content="Webflow" name="generator">
  
  <link href="http://localhost/AdministradorLOB/public/css/webflow/normalize.css" rel="stylesheet" type="text/css">
  <link href="http://localhost/AdministradorLOB/public/css/webflow/webflow.css" rel="stylesheet" type="text/css">
  <link href="http://localhost/AdministradorLOB/public/css/webflow/lob.webflow.css" rel="stylesheet" type="text/css">
  <link href="http://localhost/AdministradorLOB/public/widgets/jquery.datepick/css/jquery.datepick.css" rel="stylesheet">
 
  <script src="http://localhost/AdministradorLOB/public/js/filter/result.js"></script>
  <script src="http://localhost/AdministradorLOB/public/js/filter/template.js"></script>
  <script src="http://localhost/AdministradorLOB/public/js/filter.js"></script>

  
  
 <!-- ESTE ES EL ORDEN OBLIGATORIO DE LA LLAMDA DE ARCHIVOS -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://localhost/AdministradorLOB/public/widgets/jquery.datepick/js/jquery.plugin.min.js"></script>
  <script src="http://localhost/AdministradorLOB/public/widgets/jquery.datepick/js/jquery.datepick.js"></script>
  <script src="http://localhost/AdministradorLOB/public/widgets/jquery.datepick/js/jquery.datepick-es.js"></script>
  
  
  <script type="text/javascript">
    WebFont.load({
      google: {
        families: ["Montserrat:400,700","Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic"]
      }
    });
  </script>
    <script src="http://localhost/AdministradorLOB/public/widgets/exportxls/src/jquery.table2excel.js"></script>
  <link href="http://localhost/AdministradorLOB/public/images/ico-lob.png" rel="shortcut icon" type="image/x-icon">
  <link href="http://localhost/AdministradorLOB/public/images/webclip.png" rel="apple-touch-icon">
  <style type="text/css">
    .tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;margin:0px auto;}
    .tg td{font-family:Arial, sans-serif;font-size:14px;padding:13px 20px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;border-top-width:1px;border-bottom-width:1px;}
    .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:13px 20px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f3f3f3;border-top-width:0px;border-bottom-width:1px;}
    .tg .tg-e3zv{font-weight:bold; text-align:left;}
    @media screen and (max-width: 767px) {.tg {width: auto !important;}.tg col {width: auto !important;}.tg-wrap {overflow-x: auto;-webkit-overflow-scrolling: touch;margin: auto 0px;}}
  </style>
  
</head>
<body class="body-admin">
  <div class="top-panel">
    <div class="w-container">
        <div class="h-panel" id="logout" onclick="sesion_logout()">cerrar sesión</div>
    </div>
  </div>
 
  <div class="div-user-panel">
    <div class="container-textos-admin w-container">
      <h1 class="_1 title-panel-admin">Bienvenido</h1>
      <h1 class="title-panel-admin">Panel Registro de usuarios</h1>
    </div>
  </div>
     <div id="error" class="adx2099-error" hidden>
         <div><label id="mensaje">Consulta no valida, necesitas seleccionar un filtro válido, Recuerda que debes de seleccionar un rango de fechas</label></div>
      </div>
  <div class="section-filtros">
     
    <form class="filter-panel" data-name="filter_form" id="filter_form" name="filter_form" method="POST" action="http://localhost/AdministradorLOB/index.php/api/get_filter">
    <div class="container-filtros w-container">
        
      <div class="columnas-filtros w-row">
        <div class="c-filtro-fecha w-col w-col-5">
          <div class="div-fechas">
            <div class="label-filter-panel">Desde</div>
            <div class="input-field" >
                <input id="fechaIni" name="fechaIni" type="text" placeholder="Fecha" style="width: 136px;  border-radius: none; border-color: white">
            </div>
            <div class="label-filter-panel">Hasta</div>
            <div class="input-field">
              <input id="fechaFin" type="text" placeholder="Fecha Inicio" style="width: 136px;" >
            </div>
          </div>
        </div>
        <div class="c-filtro-sexo w-col w-col-7">
          <div class="form-filter-panel w-form">
              
              <label class="label-filter-panel" for="field">Sexo</label>
              <select class="input-filter-panel w-select" id="sexo" name="sexo">
                <option value="">Selecciona...</option>
                <option value="Hombr">Masculino</option>
                <option value="Mujer">Femenino</option>
              </select>
              <label class="label-filter-panel" for="field-2">Estado</label>
              <select class="input-filter-panel w-select" id="estado" name="estado">
                    <option value="">Selecciona...</option>
                    <option value="Aguascalientes">Aguascalientes</option>
                    <option value="Baja California">Baja California</option>
                    <option value="Baja California Sur">Baja California Sur</option>
                    <option value="Campeche">Campeche</option>
                    <option value="Coahuila de Zaragoza">Coahuila de Zaragoza</option>
                    <option value="Colima">Colima</option>
                    <option value="Chiapas">Chiapas</option>
                    <option value="Chihuahua">Chihuahua</option>
                    <option value="Distrito Federal">Distrito Federal</option>
                    <option value="Durango">Durango</option>
                    <option value="Guanajuato">Guanajuato</option>
                    <option value="Guerrero">Guerrero</option>
                    <option value="Hidalgo">Hidalgo</option>
                    <option value="Jalisco">Jalisco</option>
                    <option value="México">México</option>
                    <option value="Michoacán de Ocampo">Michoacán de Ocampo</option>
                    <option value="Morelos">Morelos</option>
                    <option value="Nayarit">Nayarit</option>
                    <option value="Nuevo León">Nuevo León</option>
                    <option value="Oaxaca">Oaxaca</option>
                    <option value="Puebla">Puebla</option>
                    <option value="Querétaro">Querétaro</option>
                    <option value="Quintana Roo">Quintana Roo</option>
                    <option value="San Luis Potosí">San Luis Potosí</option>
                    <option value="Sinaloa">Sinaloa</option>
                    <option value="Sonora">Sonora</option>
                              <option value="Tabasco">Tabasco</option>
                              <option value="Tamaulipas">Tamaulipas</option>
                              <option value="Tlaxcala">Tlaxcala</option>
                              <option value="Veracruz de Ignacio de la Llave">Veracruz de Ignacio de la Llave</option>
                              <option value="Yucatán">Yucatán</option>
                              <option value="Zacatecas">Zacatecas</option>
              </select>
              <input class="btn-black panel w-button" data-wait="Please wait..." type="submit" value="Aplicar">
            
          </div>
        </div>
      </div>
    </div>
  
  </form>
      
  </div>
  <div>
    <div class="w-container">
      <a class="link-block-exportar w-clearfix w-inline-block" href="#">
          <div class="btn-exportar" id="exportar_excel">Exportar Excel</div><img src="http://localhost/AdministradorLOB/public/images/export-1.png" width="25">
      </a>
        <a class="link-block-exportar w-clearfix w-inline-block" onclick="clearForm()" href="#">
        <div class="btn-exportar">Reiniciar búsqueda</div><img src="http://localhost/AdministradorLOB/public/images/refresh-icon.png" width="25">
      </a>
    </div>
  </div>
    
  <div class="div-adx2099-lob-panel">
      <h3>USUARIOS</h3>
      <div>
           Total de Usuarios:<label id="totalUsuarios" class="label-filter-panel">0</label>
      </div>
     
  
    <div class="tg-wrap">
        <table id="list_user" class="tg">
            <thead>
                <tr>
                    <th class="tg-e3zv">NOMBRE</th>
                    <th class="tg-e3zv">CORREO ELECTRÓNICO</th>
                    <th class="tg-e3zv">UBICACIÓN</th>
                    <th class="tg-e3zv">FECHA DE NACIMIENTO</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
                
            
        </table>
    </div>
    
  
  </div>
  <div class="div-logo-lob-panel"></div>
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
  <script src="http://localhost/AdministradorLOB/public/js/webflowJs/modernizr.js" type="text/javascript"></script>
  <script src="http://localhost/AdministradorLOB/public/js/webflowJs/webflow.js" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
</body>
</html>
<script>
    
	
    $(function() {
	$('#fechaIni').datepick({dateFormat: $.datepick.ATOM}, $.datepick.regionalOptions['es']);
        $('#fechaFin').datepick({dateFormat: $.datepick.ATOM}, $.datepick.regionalOptions['es']);
        $('#fechaIni').localise('js/jquery.datepick', 'es'); 
        $('#fechaIni').datepick('option', $.datepick.regionalOptions['es']);
        $('#fechaFin').localise('js/jquery.datepick', 'es'); 
        $('#fechaFin').datepick('option', $.datepick.regionalOptions['es']);
       
        $("#filter_form").submit(function(event){
            var fIni = $('#fechaIni').val();
            var fFin = $('#fechaFin').val();
            var sexo = $('#sexo').val();
            var estado = $('#estado').val(); 
            event.preventDefault();
            var url = $(this).attr('action');
            if(fIni === "" && fFin === "" && sexo === "" && estado === "" ){
                
                $("#error").show(); 
                setTimeout(function(){ 
                    $("#error").hide(); 
                }, 4000); 
                
            }else if(fIni === "" || fFin === ""){
                 $("#error").show(); 
                setTimeout(function(){ 
                    $("#error").hide(); 
                }, 4000); 
            }else{   
              
                var postData = {
                    "fecha_inicial":fIni,
                    "fecha_final":fFin,
                    "sexo":sexo,
                    "estado":estado
                 }
                 
                 //var postData = $(this).serialize();
                $.post(url,postData,function(object){  
                          
                    document.getElementById("totalUsuarios").innerHTML = object.length;   
                    var table =  document.getElementById("list_user").getElementsByTagName('tbody')[0];;
                    if(!jQuery.isEmptyObject(object)){
                        
                        var output = '';
                        for(var i = 0; i<object.length;i++){
                            //output += template_table(object[i]);
                            
                            var row = table.insertRow(i);
                            var cell1 = row.insertCell(0);
                            var cell2 = row.insertCell(1);
                            var cell3 = row.insertCell(2);
                            var cell4 = row.insertCell(3);
                            cell1.innerHTML = object[i].usuario_nombre +' '+ object[i].usuario_apellido;
                            cell2.innerHTML = object[i].usuario_email;
                            cell3.innerHTML = object[i].usuario_estado;
                            cell4.innerHTML = object[i].usuario_cumple;
      
                         }
          
                        
                        //$("#list_user").html(output);
                        
                     }else{
                         document.getElementById("mensaje").innerHTML = 'No se han encontrado resultados'
                         $("#error").show(); 
                            setTimeout(function(){ 
                            $("#error").hide(); 
                        }, 3000); 
            
                     }
                      
                },'json');
            }   
        });
        
        
    });
    
    $('#exportar_excel').click(function(){
        $('#list_user').table2excel({
            exclude: ".noExl",
            name: "Usuarios Registrados",
            filename: "Usuarios " + Date(),
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
	  });
    
    });
    
    function sesion_logout(){
		
	window.location.href = "http://localhost/AdministradorLOB/index.php/home/logout";
    } 
	
    function template(obj){
    
        var output = '';
        output += '<div id="'+ obj.usuario_id +'" >';
        output += '<span class="w-col w-col-3">' + obj.usuario_nombre +' '+ obj.usuario_apellido + '</span>';
        output += '<span class="w-col w-col-3">' + obj.usuario_email + '</span>';
        output += '<span class="w-col w-col-3">' + obj.usuario_estado + '</span>';
        output += '<span class="w-col w-col-3">' + obj.usuario_cumple + '</span>';
        output += '</div>';
        return output;
      
    }
    
    
    function template_table(obj){
        var output = '';
       
        output += '<tr>';
        output += '<td class="tg-031e">' + obj.usuario_nombre +' '+ obj.usuario_apellido +'</td>';
        output += '<td class="tg-031e">' + obj.usuario_email +'</td>';
	output += '<td class="tg-031e">' + obj.usuario_estado +'</td>';
        output += '<td class="tg-031e">' + obj.usuario_cumple +'</td>';
        output += '</tr>';
        
        return output;
    }
    
    function clearForm(){
        $('#fechaIni').val('') ;
        $('#fechaFin').val('');
        $('#sexo').val('');
        $('#estado').val('');
        document.getElementById("totalUsuarios").innerHTML = 0;
        var output = '';
        $("#list_user").html(output);
      
    }
    
    
</script>