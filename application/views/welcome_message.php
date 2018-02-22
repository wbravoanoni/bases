<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<style>
	.btnEnviar{
	padding-top: 20px;
	}	
</style>

</head>
<body>
<h1 class="text-center">Descarga</h1>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-4 col-lg-offset-4">
<form action="<?php echo base_url()?>Welcome/descarga" method="POST">
<div class="form-group">
	<label for="cboInmobiliarias">Inmobiliaria</label>
	<select class="form-control" name="idInmo" id="cboInmobiliarias">
			<option value="-1" disable="disable" selected disabled>Seleccione una Inmobiliaria
			</option>
	</select>
</div>

<div class="form-group">
	<label for="cboProyectos">Proyectos</label>
	<select class="form-control" name="idProy" id="cboProyectos">
			<option disabled value="-1" disable="disable" selected disabled>Seleccione un Proyecto
			</option>
	</select>
</div>

<div class="form-group">
	<label for="tipoDescarga">Tipo Descarga</label>
	<select class="form-control" name="idTipo" id="tipoDescarga">
		<option value="" selected disabled>Seleccione el tipo de base</option>
		<option value="1">Categorizados</option>
		<option value="2">Promesas</option>
		<option value="3">Cotizaciones</option>
	</select>
</div>

<div class="form-group">
	<label for="fechaInicio">Fecha Inicio</label>
	<input id="fechaInicio" name="fIni" class="form-control" type="date">
</div>

<div class="from-group">
	<label for="fechaTermino">Fecha Termino</label>		
	<input id="fechaTermino" name="fTer" class="form-control" type="date">	
</div>

<div class="from-group btnEnviar">
	<button class="btn btn-success">Ejecutar</button>	
</div>			
</form>
			</div><!--col-lg-4-->
		</div><!--col-lg-12-->
	</div><!--row-->
</div><!--container-->
		
<p id="totalProyectos"></p>


<script> var baseurl="<?php echo base_url();?>"</script>

<script
  src="http://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script src="<?php echo base_url()?>js/script.js"></script>
</body>
</html>