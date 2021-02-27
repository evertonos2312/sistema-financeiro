function ValidationInputs(elm){
    showLoadingIcon(elm);
    if($('#enviar_emails_espera').find('input:checked').length < 1){
        Swal.fire({
            title: 'Ops!',
            text: 'Selecione pelo menos um participante para enviar o convite!',
            icon: 'info'
        });
        hideLoadingIcon(elm);
        return;
    }

    if(!$('input[name="turma"]').val()){
        Swal.fire({
            title: 'Ops! Ocorreu um erro',
            text: 'Não foi possível identificar a turma!',
            icon: 'error'
        });
        hideLoadingIcon(elm);
        return;
    }
    $('#enviar_emails_espera').trigger('submit');
}