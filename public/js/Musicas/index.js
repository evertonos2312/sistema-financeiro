$('.row-data-select').each(function(){
	$(this).click(function(){
		OpenModalSelected($(this).attr('data-row-id'));
	});
	
});
function OpenModalSelected(id){
	var row = $('tr[data-row-id="'+id+'"');
	const codigo = row.find('td[data-row-codigo]').attr('data-row-codigo');
	const nome = row.find('td[data-row-nome]').attr('data-row-nome');
	$('#IdInsertModal').val(id);
	$('#SelectedRowModalLabel').html('['+codigo+'] '+nome);
	$('#SelectedRowModal').modal('show');
}
$('#InsertFilaBtn').click(function(){
	$('#SelectedRowModal').modal('hide');
	Swal.fire({
		title: 'Deseja colocar esta música na fila?',
		text: '',
		icon: 'question',
		// width: '400px',
		showConfirmButton: true,
		confirmButtonText: 'Sim',
		showCancelButton: true,
		cancelButtonText: 'Não',
		showLoaderOnConfirm: true,
		preConfirm: () => {
			return fetch(app_url+'musicas/insert_fila_ajax',
				{
					method: 'POST',
					body: JSON.stringify({ 
						'id': $('#IdInsertModal').val(),
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
				title: 'Música inserida na fila com sucesso!',
				text: '',
				icon: 'success',
				width: '400px',
				showConfirmButton: false,
				timer: 1000,
				timerProgressBar: true
			})
		}else{
			Swal.fire({
				title: 'Erro ao realizar a ação',
				text: result.value.detail,
				icon: 'error',
				width: '400px',
			})
			
		}
	});
});
$('#ImportModalLink').change(function(){
	
	$('#ImportModalLink').removeClass('invalid-value');
	$('#ImportModalLink').parent().find('.validation-error').remove();
	$('#ImportMusicaButton').prop('disabled', true);
	$('#ImportMusicaAndFilaButton').prop('disabled', true);
	
	if($(this).val() !== ''){
		swal.fire({
			title: 'Procurando...',
			onBeforeOpen: () => {
				swal.showLoading();
				$.ajax({
					'url': app_url+'musicas/CheckImportVideo',
					dataType: 'json',
					method: 'POST',
					headers: {
					  "Content-Type": "application/json",
					  "X-Requested-With": "XMLHttpRequest"
					},
					data: JSON.stringify({ 
						'link': $('#ImportModalLink').val(),
					}),
					success: function(d){
						swal.close();
					},
					complete: function(d){
						var r = d.responseJSON;
						if(!!r.status){
							if(r.status == 'success'){
								$('#ImportModalLinkTitleDiv').html('<label>Nome</label><input type="hidden" id="ImportModalLinkMD5" name="ImportModalLinkMD5" value="'+r.detail.md5+'"/><input class="form-control" type="text" id="ImportModalLinkTitle" name="ImportModalLinkTitle" value="'+r.detail.title+'"/>');
								$('#ImportMusicaButton').prop('disabled', false);
								$('#ImportMusicaAndFilaButton').prop('disabled', false);
							}else{
								$('#ImportModalLink').addClass('invalid-value').after('<span class="validation-error required">'+r.detail+'</span>');
							}
						}
						swal.close();
						
					}
				});
			},
		});
	}
}).change();
$('#ImportMusicaButton, #ImportMusicaAndFilaButton').click(function(){
	if($(this).prop('disabled') || !$('#ImportModalLinkTitle').length || !$('#ImportModalLinkMD5').length){
		return;
	}
	$('#ImportModal').modal('hide');
	swal.fire({
		title: 'Importando...',
		onBeforeOpen: () => {
			swal.showLoading();
			$.ajax({
				'url': app_url+'musicas/ImportVideoUrl',
				dataType: 'json',
				method: 'POST',
				headers: {
				  "Content-Type": "application/json",
				  "X-Requested-With": "XMLHttpRequest"
				},
				data: JSON.stringify({ 
					'link': $('#ImportModalLink').val(),
					'md5': $('#ImportModalLinkMD5').val(),
					'title': $('#ImportModalLinkTitle').val(),
					'auto_fila': ($(this).attr('id') == 'ImportMusicaAndFilaButton') ? true : false,
				}),
				success: function(d){
					swal.close();
				},
				complete: function(d){
					var r = d.responseJSON;
					swal.close();
					if(!!r){
						if(r.status == 'success'){
							let title_sa_fire = 'Música importada';
							if(r.detail.auto_fila){
								title_sa_fire += " e colocada na fila";
							}
							Swal.fire({
								title: title_sa_fire,
								text: r.detail.saved_record.nome,
								icon: 'success',
								width: '400px',
								showConfirmButton: false,
								timer: 1000,
								timerProgressBar: true,
								onClose: () => {
									$('#filtroForm').submit();
								}
							});
						}else{
							Swal.fire({
								title: 'Erro ao importar a música!',
								text: r.detail,
								icon: 'error',
								width: '400px',
							});
						}
					}else{
						Swal.fire({
							title: 'Erro ao importar a música',
							text: '',
							icon: 'error',
							width: '400px',
						});
					}
				}
			});
		},
	});
});