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
				   '<li id="id_'+itr+'" class="imagen_miniatura"><a href=""> \
				   <img class="imagen_style" src="' + e.target.result + '" \
				   title="'+ escape(file.name) +'" /></a><br /></li>');
			   }
			   reader.readAsDataURL(file);
		   }
		}
		else {  return false; }
	});
}
