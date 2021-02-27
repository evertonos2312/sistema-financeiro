{if $save_data_errors.generic_error}
<div class="row">
	<div class="col-12">
		<p class="required">{$save_data_errors.generic_error}</p>
	</div>
</div>
{/if}
<form id="EditarForm" method="post" action="{$app_url}admin/turmas/salvar">
	<input type="hidden" name="id" value="{$record.id}" />
	<input type="hidden" name="deletado" value="{$record.deletado}" />
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
			<p>
				<label for="imagem">Imagem</label>
				<select name="imagem" class="form-control" required="true"></select>
			</p>
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
						<th class="col-5 col-md-3 col-lg-2">Início</th>
						<th class="col-2 col-md-9 col-lg-10">&nbsp;</th>
					</tr>
				</thead>
				<tbody id="dias_curso_tbody">
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"><button class="btn btn-info" type="button" onclick="addDiasByPeriod()">Adicionar dias conforme Início e Término</button></td>
					</tr>
				</tfoot>
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
	</div>
	<div class="row">
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
		<div class="col-12">
			<button type="button" class="btn btn-success margin-5" onclick="ValidateForm('EditarForm')"><i class="fas fa-save"></i> Salvar</button>
			<a href="{$app_url}admin/turmas/index" class="btn btn-warning margin-5"><i class="fas fa-undo"></i> Cancelar</a>
			{if $record.id}
				<button type="button" class="btn btn-danger margin-5" onclick="ConfirmDeleteRecord('EditarForm')"><i class="fas fa-trash"></i> Deletar</button>
			{/if}
		</div>
	</div>
</form>
<script type="text/javascript">var savedImagem = '{$record.imagem}';</script>
<script type="text/javascript" src="{$app_url}js/Admin/Turmas/editar.js?v={$ch_ver}"></script>
{if $record.dias_curso}
<script type="text/javascript">
{foreach from=$record.dias_curso item=dia}
	{if $dia != ''}
	addDiasCurso('{$dia}');
	{/if}
{/foreach}
</script>
{/if}
{if $record.id_mp}
<script type="text/javascript">
blockMPFields();
</script>
{/if}