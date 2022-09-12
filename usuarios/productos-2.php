<HTML>
<HEAD>
<TITLE>TABLA CON SCROLL</TITLE>
<SCRIPT language= "JavaScript">
var ancho1,ancho2,i;
var columnas=5; //CANTIDAD DE COLUMNAS//

function ajustaCeldas(){
for(i=0;i<columnas;i++){
ancho1=document.getElementById("encabezado").rows.item(0).cells.item(i).offsetWidth;
ancho2=document.getElementById("datos").rows.item(0).cells.item(i).offsetWidth;
if(ancho1>ancho2){
document.getElementById("datos").rows.item(0).cells.item(i).width = ancho1-6};
else{
document.getElementById("encabezado").rows.item(0).cells.item(i).width = ancho2-6;}
}
}
</SCRIPT>
<STYLE>
#encabezado{border:0}
#encabezado th{border-width:1px}
#datos{border:0}
#datos td{border-width:1px}
</STYLE>

</HEAD>

<BODY onload=ajustaCeldas()>

<h2>Tabla con desplazamiento y encabezado fijo.</h2>
Para <b>IE</b>.
<p>

<table border=1 bgcolor=scrollbar align=center>
<td>
<table id="encabezado" border=1 cellspacing=0 cellpadding=2 bgcolor=#cccccc>
<tr>
<th>A </th><th>B </th><th>C </th><th>D </th><th>E </th>
</tr>
</table>

<div style="overflow:auto; height:100px; padding:0">

<table border=1 cellspacing=0 cellpadding=2 id="datos" bgcolor=white><tr>
<td>q</td><td>qwerty</td><td>qwerty</td><td>qwerty</td><td>qwertyuiop</td>
</tr><tr>
<td>q</td><td>qwerty</td><td>qwerty</td><td>qwerty</td><td>qwertyuiop</td>
</tr><tr>
<td>q</td><td>qwerty</td><td>qwerty</td><td>qwerty</td><td>qwertyuiop</td>
</tr><tr>
<td>q</td><td>qwerty</td><td>qwerty</td><td>qwerty</td><td>qwertyuiop</td>
</tr><tr>
<td>q</td><td>qwerty</td><td>qwerty</td><td>qwerty</td><td>qwertyuiop</td>
</tr><tr>
<td>q</td><td>qwerty</td><td>qwerty</td><td>qwerty</td><td>qwertyuiop</td>
</tr><tr>
<td>q</td><td>qwerty</td><td>qwerty</td><td>qwerty</td><td>qwertyuiop</td>
</tr><tr>
<td>q</td><td>qwerty</td><td>qwerty</td><td>qwerty</td><td>qwertyuiop</td>
</tr><tr>
<td>q</td><td>qwerty</td><td>qwerty</td><td>qwerty</td><td>qwertyuiop</td>
</tr><tr>
<td>q</td><td>qwerty</td><td>qwerty</td><td>qwerty</td><td>qwertyuiop</td>
</tr>
</table>

</div>

</td>
</table>

</BODY>
</HTML>