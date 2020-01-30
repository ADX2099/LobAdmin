<!DOCTYPE html>
<!--  This site was created in Webflow. http://www.webflow.com -->
<!--  Last Published: Sat Dec 17 2016 18:54:00 GMT+0000 (UTC)  -->
<html data-wf-page="582a3cfc69fd20902f667582" data-wf-site="57c06862922ca65171ab0b1c">
<head>
  <meta charset="utf-8">
  <title>Panel Admin Login</title>
  <meta content="Panel Admin Login" property="og:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta content="Webflow" name="generator">
  <link href="http://localhost/AdministradorLOB/public/css/webflow/normalize.css" rel="stylesheet" type="text/css">
  <link href="http://localhost/AdministradorLOB/public/css/webflow/webflow.css" rel="stylesheet" type="text/css">
  <link href="http://localhost/AdministradorLOB/public/css/webflow/lob.webflow.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
  <script type="text/javascript">
    WebFont.load({
      google: {
        families: ["Montserrat:400,700","Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic"]
      }
    });
  </script>
  <script src="http://localhost/AdministradorLOB/public/js/webflowJs/modernizr.js" type="text/javascript"></script>
  <link href="http://localhost/AdministradorLOB/public/images/ico-lob.png" rel="shortcut icon" type="image/x-icon">
  <link href="http://localhost/AdministradorLOB/public/images/webclip.png" rel="apple-touch-icon">
</head>
<body class="body-panel">
  <div class="w-container"><img class="logo-panel" src="http://localhost/AdministradorLOB/public/images/LOB-n.jpg">
    <div class="div-panel">
      <div class="form-w-panel w-form">
          <form data-name="login_form" id="login_form" name="login_form" method="POST" action="http://localhost/AdministradorLOB/index.php/api/login">
          <label class="label-panel" for="name">Usuario:</label>
          <input class="input-panel w-input" data-name="email_login" id="email_login" maxlength="256" name="email_login" placeholder="Enter your name" required="required" type="email">
          <label class="label-panel" for="Password">contraseña:</label>
          <input class="input-panel w-input" data-name="password" id="password" maxlength="256" name="password" placeholder="******" required="required" type="password">
          <input class="btn-black panel w-button" data-wait="Please wait..." type="submit" value="Entrar">
        </form>
        <div class="w-form-done">
          <div>Thank you! Your submission has been received!</div>
        </div>
        <div class="w-form-fail">
          <div>Oops! Something went wrong while submitting the form</div>
        </div>
      </div>
    </div>
  </div>
  <div class="copyright">2016. Developed with love by Arbiec</div>
  <script src="http://localhost/AdministradorLOB/public/js/jQuery/jquery-3.1.1.min.js" type="text/javascript"></script>
  
  <script src="http://localhost/AdministradorLOB/public/js/webflowJs/webflow.js" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
</body>
</html>
<script type="text/javascript"> 
    $(document).ready(function(){
        
        $("#login_form").submit(function(event){
            event.preventDefault();
            var url = $(this).attr('action');
            var postData = $(this).serialize();
            $.post(url,postData,function(object){
               if(object.result == 1){
                
			window.location.href = 'http://localhost/AdministradorLOB/index.php/panel';
		}else{
			
				
		}
            },'json');
       
        });
    });
</script>

