function previsualizacion_img(input_file) 
{
	$.each(input_file.files, function(itr, file)
	{
		if (file.name.length>0) 
		{
			if (!file.type.match('image.*')) // Solo previsualiza imagenes
				return true; 
			else
			{
				//Remueve las previsualizadas anteriormente para agregar las nuevas.
				
				// Por ahora no tengo muy claro como jugar con el input file (agregando, removiendo), 
				// ficheros directamente desdes js/ajax usando yii2, pues este no responde demasiado bien
				// de la forma que lo estoy haciendo...
				
			   $('#previsualizador').html(''); 
			   
			   var reader = new FileReader();
			   
			   reader.onload = function(e) 
			   {
				   $('#previsualizador').append(
				   '<li id="id_'+itr+'" class="imagen_miniatura"><a href="javascript:void(0)" onclick="ver_imagen(this);"> \
				   <img class="imagen_style" src="' + e.target.result + '" \
				   title="'+ escape(file.name) +'" /></a><br /></li>');
			   }
			   reader.readAsDataURL(file);
		   }
		}
		else {  return false; }
	});
}

function previsualizar_imagen(ruta_imagen) 
{	
   //$('#previsualizador').html(''); 
   
   //Creamos un div, cuya clase sea imagen_miniatura
    var div = document.createElement('li');
    div.className = 'imagen_miniatura';
   
   //Agregamos el código referente a la imagen como html.
   div.innerHTML ='<a href="javascript:void(0)" onclick="ver_imagen(this);"><img class="imagen_style" src="' + ruta_imagen + '" /></a><br />';
 
	//Insertamos este nuevo div, en el previsualizador.
   document.getElementById('previsualizador').appendChild(div);

}

function ver_imagen(imagen) 
{	
	var div = document.createElement("div");
		div.className = 'imagen_backdrop';
		
	document.body.appendChild(div);

	div = document.createElement("div");
	div.className = 'div_imagen_centrada';
	div.innerHTML ='<div class="imagen_centrada_vertical" onclick="retirar_visor(event);"><img src="'+imagen.getElementsByTagName('img')[0].src+'"></img></div>';
	document.body.appendChild(div);
	
}

function retirar_visor(ev) 
{	
	if($(ev.target).attr('class') == "imagen_centrada_vertical")
	{
		$(".imagen_backdrop").remove();
        $(".div_imagen_centrada").remove(); 
	}
	
}





