<div class="login-page" style="margin-top: 40px;">
    <div class="login-container">
    <div class="login-header">
        <h1>Bem-vindo</h1>
        <p>Faça seu login</p>
    </div>

    <div class="login-body">

        <form method="post" name="formCadastrar" action="carrinho/logar" data-parsley-validate>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required data-parsley-required-message="Por favor, insira seu email." data-parsley-type-message="Digite um e-mail válido">
            </div>
            <label for="password" class="form-label">Senha</label>
            <div class="input-group mb-3">
    <input type="password" class="form-control" id="cli_senha" name="senha" placeholder="Digite sua senha" 
           required 
           data-parsley-required-message="Por favor, insira sua senha."
           data-parsley-minlength="6"
           data-parsley-minlength-message="A senha deve ter no mínimo 6 caracteres."
           data-parsley-errors-container="#erro-container-senha"> <button class="btn btn-outline-secondary" type="button" onclick="mostrarSenha()"><i class="fas fa-eye"></i></button>
</div>

<div id="erro-container-senha"></div>
            <br>
            <button type="submit" class="btn btn-login">Entrar</button>
            <div class="text-center mt-3">
                <a href="carrinho/cadastro" class="link-secondary text-decoration-none">Não tenho cadastro</a>
            </div>
        </form>
    </div>
    </div>
</div>


<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/jquery.inputmask.min.js"></script>
<script src="js/parsley.min.js"></script>
<script>
     function mostrarSenha() {
            const campoSenha = document.getElementById("cli_senha"); 
            if (campoSenha.type === "password") {
                campoSenha.type = "text";
            } else {
                campoSenha.type = "password";
            }
        }
</script>