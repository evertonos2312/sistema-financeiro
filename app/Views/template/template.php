<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <!-- Meta tags Obrigatórias -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{$app_url}css/bootstrap.min.css?v={$ch_ver}">
		<link rel="stylesheet" href="{$app_url}css/fontawesome-all.min.css?v={$ch_ver}">
		<link rel="stylesheet" href="{$app_url}css/sweetalert2.min.css?v={$ch_ver}">
		<link rel="stylesheet" href="{$app_url}css/jquery-ui.structure.min.css?v={$ch_ver}">
		<link rel="stylesheet" href="{$app_url}css/jquery-ui.theme.min.css?v={$ch_ver}">
		<link rel="stylesheet" href="{$app_url}css/bootstrap-datetimepicker.css?v={$ch_ver}">
        <link rel="stylesheet" href="{$app_url}css/default_web.css?v={$ch_ver}">
        <link rel="stylesheet" href="{$app_url}css/style.css?v={$ch_ver}">
        <link rel="stylesheet" href="{$app_url}css/bulma.min.css?v={$ch_ver}" />
        <!-- Icones -->
        <script src="{$app_url}js/fontawesome.min.js?v={$ch_ver}"></script>
		<script language="javascript" type="text/javascript" src="{$app_url}js/jquery-3.5.1.min.js?v={$ch_ver}"></script>
		<script language="javascript" type="text/javascript" src="{$app_url}js/jquery-ui-1.12.1.min.js?v={$ch_ver}"></script>
		<script language="javascript" type="text/javascript" src="{$app_url}js/datepicker-pt-BR.js?v={$ch_ver}"></script>
		<script language="javascript" type="text/javascript" src="{$app_url}js/bootstrap.min.js?v={$ch_ver}"></script>
		<script language="javascript" type="text/javascript" src="{$app_url}js/sweetalert2.all.min.js?v={$ch_ver}"></script>
		<script language="javascript" type="text/javascript" src="{$app_url}js/popper.min.js?v={$ch_ver}"></script>
		<script language="javascript" type="text/javascript" src="{$app_url}js/moment-with-locales.js?v={$ch_ver}"></script>
		<script language="javascript" type="text/javascript" src="{$app_url}js/bootstrap-datetimepicker.js?v={$ch_ver}"></script>
		<script type="text/javascript" src="{$app_url}js/utils.js?v={$ch_ver}"></script>
		<script type="text/javascript" src="{$app_url}js/app.js?v={$ch_ver}"></script>
		<script type="text/javascript">
			var app_url = '{$app_url}';
		</script>
        <!--Favicon-->
        <link rel="shortcut icon" id="favicon" href="images/favicon.png" type="images/icon">
        <title>{$title}</title>
      </head>
      <header>
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="{$app_url}home">
                    Logo
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Alterna navegação">
                  <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                  <div class="navbar-nav">
                    <a class="nav-item nav-link" href="{$app_url}especializacao/listar">Teste</a>
                    <a class="nav-item nav-link" href="{$app_url}treinamentos/listar">Teste</a>
                    <a class="nav-item nav-link" href="{$app_url}videoaulas/sobre">Teste</a>
                    <a class="nav-item nav-link" href="#">Teste</a>
                    <a class="nav-item nav-link" href="{$app_url}academicos/cadastrar">Teste</a>
					{if $auth_user.id}
                    <li class="nav-item dropdown login">
                        <a class="nav-link dropdown-toggle login" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{$auth_user.nome}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                          <a class="dropdown-item" href="{$app_url}participantes/certificadosNotas">Certificados e notas</a>
                          <a class="dropdown-item" href="#">Meus treinamentos</a>
                          <a class="dropdown-item senha" href="{$app_url}participantes/alterarSenha{if $auth_connectcont}Connect{/if}">Alterar senha</a>
                          <a class="dropdown-item" href="{$app_url}participantes/meusDados">Meus Dados</a>
                          <a class="dropdown-item senha" href="{$app_url}login/logout">Sair</a>
                        </div>
                    </li>
					<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle circulo" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{$app_url}images/menu-more.png" alt="menu more" class="img-fluid">
                        </a>
                        <div class="dropdown-menu menu-circle" aria-labelledby="navbarDropdownMenuLink">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <a target="_blank" href="https://contmatic.com.br/">
                                        <i class="fab fa-phoenix-squadron"></i>
                                    <p>Site da Contmatic</p></a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a target="_blank" href="https://cliente.contmatic.com.br/dashboard">
                                        <i class="fas fa-users"></i>
                                    <p>Área do Cliente</p></a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a target="_blank" href="https://cliente.contmatic.com.br/atendimento/suporteonline">
                                    <i class="fas fa-comments"></i>
                                    <p>Suporte Online</p></a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a href="https://cursos.contmatic.com.br/">
                                        <i class="fas fa-graduation-cap"></i>
                                    <p>Cursos e Treinamentos</p></a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a target="_blank" href="https://legalmatic.contmatic.com.br/">
                                        <i class="fas fa-gavel"></i>
                                        <p>Legalmatic</p></a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a target="_blank" href="http://autoatendimento.contmatic.com.br/">
                                        <i class="fas fa-comment-dots"></i>
                                        <p>Autoatendimento</p></a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a target="_blank" href="https://web.contmatic.com.br/">
                                        <i class="fas fa-cloud"></i>
                                    <p>Contmatic Nuvem</p></a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a target="_blank" href="https://www.youtube.com/user/contmaticphoenix">
                                        <i class="fab fa-youtube"></i>
                                        <p>Youtube</p></a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a target="_blank" href="https://blog.contmatic.com.br/">
                                        <i class="fas fa-edit"></i>
                                    <p>Blog</p></a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a target="_blank" href="http://portaldeempregos.contmatic.com.br/">
                                        <i class="fas fa-briefcase"></i>
                                    <p>Portal de Empregos</p></a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a target="_blank" href="https://contadoronline.contmatic.com.br/"><img class="img-fluid" src="{$app_url}images/CONTADOR_ONLINE.png">
                                    <p>Contador Online</p></a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a target="_blank" href="http://www.cndphoenix.com.br/cndwebcloud/"><img class="img-fluid" src="{$app_url}images/CND_PHOENIX.png">
                                    <p>CND Phoenix</p></a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a target="_blank" href="https://www.contmatictransportes.com.br/"><img class="img-fluid" src="{$app_url}images/CONTMATIC_TRANSPORTES.png">
                                    <p>Contmatic Transportes</p></a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a target="_blank" href="http://gestaoempresarial.contmatic.com.br/"><img class="img-fluid" src="{$app_url}images/GESTAO_EMPRESARIAL.png">
                                    <p>Gestão Empresarial</p></a>
                                </div>
                            </div>
                        </li>
                        {else}
                        <li class="nav-item dropdown login">
                            <a class="nav-link login" href="{$app_url}login" id="navbarDropdownMenuLink">
                                Login
                            </a>
                        </li>
                        {/if}
                    </div>
                    </div>
                </nav>
            </div>
        </header>

    <body>
        <section class="container-fluid">
            {$content}
        </section>

        <!--Footer-->
    </div>
    <footer>
        <div class="container-fluid">
            <div class="align-footer">
            <div name="banner-lgpd" class="banner-lgpd banner-lgpd__container">
                <div class="banner-lgpd__column">
                    <p>
                    Ao continuar em nossa aplicação, você concorda com a utilização de cookies
                </p>
                </div>
                <div class="banner-lgpd__column">
                    <button onclick="acceptCookies()"class="banner-lgpd__accept">OK</button>
                </div>
            </div>


        </div>
    </footer>
  </body>
</html>
<script>
    if(localStorage.cookies){
        acceptCookies();
}
</script>