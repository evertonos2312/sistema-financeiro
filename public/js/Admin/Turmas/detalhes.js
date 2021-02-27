var lnDias = 0;

/* DIAS CURSOS */
function addDiasCurso(saved)
{
	if(!!saved){
		var html = '<tr class="d-flex" id="dias_curso_ln'+lnDias+'">';
		html += '<td class="col-6 col-md-4 col-lg-3"><input class="form-control" type="text" name="dias_curso['+lnDias+']" ln_line="'+lnDias+'" disabled="disabled"/></td>';


		html += '</tr>';

		$('#dias_curso_tbody').append(html);

		$('input[name="dias_curso['+lnDias+']"]').val(saved);
		lnDias++;
	}
}

function openModalVagas()
{
	var bodyModal = $('#detalhesVagasModal').find('.modal-body');
	var html_body = `<div class="col-12 text-center">
	<p><img alt="Carregando..." src="${app_url}images/loading.gif" class="loading-icon" style="width: 3rem"/></p>
	<p>Aguarde... Estamos buscando informações das vagas...</p>
	</div>`;
	bodyModal.html(html_body);
	bodyModal.find('.loading-icon').show();
	$('#detalhesVagasModal').modal('show');

	$.ajax({
		url: app_url+'ajax_requests/getVagasTurma',
		dataType: 'json',
		method: 'post',
		headers: {
			'Content-Type': 'application/json',
			"X-Requested-With": "XMLHttpRequest"
		},
		data: JSON.stringify({
			id: record_id,
		}),
		success: function(d){
			var content = `
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Tipo</th>
						<th>Vagas</th>
						<th>Preenchido</th>
						<th>Disponível</th>
						<th>Vagas Lista de Espera</th>
						<th>Preenchido Lista de Espera</th>
						<th>Disponível Lista de Espera</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>Cliente</th>
						<td>${d.detail.cliente.vagas}</td>
						<td>${d.detail.cliente.preenchido}</td>
						<td>${d.detail.cliente.disponivel}</td>
						<td>${d.detail.cliente.vagas_lista}</td>
						<td>${d.detail.cliente.preenchido_lista}</td>
						<td>${d.detail.cliente.disponivel_lista}</td>
					</tr>
					<tr>
						<th>Visitante</th>
						<td>${d.detail.nao_cliente.vagas}</td>
						<td>${d.detail.nao_cliente.preenchido}</td>
						<td>${d.detail.nao_cliente.disponivel}</td>
						<td>${d.detail.nao_cliente.vagas_lista}</td>
						<td>${d.detail.nao_cliente.preenchido_lista}</td>
						<td>${d.detail.nao_cliente.disponivel_lista}</td>
					</tr>
				</tbody>
			</table>
			`;
			bodyModal.html(content);
		},
		error: function(d){
			bodyModal.html('<h4>Ops! Algo deu errado na busca das informações...</h4><p>Entre em contato com o administrador</p>');
		}
	})
}