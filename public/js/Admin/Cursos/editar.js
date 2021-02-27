var old_categoria = $('input[name="categoria"]').val();
function SelectedCategoria(data){
	if(data.id !== old_categoria || data.id == '' || old_categoria == ''){
		$('input[name="subcategoria_nome"]').val('');
		$('input[name="subcategoria"]').val('');
	}
	old_categoria = data.id;
}