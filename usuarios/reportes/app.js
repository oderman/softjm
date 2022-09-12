var estadosm = ["","NC","NE","EP","IN","AC","PR"];
var emColor = ["white","goldenrod","gold","green","limegreen","aqua","tomato"];

function mercadeo(datos){
	
	var em = datos.title;
	var cliente = datos.name;
	
	document.getElementById("proceso"+cliente).style.backgroundColor=emColor[em];
	document.getElementById("proceso"+cliente).innerHTML=estadosm[em];
	
	document.getElementById("upm"+cliente).innerHTML= new Date() + `<br>YO`;
		
	if(em == 3){
	  	window.open('../enviar-portafolios.php?cte='+cliente+'&em='+em, '_blank');
	 }
	
	if(em == 4){
	  	window.open('../clientes-tikets-agregar.php?cte='+cliente+'&em='+em+'&origenNegocio=1', '_blank');
	 }
	
	if(em == 7){
	  	document.getElementById("filaClientes"+cliente).style.display="none"; 
	 }
	
	
	
	
		
	 $('#resp').empty().hide().html("esperando...").show(1);
		datos = "em="+(em)+
				"&cliente="+(cliente);
			   $.ajax({
				   type: "POST",
				   url: "ajax-clientes-mercadeo.php",
				   data: datos,
				   success: function(data){
				   $('#resp').empty().hide().html(data).show(1);
				   }
			   });
	
}