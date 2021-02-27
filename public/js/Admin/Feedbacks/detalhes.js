var lnFeedbacks = 0;


function addPergunta()
{
	var html = '<tr class="pergunta-ln'+lnFeedbacks+'">';
	html += '<td style="width: 70%"><input type="text" class="form-control" name="feedbacks_perguntas['+lnFeedbacks+']" value="" required="true" disabled/></td>';
	html += '<td style="width: 30%"><select disabled name="feedbacks_perguntas_tipo['+lnFeedbacks+']" class="form-control" required="true"><option value>Selecione</option><option value="texto">Texto</option><option value="nota">Nota (Péssimo, Ruim, Boa, Ótimo, Perfeito)</option></select></td>';
	html += '</tr>';
	
	$('#tbody_perguntas').append(html);
	
	lnFeedbacks++;
	
	return lnFeedbacks - 1;
}