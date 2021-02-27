<div class="row">
    <div class="col-12">
        <h5>Lista de Espera para: <a href="{$app_url}admin/turmas/detalhes/{$turma.id}">[{$turma.nome}] {$turma.curso_nome}</a></h5>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <p>Vagas Clientes: <strong>{$vagas.cliente.vagas}</strong> | Vagas Clientes Disponível: <strong>{$vagas.cliente.disponivel}</strong> | Vagas Visitantes: <strong>{$vagas.nao_cliente.vagas}</strong> | Vagas Visitantes Disponível: <strong>{$vagas.nao_cliente.disponivel}</strong></p>
        <p>Vagas Clientes Lista: <strong>{$vagas.cliente.vagas_lista}</strong> | Vagas Clientes Disponível Lista: <strong>{$vagas.cliente.disponivel_lista}</strong> | Vagas Visitantes Lista: <strong>{$vagas.nao_cliente.vagas_lista}</strong> | Vagas Visitantes Disponível Lista: <strong>{$vagas.nao_cliente.disponivel_lista}</strong></p>
    </div> 
</div>
<div class="row">
    <div class="col-12">
        <hr />
    </div> 
</div>
{if $msg}
<div class="row">
    <div class="col-12">
        <h5 class="required"><strong>{$msg}</strong></h5>
        <hr />
    </div> 
</div>
{/if}
<form method="post" id="filtro_lista" name="filtro_lista" action="{$app_url}admin/turmas/lista_espera/{$turma.id}">
    <div class="row">
        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-3">
            <p>
                <label for="search_tipo">Tipo:</label>
                <select class="form-control" name="search_tipo" required="true">{$options_tipo}</select>
            </p>
        </div>
        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-3">
        <p>
            <label for="search_semana_sabado">Dias:</label>
            <select class="form-control" name="search_semana_sabado" required="true">{$options_semana_sabado}</select>
        </p>
        </div>
        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-3">
            <p>
                <label for="search_periodo">Período:</label>
                <select class="form-control" name="search_periodo" required="true">{$options_periodo}</select>
            </p>
        </div>
        <div class="col-12 col-lg-3 col-xl-2">
            <p>
                <label for="button">&nbsp;</label>
                <button name="button" type="button" class="form-control btn btn-success" onclick="ValidateForm('filtro_lista')">Buscar</button>
            </p>
        </div>
    </div>
</form>
{if isset($lista_espera)}
    <div class="row">
        <div class="col-12">
            <hr />
        </div> 
    </div>
    <h5>Registros encontrados: {count($lista_espera)} | Limitado a: {$limitado}</h5>
    <form id="enviar_emails_espera" method="post" name="enviar_emails_espera" action="{$app_url}admin/turmas/enviar_emails_espera">
        <input type="hidden" name="turma" value="{$turma.id}" />
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">&nbsp;</th>
                    <th scope="col">Participante</th>
                    <th scope="col">Email</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Cod. Cliente</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Local</th>
                    <th scope="col">Data Inscrição</th>
                </tr>
            </thead>
            <tbody>
            {if count($lista_espera) > 0}
                {foreach from=$lista_espera item=lista}
                    <tr>
                        <td><input type="checkbox" name="enviar_email[{$lista.id}]" value="{$lista.participante_email}" checked/></td>
                        <td>{$lista.participante_nome}</td>
                        <td>{$lista.participante_email}</td>
                        <td>{$lista.participante_cpf}</td>
                        <td>{$lista.participante_contmatic_id}</td>
                        <td>{$lista.participante_telefone}</td>
                        <td>{$lista.local_nome}</td>
                        <td>{$lista.data_criacao}</td>

                    </tr>
                {/foreach}
            {else}
            <tr>
                <td colspan="8">{if $vagas_esgotadas}Não existem vagas disponíveis para este Tipo de Cliente!{else}Nenhum registro foi encontrado!{/if}</td>
            </tr>
            {/if}
            </tbody>
        </table>
        <tfoot>
            <tr>
                <td colspan="8">
                {if count($lista_espera) > 0}
                    <button type="button" class="btn btn-success" onclick="ValidationInputs(this)"><i class="fas fa-envelope-open-text"></i> <img src="{$app_url}images/loading.gif" class="loading-icon" /> Enviar Emails de Convite</button>
                {/if}
                </td>
            </tr>
        </tfoot>
    </form>
    <script type="text/javascript" src="{$app_url}js/Admin/Turmas/lista_espera.js?v={$ch_ver}"></script>
{/if}