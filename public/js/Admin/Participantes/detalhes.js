function requiredField(){
    $('input[name="data_bloqueio"]').attr('required', true);
    $('textarea[name="motivo_bloqueio"]').attr('required', true);
}


function unblockUser(data) {
    let user_id = $('input[name="user_id"]').val();
    let user_name = $('input[name="user_name"]').val();
    Swal.fire({
        title: 'Desbloquear ' + user_name + '?',
        text: "",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Desbloquear'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: app_url+'admin/participantes/blockUser',
                method: 'post',
                data: ({
                    id: user_id
                }),
                success: function(data){
                    location.reload('/admin/participantes/detalhes/'+user_id);
                }
            });
        }
    })
}
