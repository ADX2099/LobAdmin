<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<title>jQuery Datepicker</title>
<link href="http://localhost/AdministradorLOB/public/widgets/jquery.datepick/css/jquery.datepick.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://localhost/AdministradorLOB/public/widgets/jquery.datepick/js/jquery.plugin.min.js"></script>
<script src="http://localhost/AdministradorLOB/public/widgets/jquery.datepick/js/jquery.datepick.js"></script>
<script type="text/javascript" src="http://localhost/AdministradorLOB/public/widgets/jquery.datepick/js/jquery.datepick-es.js"></script>
<script>
    $(function() {
        $('#popupDatepicker').datepick({dateFormat: $.datepick.ATOM});
	
        $('#inlineDatepicker').datepick($.extend({ 
            
             altFormat: 'DD, d MM, yyyy',
             onSelect: showDate},
             $.datepick.regionalOptions['es']));
             
          $('#inlineDatepicker').localise('js/jquery.datepick', 'es'); 
          $('#inlineDatepicker').datepick('option', $.datepick.regionalOptions['es']); 
         
    });

function showDate(date) {
	alert('The date chosen is ' + date);
}
</script>
</head>
<body>
<h1>jQuery Datepicker</h1>
<p>This page demonstrates the very basics of the
	<a href="http://keith-wood.name/datepick.html">jQuery Datepicker plugin</a>.
	It contains the minimum requirements for using the plugin and
	can be used as the basis for your own experimentation.</p>
<p>For more detail see the <a href="http://keith-wood.name/datepickRef.html">documentation reference</a> page.</p>
<p>A popup datepicker <input type="text" id="popupDatepicker"></p>
<p>Or inline</p>
<div id="inlineDatepicker"></div>
	<dl>
		<dt>Github</dt><dd><a href="https://github.com/kbwood/datepick">https://github.com/kbwood/datepick</a></dd>
		<dt>Bower</dt><dd>kbw-datepick</dd>
	</dl>
</body>
</html>
