function SelectedCategoria(data){
    let categoria_id = $('input[name="categoria"]').val();
    console.log(categoria_id);
    $('select[name="status"]').val('ativo');
    $('select[name="status"]').attr('readonly', false);
    if(categoria_id){
        $.ajax({
            url: app_url+'ajax_requests/getRegistro',
            dataType: 'json',
            method: 'post',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            data: JSON.stringify({
                id: categoria_id,
                mdl: 'Categorias/Categoriasmodel' 

            }),
            success: function(d){

            },
            complete: function(d){
                let r = d.responseJSON;
                if(!!r.status){
                    if(r.status == 'success'){
                        if(r.detail){
                            if(r.detail.status == 'inativo'){
                                $('select[name="status"]').val('inativo');
                                $('select[name="status"]').attr('readonly', true);
                            }
                        }
                    }
                }
            }
        })
    }
}
SelectedCategoria();