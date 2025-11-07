<div class="login-page" style="margin-top: 100px;">
    <div class="login-container">
    <div class="login-header">
        <h1>Bem-vindo</h1>
        <p>Cadastre-se</p>
    </div>

    <div class="login-body">

        <form method="post" name="formLogin" action="carrinho/cadastrar" data-parsley-validate>
            <div class="mb-3">
                <label for="cli_nome">Seu Nome:</label>
                <input type="text" name="nome" id="cli_nome" class="form-control" required data-parsley-required-message="Preencha seu nome">
            </div>
            <div class="mb-3">
                <label for="cli_email" class="form-label">E-mail:</label>
                <input type="email" class="form-control" id="cli_email" name="email" placeholder="Digite seu email" required data-parsley-required-message="Por favor, insira seu email." data-parsley-type-message="Digite um e-mail válido">
            </div>
            <div class="mb-3">
                <label for="cli-telefone" class="form-label">Telefone:</label>
                <input type="text" name="telefone" id="cli_telefone" class="form-control" 
                        required data-parsley-required-message="Digite um telefone">
            </div>
            <label for="cli_password" class="form-label">Senha:</label>
            <div class="input-group mb-3">
                <input type="password" class="form-control" id="cli_senha" name="senha" placeholder="Digite sua senha" required data-parsley-required-message="Por favor, insira sua senha." data-parsley-errors-container="#erro">
                <button class="btn btn-outline-secondary" type="button" onclick="mostrarSenha()"><i class="fas fa-eye"></i></button>
            </div>
            <div class="mb-3">
                <label for="senhaRedigitada">Redigite sua senha:</label>
                <input type="password" name="senhaRedigitada" id="cli_senhaRedigitada" class="form-control" required data-parsley-required-message="Por favor, redigite sua senha." data-parsley-equalto="#cli_senha" data-parsley-equalto-message="As senhas estão diferentes">
            </div>
            <br>
            <button type="submit" class="btn btn-login">Efetuar cadastro</button>
        </form>
    </div>
    </div>
</div>
<script src="../../public/js/parsley.min.js"></script>
<script>
     mostrarSenha = () => {
            const campoSenha = document.getElementById("senha");
            if (campoSenha.type === "password") {
                campoSenha.type = "text";
            } else {
                campoSenha.type = "password";
            }
        }
</script>
<script>
    $(document).ready(function(){
        $('#cli_telefone').inputmask("(99) 99999-9999");
    });
</script>