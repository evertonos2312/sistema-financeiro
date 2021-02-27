$('.modalInscricaoBtn').on('click', function(){
    validationsInscricao();
});


function fireError(args = {}){
    Swal.close();
    Swal.fire(args);
    $('#modalInscricao').modal('hide');
}

function fireLoading(msg = ''){
    fireError({
        title:'Aguarde...',
        text: msg,
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

function fireErrorGeneric(){
    fireError({
        title:'Ops! Algo deu errado!',
        html: '<p>Tente novamente mais tarde ou entre em contato com o admistrador.</p>',
        icon: 'error',
        allowOutsideClick: false,
    });
}

function validationsInscricao()
{
    Swal.fire({
        title: 'Aguarde...',
        text: 'Estamos realizando algumas verificações..',
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
            validateParticiparteTurma();
        },
    })
}

function validateParticiparteTurma()
{
    $.ajax({
        url: app_url+'participantes/getDetalhesInscricao',
        method: 'post',
        dataType: 'json',
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        data: JSON.stringify({
            participante: idPart,
            turma: dadosBaseTurma.id,
        }),
        success: function(data_part){
            document.data_part = data_part.detail;
            if(data_part.status !== 'success' || !data_part.detail){
                fireErrorGeneric();
                return;
            }

            if(!!data_part.detail.bloqueio_ate){
                fireError({
                    title:'Ops! Algo deu errado!',
                    html: '<p>Você foi bloqueado de se inscrever em nossas turmas!</p><p>Bloqueado até: '+formatDateTime(new Date(data_part.detail.bloqueio_ate))+'</p><p>Qualquer dúvida entre em contato através do telefone 4090-1770.</p>',
                    icon: 'warning',
                    allowOutsideClick: false,
                });
                return;
            }
            if(!!data_part.detail.already_inscrito){
                let msg = (data_part.detail.already_inscrito == 'espera') ? ' como lista de espera': '';
                fireError({
                    title:'Ops! Não é possível realizar a inscrição!',
                    html: '<p>Você já está inscrito na turma'+msg+'!</p>',
                    icon: 'info',
                    allowOutsideClick: false,
                });
                return;
            }
            validateVagas();
        },
        error: function(d){
            fireErrorGeneric();
        }
    });
}

function validateVagas()
{
    $.ajax({
        url: app_url+'ajax_requests/getVagasTurma',
        method: 'post',
        dataType: 'json',
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        data: JSON.stringify({
            id: dadosBaseTurma.id,
        }),
        success: function(d){
            if(d.status !== 'success' || !d.detail){
                fireErrorGeneric();
                return;
            }
            if(d.detail[tipoPart].disponivel < 1){
                if(d.detail[tipoPart].disponivel_lista < 1){
                    fireError({
                        title:'Ops! Vagas esgotadas!',
                        html: '<p>Infelizmente todas as vagas foram preenchidas, inclusive na lista de espera!</p><p>Deseja verificar se existe o mesmo curso em outras datas?</p>',
                        icon: 'info',
                        confirmButtonText: 'Sim',
                        cancelButtonText: 'Não, obrigado',
                        showCancelButton: true,
                        allowOutsideClick: false,
                        preConfirm: () => {
                            loadCursosProximos();
                        },
                    });
                }else{
                    //Tem vaga na lista de espera

                    //Verificar se e Cliente e pode se inscrever na lista de espera
                    if(tipoPart == 'cliente'){
                        if(document.data_part.connect.vagas_lista_preenchido >= document.data_part.connect.vagas_lista){
                            fireError({
                                title:'Ops! Vagas esgotadas!',
                                html: "<p>O seu contrato permite <strong>"+document.data_part.connect.vagas_lista+"</strong> inscrição (ões) por mês.</p><p>Todas as vagas foram preenchidas</p>",
                                icon: 'info',
                                confirmButtonText: 'Ok',
                                showCancelButton: false,
                            });
                            return;
                        }
                    }
                    fireError({
                        title:'Ops! Vagas esgotadas!',
                        html: '<p>Infelizmente todas as vagas foram preenchidas!</p><p>Deseja verificar se existe o mesmo curso em outras datas?</p>',
                        icon: 'info',
                        confirmButtonText: 'Sim',
                        cancelButtonText: 'Não, obrigado',
                        showCancelButton: true,
                        showDenyButton: true,
                        denyButtonText: 'Inscrever-me na Lista de Espera',
                        allowOutsideClick: false,
                        preConfirm: () => {
                            loadCursosProximos();
                        },
                        preDeny: () => {
                            modalListaEspera();
                        }
                    });
                }
                return;
            }
            //Tem vaga disponível
            if(tipoPart == 'nao_cliente'){
                if(dadosBaseTurma.valor_nao_cliente > 0 && document.data_part.tem_connectcont){
                    Swal.close();
                    $('#modalInscricao').modal('hide');
                    Swal.fire({
                        title:'Cliente Contmatic',
                        html: '<p>Deseja continuar na área de Visitantes?</p>',
                        icon: 'question',
                        confirmButtonText: 'Sim',
                        cancelButtonText: 'Não',
                        showCancelButton: true,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if(!result.isConfirmed){
                            location.href = app_url+'login/logout?rdct_url='+encodeURIComponent(document.URL);
                        }else{
                            modalDescontoNaoCliente();
                        }
                    });
                    return;
                }
                location.href = app_url+'turmas/subscribe/'+dadosBaseTurma.id;
            }else{
                if(document.data_part.connect.vagas_preenchido >= document.data_part.connect.vagas){
                    fireError({
                        title:'Ops! Vagas esgotadas!',
                        html: "<p>O seu contrato permite <strong>"+document.data_part.connect.vagas+"</strong> inscrição (ões) na lsita de espera por mês.</p><p>Todas as vagas foram preenchidas</p>",
                        icon: 'info',
                        confirmButtonText: 'Ok',
                        showCancelButton: false,
                    });
                    return;
                }else if(dadosBaseTurma.valor_cliente > 0){
                    modalDescontoCliente();
                }else{
                    location.href = app_url+'turmas/subscribe/'+dadosBaseTurma.id;
                }
            }
        },
        error: function(d){
            fireErrorGeneric();
        }
    });
}

function loadCursosProximos()
{
    fireLoading('Estamos buscando o curso em outras datas....');
    $.ajax({
        url: app_url+'cursos/getTurmasAtivo',
        method: 'post',
        dataType: 'json',
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        data: JSON.stringify({
            id: dadosBaseTurma.curso,
            turma_diff: dadosBaseTurma.id,
        }),
        success: function(d){
            if(d.status == 'success'){
                if(d.detail.length > 0){
                    modalCursosProximos(d.detail);
                }else{
                    Swal.close();
                    Swal.fire({
                        title:'Ops! Não consegui achar outras turmas!',
                        html: '<p>Infelizmente não existem turmas cadastradas para este curso em outras datas.</p><p>Deseja se inscrever na lista de espera?',
                        icon: 'info',
                        confirmButtonText: 'Sim',
                        cancelButtonText: 'Não, obrigado',
                        showCancelButton: true,
                        preConfirm: () => {
                            modalListaEspera();
                        },
                    });
                }
            }
        },
        error: function(d){
            fireErrorGeneric();
        }
    });
}

function modalCursosProximos(cursos)
{
    Swal.close();
    $('#modalInscricao').modal('show');

    var html_body = `
            <input type="hidden" name="turma" value="${dadosBaseTurma.id}" />
            <div class="row">
                <div class="col-12">
                    <h4 class="text-center">Próximas Turmas para o curso:</h4>
                    <h5>${cursos[0].curso_nome}</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <hr />
                </div>
            </div>`;
        
        cursos.forEach(function(curso, idx){
            html_body += `
            <div class="row">
                <div class="col-12">
                    <p>Data: ${curso.inicio} | <a class="btn btn-info" href="${curso.link_uri}">Mais Detalhes</a></p>
                </div>
            </div>`;
        });
        
        
        html_body += `</div>`;
    $('#modalInscricao').find('.modal-body').html(html_body);
}

function modalListaEspera()
{
    Swal.close();
    $('#modalInscricao').modal('show');

    var html_body = `
        <form id="subscribe_lista" method="post" action="${app_url}cursos_lista_espera/subscribe">
            <input type="hidden" name="turma" value="${dadosBaseTurma.id}" />
            <div class="row mb-5">
                <div class="col-12">
                    <h4 class="text-center">Cadastro na Lista de Espera</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p>Durante a semana: <input name="semana" type="checkbox" value="1" id="semana" style="vertical-align: middle;margin-right: 1rem">
                    Período: <select name="periodo_semana" class="form-control display-inline">
                        <option value="5">Indiferente</option>
                        <option value="1">Manhã</option>
                        <option value="2">Tarde</option>
                        <option value="3">Noite</option>
                        <option value="4">Integral</option>
                    </select></p>
                    <p>Aos sábados: <input name="sabado" type="checkbox" value="1" style="vertical-align: middle;margin-right: 1rem">
                    Período: <select name="periodo_sabado" class="form-control display-inline">
                        <option value="5">Indiferente</option>
                        <option value="1">Manhã</option>
                        <option value="2">Tarde</option>
                        <option value="3">Noite</option>
                        <option value="4">Integral</option>
                    </select></p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p><button type="button" class="btn btn-info" onclick="if(ValidateSubscribeLista()){ValidateForm('subscribe_lista', this)}"><img src="${app_url}images/loading.gif" class="loading-icon" /> Inscrever</button>
                </div>
            </div>
        </form>
    `;
    $('#modalInscricao').find('.modal-body').html(html_body);
}

function ValidateSubscribeLista()
{
    rmvValidateError();
    var semana = $('input[name="semana"]').is(':checked');
    var sabado = $('input[name="semana"]').is(':checked');
    if(!semana && !sabado){
        $('input[name="semana"]').parent().parent().append('<p class="validate-error required">Você deve selecionar se deseja durante a semana/sábados (ou ambos).</p>');
        return false;
    }

    return true;
}

function modalDescontoNaoCliente()
{
    Swal.close();
    $('#modalInscricao').modal('show');

    var html_body = `
        <form id="subscribe_turma" method="post" action="${app_url}turmas/subscribe/${dadosBaseTurma.id}">
            <div class="row mb-5">
                <div class="col-12">
                    <h4 class="text-center">Opções de desconto Visitantes</h4>
                </div>
            </div>
            <div class="row text-left">
                <div class="col-12">
                    <label class="radio">
                        <input type="radio" name="desconto" value="10" >
                        <b>10% de desconto (Acima de 2 inscrições)</b>
                    </label><br />
                    <label class="radio">
                        <input type="radio" name="desconto" value="30" >
                        <b>30% de desconto (Estudantes de cursos técnicos e universitários)</b>
                    </label><br />
                    <label class="radio">
                        <input type="radio" name="desconto" value="60">
                        <b>60% Estudantes de instituições de ensino conveniadas</b>
                    </label><br />
                    <label class="radio">
                        <input type="radio" name="desconto" value="0">
                        <b>Nenhuma das opções de desconto</b>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p><button type="button" class="btn btn-info" onclick="if(ValidateSubscribeTurma()){ValidateForm('subscribe_turma', this)}"><img src="${app_url}images/loading.gif" class="loading-icon" /> Inscrever</button>
                </div>
            </div>
        </form>
    `;
    $('#modalInscricao').find('.modal-body').html(html_body);
}

function modalDescontoCliente()
{
    Swal.close();
    $('#modalInscricao').modal('show');

    var html_body = `
        <form id="subscribe_turma" method="post" action="${app_url}turmas/subscribe/${dadosBaseTurma.id}">
            <div class="row mb-5">
                <div class="col-12">
                    <h4 class="text-center">Opções de desconto Cliente Contmatic</h4>
                </div>
            </div>
            <div class="row text-left">
                <div class="col-12">
                    <label class="radio">
                        <input type="radio" name="desconto" value="40" >
                        <b>40% Cliente Contmatic</b>
                    </label><br />
                    <label class="radio">
                        <input type="radio" name="desconto" value="60">
                        <b>60% Estudantes de instituições de ensino conveniadas</b>
                    </label><br />
                    <label class="radio">
                        <input type="radio" name="desconto" value="0">
                        <b>Nenhuma das opções de desconto</b>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p><button type="button" class="btn btn-info" onclick="if(ValidateSubscribeTurma()){ValidateForm('subscribe_turma', this)}"><img src="${app_url}images/loading.gif" class="loading-icon" /> Inscrever</button>
                </div>
            </div>
        </form>
    `;
    $('#modalInscricao').find('.modal-body').html(html_body);
}
function ValidateSubscribeTurma()
{
    rmvValidateError();
    if(!$('input[name="desconto"]:checked').val()){
        $('#subscribe_turma').find('label:first').parent().append('<p class="validate-error required">Você deve selecionar uma das opções de desconto.</p>');
        return false;
    }
    return true;
}