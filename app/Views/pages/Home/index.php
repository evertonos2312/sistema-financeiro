<article class="row-fluid">
    <h1>Cursos de Especialização</h1>
            
    <div class="row-fluid">
        <form method="post" id="form" class="form-especializacao">
            
            <div class="control-group span3">
                <div class="controls">
                    <p>Área</p>
                    <select name="area" id="area" class="span12">
                        {$categorias_options}
                    </select>
                </div>
            </div>

            <div class="control-group span3">
                <div class="controls">
                    <p>Mês</p>
                    <select name="mes" id="mes" class="span12">                        
                        {$meses_options}
                    </select>
                </div>
            </div>

            <div class="control-group span2">
                <div class="controls">
                    <p>Ano</p>
                    <select name="ano" id="ano" class="span12">{$anos_options}</select>
                </div>
            </div>

            <div class="control-group span2">
                <div class="controls">
                    <p>Palavra-chave</p>
                    <input type="text" name="termo" id="termo" class="span12" value="{$termo_value}">
                </div>
            </div>

            <div class="control-group span2">
                <div class="controls">
                <a class="btn btn-info span12" onclick="$('#form').submit()">Pesquisar</a>
                </div>
            </div>

        </form>
    </div>
    

    <div class="row marg">
    {if !empty($records)}
        {foreach from=$records item=campos}
        <div class="col-12 col-md-12 col-lg-4 especializacao">
            <a href="{$app_url}turmas/{$campos.cat_slug}/{$campos.subcat_slug}/{$campos.nome}" class="btn-especilizacao">
                <p class="{$campos.class_subcategoria}">{$campos.subcategoria_nome}</p>
                <img src="{$app_url}images/contabil.png" class="img-fluid">
                <div class="caption">
                    <h3 class="tituloh3">{$campos.curso_nome}</h3>
                    <div class="row-fluid span11">
                        <span class="span7"><i class="icon icon-calendar"></i>{$campos.inicio}<i class="icon icon-time"></i> </span>
                        <span class="text-right span5"></span>
                    </div>
                </div>
            </a>
        </div>
        {/foreach}
    {else}
        <span class="span7">Nenhum registro encontrado!</span>
    {/if}
    </div>
    {if $pagination && !empty($records)}
        <table class="table table-borderless table-pagination pagination pagination-centered pag_list active">
            <tbody>
                <tr>
                    <td>{$pagination}</td>
                </tr>
            </tbody>
        </table>
    {/if}


            
</article> 