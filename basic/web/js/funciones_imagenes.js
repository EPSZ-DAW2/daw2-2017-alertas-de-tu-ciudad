function previsualizacion_img(input_file) 
{
	//var id = 1, last_id = last_cid = '';
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
				   '<div id="id_'+itr+'" class="imagen_miniatura"> \
				   <img class="imagen_style" class="img-thu" src="' + e.target.result + '" \
				   title="'+ escape(file.name) +'" /><br /></div>');
			   }
			   reader.readAsDataURL(file);
		   }
		}
		else {  return false; }
	});
}