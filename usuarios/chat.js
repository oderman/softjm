var firebaseConfig = {
	apiKey: "AIzaSyDHmrIJopg3fEC65-reL_E-Xz4CIphSCZE",
	authDomain: "javascript-59556.firebaseapp.com",
	databaseURL: "https://javascript-59556.firebaseio.com",
	projectId: "javascript-59556",
	storageBucket: "javascript-59556.appspot.com",
	messagingSenderId: "52334748441",
	appId: "1:52334748441:web:23b52ab6b92259fc689b88"
};
firebase.initializeApp(firebaseConfig);

var database = firebase.database();


function getId(id){ return document.getElementById(id).value; }

function limpiar(id, result){ document.getElementById(id).value=result; }

function arrayJSON(origen, destino, mensaje, fecha){
	var data = {
		origen,
		destino,
		mensaje,
		fecha
	};
	return data;
}


function insertar(){
	var num = (Math.random()*1000000);
	
	var id = Math.floor(num);
	var origen = getId("origen");
	var destino = getId("destino");
	var mensaje = getId("mensaje");
	var fecha = new Date();
	
	var arrayData = arrayJSON(origen, destino, mensaje, fecha);
	
	var carpeta = origen.concat(destino);
	var chat = database.ref("chat/"+carpeta+"/"+id);
	
	chat.set(arrayData)
		.then(function() {
			limpiar("mensaje", "");
     	})
		.catch(function(error) {
			console.log('detectado un error', error);
     });
}


function listarTareas(datos){
	document.getElementById("listarDatos").innerHTML="";
	var carpeta = datos.name.concat(datos.id);
	limpiar("destino", datos.id);
	var tarea = database.ref("chat/"+carpeta+"/").orderByChild('mensaje');

	tarea.on("child_added",function(data){
		var chatValue = data.val();
		
		var orientacionDiv = "";
		var orientacionUsuario = "pull-left";
		
		var nombreOrigen = document.getElementById("nombreOrigen").value;
		
		if(datos.name == chatValue.destino){
		   	orientacionDiv = "right-align";
			orientacionUsuario = "pull-right";
		 }
		   
		document.getElementById("listarDatos").innerHTML+=
			`
			<div class="conversation `+orientacionDiv+`">
				<a href="#" class="`+orientacionUsuario+` media-thumb"><img src="images/item-pic.png" width="34" height="34" alt="user"></a>
				<div class="conversation-body ">
					<h4 class="conversation-heading">`+nombreOrigen+` dice:</h4>
					<p>`
						+ chatValue.mensaje +
					`	
					</p>
				</div>
			</div>`
			;
	});
}


function eliminar(key){
	database.ref("chat/"+key).remove();
}


//window.addEventListener('load', listarTareas, false);

















