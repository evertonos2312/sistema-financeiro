<section class="container-fluid especializacao-interna">
        <div class="row">
            <div class="col-12">
                <h1>Treinamentos</h1>
            </div>
            {if $msg}
            <div class="col-12">
                <div class="mt-3 text-center {$msg_type}">
                    <h5>{$msg}</h5>
                </div>
            </div>
            {/if}
            <div class="col-9 col-md-4 marg-bottom">
                <img src="{$app_url}images/cp-logo.png" class="img-fluid">
            </div>
            <div class="col-12">

            </div>
            
            <div class="col-12 col-md-6">
                <h2>Tema:</h2>
                <p>{$detalhes.curso_nome}</p>
                <br>
                <h2>Carga horária:</h2>
                <p>{$detalhes.carga_horaria|replace:":":"h"}</p>
                <br>
                <h2>Início:</h2>
                <p>{$detalhes.inicio|date_format:"%d/%m/%Y"} - <b>{$detalhes.inicio|date_format:"%Hh%M"}</b></p>
                <br><br>
                
                <!-- Button trigger modal -->
                {if $auth_part.id}
                <button type="button" class="btn btn-info modalInscricaoBtn">
                    Inscrever-se
                </button>
                {else}
                <button type="button" class="btn btn-info" onclick="rdct_login()">
                    Faça o login para se inscrever
                </button>
                {/if}
                
                <!-- Modal -->
                <div class="modal fade" id="modalInscricao" tabindex="-1" role="dialog" aria-labelledby="modalInscricaoTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body"></div>
                        </div>
                    </div>
                </div>      
                <br><br><br><br>
            </div>
            {if $detalhes.aviso}
            <div class="col-12">
                <div class="alert alert-error mt-3">
                    <h4>{$detalhes.aviso}</h4>
                </div>
            </div>
            <div class="clearfix"></div>
            {/if}
            
            {if $detalhes.pre_requisitos}
            <div class="col-12 col-md-6 marg">
                <h2>Pré-requisitos:</h2>
                <p>{$detalhes.pre_requisitos}</p>
            </div>
            {/if}
            {if $detalhes.objetivo}
            <div class="col-12 col-md-6 marg">
                <h2>Objetivos:</h2>
                <p>{$detalhes.objetivo}</p>
            </div>
            {/if}
            
        </div> 
    </section>
    <section class="">
        <div class="container-fluid">
            <div class="row bg-instrutor">
                <div class="col-12 col-md-3">
                {if $detalhes.instrutor_foto}
                    <img alt="{$detalhes.instrutor_nome}"src="{$app_url}/downloadManager/preview/{$detalhes.instrutor_foto}" class="img-fluid" style="max-width: 271px">
                {else}
                    <img alt="Sem Foto" src="{$app_url}/images/sem_foto.jpg" class="img-fluid" style="max-width: 271px">
                {/if}
                </div>
                <div class="col-12 col-md-9">
                    <h2>Instrutor</h2>
                    <h3>{$detalhes.instrutor_nome}</h3>
                    <p>{$detalhes.instrutor_formacao}</p>
                </div>
            </div>
        </div>
    <section class="container-fluid especializacao-interna">
        <div class="row">
            <div class="col-12">
                <h2>Resumo:</h2>
                <p class="texto3">{$detalhes.descricao|nl2br|replace:"&#13;&#10;":"<br/>"}</p>
            </div>
        </div>
    </section>
    {if $aulas}
    <section class="accordion-interna marg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div id="accordion">
                        {foreach from=$aulas item=$aula key=keyaula}
                        <div class="card">
                          <div class="card-header" id="headingOne{$aula.ordem}">
                            <h5 class="mb-0">
                              <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne{$aula.ordem}" aria-expanded="true" aria-controls="collapseOne{$aula.ordem}">
                              {$aula.ordem} <br> <span>{$aula.nome} <i class="fas fa-chevron-down"></i></span>
                              </button>
                            </h5>
                          </div>
                          <div id="collapse{$aula.ordem}" class="collapse {if $keyaula == 0}show{/if}" aria-labelledby="heading{$aula.ordem}" data-parent="#accordion">
                            <div class="card-body">{$aula.descricao}</div>
                          </div>
                          </div>
                        </div>
                        {/foreach}
                      </div>
                </div>
            </div>
        </div>
    </section>
    {/if}

    <section class="cta-especializacoes marg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <img src="{$app_url}images/cta-2.png" class="img-fluid cta">
                </div>
                <div class="col-1">
                    <img src="{$app_url}images/linha.png" class="img-fluid">
                </div>
                <div class="col-12 col-md-4">
                    <h2>Os melhores profissionais usam sempre grandes sistemas</h2>
                    <p>Com os treinamentos de sistemas da Contmatic Phoenix, você desenvolve novas habilidades e evolui como profissional.</p>
                </div>
            </div>
        </div>
    {* SECTION CLOSE IS ON template.php *}

<script type="text/javascript">
var idPart = '{$auth_part.id}';
var tipoPart = '{$auth_part.tipo}';
var dadosBaseTurma = {
    'id': '{$detalhes.id}',
    'nome': '{$detalhes.nome}',
    'curso': '{$detalhes.curso}',
    'valor_cliente': {$detalhes.valor_cliente},
    'valor_nao_cliente': {$detalhes.valor_nao_cliente},
};
</script>
<script type="text/javascript" src="{$app_url}js/Turmas/detalhes.js?v={$ch_ver}"></script>