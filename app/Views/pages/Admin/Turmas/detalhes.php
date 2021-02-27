{if $save_data_errors.generic_error}
<div class="row">
	<div class="col-12">
		<p class="required">{$save_data_errors.generic_error}</p>
	</div>
</div>
{/if}
<input type="hidden" name="id" value="{$record.id}" />
<div class="row">
	<div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2">
		{$layout.dropdown.status}
	</div>
</div>
<div class="row">
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
		{$layout.related.curso}
	</div>
	<div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4">
		{$layout.related.imagem}
	</div>
</div>
<div class="row">
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
		{$layout.link.link}
	</div>
</div>
<div class="row">
	<div class="col-12">
		<h5 class="panel-name">Duração da Turma</h5>
	</div>
</div>
<div class="row">
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
		{$layout.dropdown.periodo}
	</div>
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
		{$layout.datetime.inicio}
	</div>
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
		{$layout.datetime.termino}
	</div>
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
		{$layout.time.carga_horaria}
	</div>
</div>
<div class="row">
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
		<label for="dias_curso">Dias Curso</label>
		<table class="table">
			<thead>
				<tr class="d-flex">
					<th scope="col" class="col-5 col-md-3 col-lg-2">Início</th>
					<th scope="col" class="col-2 col-md-9 col-lg-10">&nbsp;</th>
				</tr>
			</thead>
			<tbody id="dias_curso_tbody">
			</tbody>
		</table>
	</div>
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
		{$layout.datetime.max_cancelamento}
	</div>
</div>
<div class="row">
	<div class="col-12">
		<h5 class="panel-name">Dados Administração</h5>
	</div>
</div>
<div class="row">
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
		{$layout.related.instrutor}
	</div>
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
		{$layout.related.moderador}
	</div>
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
		{$layout.related.local}
	</div>
</div>
<div class="row">
	<div class="col-12">
		<h5 class="panel-name">Dados do Curso</h5>
	</div>
</div>
<div class="row">
	<div class="col-12">
		{$layout.bool.destaque}
	</div>
</div>
<div class="row">
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
		{$layout.text.descricao}
	</div>
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
		{$layout.text.pre_requisitos}
	</div>
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
		{$layout.text.objetivo}
	</div>
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
		{$layout.text.aviso}
	</div>
</div>
<div class="row">
	<div class="col-12">
		<h5 class="panel-name">Dados Clientes</h5>
	</div>
</div>
<div class="row">
	<div class="col-6">
		{$layout.int.vagas_cliente}
	</div>
	<div class="col-6">
		{$layout.int.vagas_nao_cliente}
	</div>
</div>
<div class="row">
	<div class="col-6">
		{$layout.int.vagas_lista_cliente}
	</div>
	<div class="col-6">
		{$layout.int.vagas_lista_nao_cliente}
	</div>
</div>
<div class="row">
	<div class="col-6">
		{$layout.currency.valor_cliente}
	</div>
	<div class="col-6">
		{$layout.currency.valor_nao_cliente}
	</div>
</div>
<div class="row">
	<div class="col-12">
		<h5 class="panel-name">Outros</h5>
	</div>
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
		{$layout.varchar.capacitora_registro_cfc}
	</div>
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
		{$layout.varchar.pontuacao_epc}
	</div>
</div>
<div class="row">
	<div class="col-12">
		<hr />
	</div>
</div>
<div class="row">
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
		{$layout.datetime.data_criacao}
	</div>
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
		{$layout.related.usuario_criacao}
	</div>
</div>
<div class="row">
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
		{$layout.datetime.data_modificacao}
	</div>
	<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
		{$layout.related.usuario_modificacao}
	</div>
</div>
<div class="row">
	<div class="col-12">
		<a href="{$app_url}admin/turmas/editar/{$record.id}" class="btn btn-success margin-5"><i class="fas fa-edit"></i> Editar</a>
		<button type="button" class="btn btn-info margin-5" onclick="openModalVagas()"><i class="fas fa-plus"></i> Detalhes de Vagas</button>
		<a href="{$app_url}admin/turmas/lista_espera/{$record.id}" class="btn btn-primary margin-5"><i class="fas fa-clock"></i> Lista de Espera</a>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<hr />
	</div>
</div>
<div class="row">
	<div class="col-12">
		{literal}
		<script type="text/javascript">
		SubpanelsCfg['collapseSubpanel_turmas_inscritos'] = {
			'location_to': 'admin/participantes/detalhes/',
			'model': 'Admin/Turmas_inscritos/Turmas_inscritosmodel',
			'id': 'collapseSubpanel_turmas_inscritos',
			'per_page': 5,
			'fields_return': {
				'participante': '',
				'status': '',
				'data_cancelamento': '',
				'data_modificacao': '',
			},
			'initial_filter': {
				'turma': '{/literal}{$record.id}{literal}',
				'status': 'inscrito'
			},
			'initial_order_by': {
				'field': 'data_modificacao',
				'order': 'DESC',
			},
		};
		</script>
		{/literal}
		<h5 class="pointer" data-toggle="collapse" id="collapseSubpanel_turmas_inscritos_btn" href="#collapseSubpanel_turmas_inscritos" onclick="ToggleSubpanel(this, 'collapseSubpanel_turmas_inscritos')" role="button" aria-expanded="false" data-target=".collapseSubpanel_turmas_inscritos" aria-controls="collapseSubpanel_turmas_inscritos collapseSubpanel_turmas_inscritos_pagination">
			Participantes Inscritos <i class="fas fa-chevron-down"></i> <img alt="Carregando..." class="loading-icon" src="{$app_url}images/loading.gif" />
		</h5>
		<script type="text/javascript">$('#collapseSubpanel_turmas_inscritos_btn').click();</script>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<hr />
	</div>
</div>
<div class="row">
	<div class="col-12">
		{literal}
		<script type="text/javascript">
		SubpanelsCfg['collapseSubpanel_turmas_inscritos_cancelados'] = {
			'location_to': 'admin/participantes/detalhes/',
			'model': 'Admin/Turmas_inscritos/Turmas_inscritosmodel',
			'id': 'collapseSubpanel_turmas_inscritos_cancelados',
			'per_page': 5,
			'fields_return': {
				'participante': '',
				'status': '',
				'data_cancelamento': '',
				'data_modificacao': '',
			},
			'initial_filter': {
				'turma': '{/literal}{$record.id}{literal}',
				'status': 'cancelado'
			},
			'initial_order_by': {
				'field': 'data_modificacao',
				'order': 'DESC',
			},
		};
		</script>
		{/literal}
		<h5 class="pointer" data-toggle="collapse" id="collapseSubpanel_turmas_inscritos_cancelados_btn" href="#collapseSubpanel_turmas_inscritos_cancelados" onclick="ToggleSubpanel(this, 'collapseSubpanel_turmas_inscritos_cancelados')" role="button" aria-expanded="false" data-target=".collapseSubpanel_turmas_inscritos_cancelados" aria-controls="collapseSubpanel_turmas_inscritos_cancelados collapseSubpanel_turmas_inscritos_cancelados_pagination">
			Participantes Cancelados <i class="fas fa-chevron-down"></i> <img alt="Carregando..." class="loading-icon" src="{$app_url}images/loading.gif" />
		</h5>
		<!-- <script type="text/javascript">$('#collapseSubpanel_turmas_inscritos_cancelados_btn').click();</script> -->
	</div>
</div>
<div class="row">
	<div class="col-12">
		<hr />
	</div>
</div>
<div class="row">
	<div class="col-12">
		{literal}
		<script type="text/javascript">
		SubpanelsCfg['collapseSubpanel_cursos_lista_espera'] = {
			'location_to': 'admin/cursos_lista_espera/detalhes/',
			'model': 'Admin/Cursos_lista_espera/Cursos_lista_esperamodel',
			'id': 'collapseSubpanel_cursos_lista_espera',
			'per_page': 5,
			'fields_return': {
				'participante': '',
				'semana': '',
				'periodo_semana': '',
				'sabado': '',
				'data_criacao': '',
			},
			'initial_filter': {
				'curso': '{/literal}{$record.curso}{literal}',
				'turma': '{/literal}{$record.id}{literal}',
			},
			'initial_order_by': {
				'field': 'data_criacao',
				'order': 'DESC',
			},
		};
		</script>
		{/literal}
		<h5 class="pointer" data-toggle="collapse" id="collapseSubpanel_cursos_lista_espera_btn" href="#collapseSubpanel_cursos_lista_espera" onclick="ToggleSubpanel(this, 'collapseSubpanel_cursos_lista_espera')" role="button" aria-expanded="false" data-target=".collapseSubpanel_cursos_lista_espera" aria-controls="collapseSubpanel_cursos_lista_espera collapseSubpanel_cursos_lista_espera_pagination">
			Inscritos na Lista de Espera <i class="fas fa-chevron-down"></i> <img alt="Carregando..." class="loading-icon" src="{$app_url}images/loading.gif" />
		</h5>
		<!-- <script type="text/javascript">$('#collapseSubpanel_cursos_lista_espera_btn').click();</script> -->
	</div>
</div>


<div class="modal fade" id="detalhesVagasModal" tabindex="-1" role="dialog" aria-labelledby="detalhesVagasModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="detalhesVagasModalTitle">Detalhes de Vagas da Turma</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Ops! Você não deveria estar vendo esta frase...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal"><i class="far fa-times-circle"></i> Fechar</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">var record_id = '{$record.id}';</script>
<script type="text/javascript" src="{$app_url}js/Admin/Turmas/detalhes.js?v={$ch_ver}"></script>
{if $record.dias_curso}
<script type="text/javascript">
{foreach from=$record.dias_curso item=dia}
	addDiasCurso('{$dia}');
{/foreach}
</script>
{/if}