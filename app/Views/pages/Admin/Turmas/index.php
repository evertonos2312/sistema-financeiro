{$filter_template}
<div class="row">
	<div class="col-12 mb-3">
		<button type="button" onclick="showLoadingIcon(this);location.href='{$app_url}admin/turmas/sync_turmas_mp'" class="btn btn-success"><i class="fas fa-sync"></i> <img alt="Carregando..." class="loading-icon" src="{$app_url}images/loading.gif" /> Sincronizar Turmas MP</button>
	</div>
</div>
{if $save_data_errors.generic_error}
<div class="row">
    <div class="col-12">
        <p class="required">{$save_data_errors.generic_error}</p>
    </div>
</div>
{/if}
<table class="table table-striped table-list">
	<thead>
		<tr>
			<th scope="col" class="pointer" data-head-field="nome" onclick="OrderByFiltro('nome')">Código <span class="icon-order-by"></span></th>
			<th scope="col" class="pointer" data-head-field="curso" onclick="OrderByFiltro('curso')">Curso <span class="icon-order-by"></span></th>
			<th scope="col" class="pointer d-none d-md-table-cell" data-head-field="inicio" onclick="OrderByFiltro('inicio')">Data Início <span class="icon-order-by"></span></th>
			<th scope="col" class="pointer d-none d-lg-table-cell" data-head-field="termino" onclick="OrderByFiltro('termino')">Data Término <span class="icon-order-by"></span></th>
			<th scope="col" class="pointer d-none d-xl-table-cell" data-head-field="data_modificacao" onclick="OrderByFiltro('data_modificacao')">Data Modificação <span class="icon-order-by"></span></th>
		</tr>
	</thead>
	<tbody>
	{if !empty($records)}
		{foreach from=$records item=campos}
			<tr class="pointer row-data-select" data-row-id="{$campos.id}" onclick="location.href='{$app_url}admin/turmas/detalhes/{$campos.id}'">
				<td data-row-nome="{$campos.nome}">{$campos.nome}</td>
				<td data-row-curso_nome="{$campos.curso_nome}">{$campos.curso_nome}</td>
				<td class="d-none d-md-table-cell" data-row-inicio="{$campos.inicio}">{$campos.inicio}</td>
				<td class="d-none d-lg-table-cell" data-row-termino="{$campos.termino}">{$campos.termino}</td>
				<td class="d-none d-xl-table-cell" data-row-data_modificacao="{$campos.data_modificacao}">{$campos.data_modificacao}</td>
			</tr>			
		{/foreach}
		
	{else}
	<tr>
		<td colspan="5">Nenhum registro encontrado!</td>
	</tr>	
	{/if}
	</tbody>
</table>
{if $pagination}
<table class="table table-striped table-list table-pagination">
	<tbody>
		<tr>
			<td>
				Ir para: <input size="5" type="text" class="QuickGoToPage" inputmode="numeric" pattern="[0-9]*" /> <button type="button" class="btn btn-info" onclick="QuickGoToPage(this)">Ir</button>
			</td>
		</tr>
		<tr>
			<td>{$pagination}</td>
		</tr>
	</tbody>
</table>
{/if}
<script type="text/javascript" src="{$app_url}js/Musicas_fila/index.js?v={$ch_ver}"></script>