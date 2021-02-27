function OpenModalReset()
{
	if(!$('#login').val()){
		Swal.fire({
			title: 'Digite o nome de usuário!',
			text: '',
			icon: 'info',
			width: '400px',
		});
		return;
	}
	Swal.fire({
		title: 'Deseja enviar o email para recuperação de senha?',
		text: "O email será enviado para o email cadastrado em "+$('#login').val(),
		icon: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Sim',
		cancelButtonText: 'Não',
		preConfirm: () => {
			return fetch(app_url+'admin/login/send_forget_pass',
				{
					method: 'POST',
					body: JSON.stringify({ 
						'usuario': $('#login').val(),
					}),
					headers: {
					  "Content-Type": "application/json",
					  "X-Requested-With": "XMLHttpRequest"
					}
				}).then(response => {
					if (!response.ok) {
						throw new Error(response.statusText);
					}
				return response.json();
			}).catch(error => {
				Swal.showValidationMessage('Erro ao realizar a ação');
			});
		},
		}).then((result) => {
			if(result.value.status == 'success'){
				Swal.fire({
					title: 'Email de recuperação de senha enviado com sucesso!',
					text: 'O email foi enviado para: '+result.value.detail,
					icon: 'success',
					width: '400px',
					showConfirmButton: false,
					timer: 1000,
					timerProgressBar: true
				})
			}else{
				Swal.fire({
					title: 'Erro ao enviar o email!',
					text: result.value.detail,
					icon: 'error',
					width: '400px',
				})
				
			}
		}
	);
}