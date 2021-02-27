var lnFeedbacks = 0;


function addPergunta()
{
	var html = '<tr class="pergunta-ln'+lnFeedbacks+'">';
	html += '<td style="width: 5%"><input type="hidden" name="feedbacks_perguntas_id['+lnFeedbacks+']" value="" /><input type="hidden" name="feedbacks_perguntas_deletado['+lnFeedbacks+']" value="0" /><button class="btn btn-danger" type="button" onclick="deletePergunta('+lnFeedbacks+')">X</button></td>';
	html += '<td style="width: 70%"><input type="text" class="form-control" name="feedbacks_perguntas['+lnFeedbacks+']" value="" required="true"/></td>';
	html += '<td style="width: 25%"><select name="feedbacks_perguntas_tipo['+lnFeedbacks+']" class="form-control" required="true"><option value>Selecione</option><option value="texto">Texto</option><option value="nota">Nota (Péssimo, Ruim, Boa, Ótimo, Perfeito)</option></select></td>';
	html += '</tr>';
	
	$('#tbody_perguntas').append(html);
	
	lnFeedbacks++;
	
	return lnFeedbacks - 1;
}

function deletePergunta(ln)
{
	$('.pergunta-ln'+ln).hide();
	$('input[name="feedbacks_perguntas_deletado['+ln+']"]').val('1');
}