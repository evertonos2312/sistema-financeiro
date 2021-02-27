var lnDias = 0;
$('input[name="inicio"]').on('dp.change', function(e){
	toggleTermino();
	$('input[name="termino"]').data("DateTimePicker").minDate(e.date)
	$('input[name="max_cancelamento"]').data("DateTimePicker").maxDate(e.date)
});
$('input[name="termino"]').on('dp.change', function(e){
	var data_termino = new Date(moment($(this).val(), "DD/MM/YYYY HH:mm:ss"));
	var data_inicio = new Date(moment($('input[name="inicio"]').val(), "DD/MM/YYYY HH:mm:ss"));
	if(data_termino < data_inicio){
		$(this).val($('input[name="inicio"]').val());
	}
});
$('input[name="max_cancelamento"]').on('dp.change', function(e){
	var data_max = new Date(moment($(this).val(), "DD/MM/YYYY HH:mm:ss"));
	var data_inicio = new Date(moment($('input[name="inicio"]').val(), "DD/MM/YYYY HH:mm:ss"));
	if(data_max > data_inicio){
		$(this).val($('input[name="inicio"]').val());
	}
});
function toggleTermino()
{
	if($('input[name="inicio"]').val()){
		$('input[name="termino"]').data("DateTimePicker").enable();
		$('input[name="max_cancelamento"]').data("DateTimePicker").enable();
	}else{
		$('input[name="termino"]').data("DateTimePicker").disable();
		$('input[name="max_cancelamento"]').data("DateTimePicker").disable();
	}
}

function toggleTerminoDia(ln)
{
	if($('input[name="dias_curso_inicio['+ln+']"]').val()){
		$('input[name="dias_curso_termino['+ln+']"]').data("DateTimePicker").enable();
	}else{
		$('input[name="dias_curso_termino['+ln+']"]').data("DateTimePicker").disable();
	}
}
toggleTermino();

function changedCurso(data)
{
	
	$('select[name="imagem"]').html('');
	var hideFields = {
		'link': false,
		'local_nome': false,
		'imagem': false,
	};
	var showFields = [];
	if(data.id){
		$.ajax({
			url: app_url+'ajax_requests/getRegistro',
			dataType: 'json',
			method: 'post',
			headers: {
			  "Content-Type": "application/json",
			  "X-Requested-With": "XMLHttpRequest"
			},
			data: JSON.stringify({
				id: data.id,
				mdl: 'Cursos/Cursosmodel',
			}),
			success: function(d){
				
			},
			complete: function(d){
				var r = d.responseJSON;
				if(r.status == 'success'){
					if(!!r.detail){
						switch(r.detail.tipo){
							case 'videoaula':
								showFields = {
									'link': true,
									'imagem': false,
								};
								break;
							case 'presencial':
								showFields = {
									'local_nome': true,
									'imagem': false,
								};
								break;
							default:
								showFields = {
									'imagem': false,
								};
								break;
						}
						$.ajax({
							url: app_url+'ajax_requests/get_related',
							dataType: 'json',
							method: 'post',
							headers: {
							  "Content-Type": "application/json",
							  "X-Requested-With": "XMLHttpRequest"
							},
							data: JSON.stringify({
								model: 'Cursos_imagens/Cursos_imagensmodel',
								custom_where: "tipo = '"+r.detail.tipo+"' AND (status = 'ativo')",
							}),
							success: function(d){
								
							},
							complete: function(d){
								var r = d.responseJSON;
								var html_options = '<option value>Selecione..</option>';
								if(!!r && !!r.status){
									if(r.status == 'success'){
										r.detail.forEach(function(imagem){
											html_options += '<option value="'+imagem.id+'">'+imagem.label+'</option>';
										});
									}
								}
								$('select[name="imagem"]').html(html_options);
								if(savedImagem){
									$('select[name="imagem"]').val(savedImagem);
									savedImagem = null;
								}
							}
						});
					}
				}
				hideShowFields(hideFields, showFields);
			}
			
		});
	}else{
		hideShowFields(hideFields, showFields);
	}
}

//Bloquear campo de curso caso a turma já exista
if($('input[name="curso"]').val()){
	$('input[name="curso_nome"]').attr('readonly', true);
	$('input[name="curso"]').attr('readonly', true);
}

changedCurso({'id':$('input[name="curso"]').val(), 'nome':$('input[name="curso_nome"]').val()});

/* DIAS CURSOS */
function addDiasCurso(saved)
{
	var html = '<tr class="d-flex" id="dias_curso_ln'+lnDias+'">';
	html += '<td class="col-6 col-md-4 col-lg-3"><input class="form-control" type="text" name="dias_curso['+lnDias+']" ln_line="'+lnDias+'" readonly="true"/></td>';
	html += '<td class="col-2 col-md-8 col-lg-9"><button class="btn btn-danger delete-dias-cursos" type="button" onclick="$(\'#dias_curso_ln'+lnDias+'\').remove();">X</button>';
	
	
	html += '</tr>';
	
	$('#dias_curso_tbody').append(html);
	
	if(!!saved){
		$('input[name="dias_curso['+lnDias+']"]').val(saved);
	}
	calculateCargaHoraria();
	lnDias++;
}

function addDiasByPeriod()
{
	$('#dias_curso_tbody').html('');
	var inicio = $('input[name="inicio"]').val();
	var termino = $('input[name="termino"]').val();
	
	if(inicio && termino){
		var inicio_date = inicio.split(' ')[0].split('/');
		var inicio_date = new Date(inicio_date[2]+'-'+inicio_date[1]+'-'+inicio_date[0]+' 00:00:01');
		var termino_date = termino.split(' ')[0].split('/');
		var termino_date = new Date(termino_date[2]+'-'+termino_date[1]+'-'+termino_date[0]+' 23:59:59');
		
		var dates_between = getDates(inicio_date, termino_date);
		dates_between.forEach(function(data){
			addDiasCurso(formatDate(data));
		});
	}
}

function calculateCargaHoraria()
{
	var total_ln = $('input[name^="dias_curso"]').length;
	var inicio = $('input[name="inicio"]').val();
	var termino = $('input[name="termino"]').val();
	var total_horas = '00:00';
	if(inicio && termino){
		var datahora_termino = inicio.split(' ')[0]+' '+termino.split(' ')[1];
		var hora_inicio = new Date(moment(inicio, "DD/MM/YYYY HH:mm:ss"));
		var hora_fim = new Date(moment(datahora_termino, "DD/MM/YYYY HH:mm:ss"));
		
		var diff_seconds = ((hora_fim - hora_inicio) * total_ln) / 1000;
		var hours = Math.floor(diff_seconds / 60 / 60);
		var minutes = Math.floor(diff_seconds / 60) - (hours * 60);
		total_horas = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0');
	}
	$('input[name="carga_horaria"]').val(total_horas);
}
calculateCargaHoraria();

function blockMPFields()
{
	let block = [
		'inicio',
		'termino',
		'max_cancelamento',
		'periodo',
		'descricao',
		'status',
		'curso_nome',
		'carga_horaria',
	];
	$('.delete-dias-cursos').remove();
	$('#dias_curso_tbody').parent().find('tfoot').remove();
	$.each(block, function(idx, ipt){
		$('input[name="'+ipt+'"]').attr('disabled', true).after('<p class="required">Campo bloqueado!</p>');
		$('select[name="'+ipt+'"]').attr('disabled', true).after('<p class="required">Campo bloqueado!</p>');
		$('textarea[name="'+ipt+'"]').attr('disabled', true).after('<p class="required">Campo bloqueado!</p>');
	});
}