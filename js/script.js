$(document).ready(function(){

console.log("documento js cargado");


$.post("http://localhost/bases/Welcome/getInmobiliariaController",
	{
	},
	function(data){
var c = JSON.parse(data);
$.each(c,function(i,item){
	$('#cboInmobiliarias').append('<option value='+item.idInmobiliaria+'>'+item.nombre+'</option>');
});
})



$('#cboInmobiliarias').change(function(){

$("#cargando").show();
var proyectos = [];
	
$('#cboInmobiliarias option:selected').each(function(){
id=$('#cboInmobiliarias').val();
});
$('#cboProyectos').html('');
$.post(baseurl+"Welcome/getProyectosController",
	{
		idInmobiliaria: id
	},
	function(data){
var c = JSON.parse(data);
$.each(c,function(i,item){
	$('#cboProyectos').append('<option value='+item.idProyecto+'>'+item.nombreM+'</option>');
	proyectos.push(item.idProyecto);

});
$('#cboProyectos').append('<option value='+proyectos+'>Todos</option>');
console.log("aqui estan los elementos:"+proyectos);
}).always(function() {
   $("#cargando").hide();
  });



});


 console.log("fin documento");
$("#cargando").fadeOut(1000);
});


