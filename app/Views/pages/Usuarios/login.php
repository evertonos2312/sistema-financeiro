<div class="container-fluid body-login">
    <form class="form-login" method="post" action="{$app_url}usuarios/checkLogin">
        <div class="login-card card">
            <div class="card-header">
            <span class="font-weight-bold">Sistema Financeiro</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email"
                    class="form-control"
                    placeholder="Informe o e-mail" autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password"
                    class="form-control"
                    placeholder="Informe a senha">
                </div>
            </div>
                <div class="card-footer">
                    <button class="btn btn-lg btn-primary">Entrar</button>
                </div>
        </div>
    </form>
</div>