<div class="login-page" style="margin-top: 100px;">
    <div class="login-container">
    <div class="login-header">
        <h1>Bem-vindo</h1>
        <p>Cadastre-se</p>
    </div>

    <div class="login-body">

        <form method="post" name="formLogin" id="formCadastro" action="carrinho/cadastrar" data-parsley-validate>
            
            <div class="mb-3">
                <label for="cli_nome">Seu Nome:</label>
                <input type="text" name="nome" id="cli_nome" class="form-control" 
                       required 
                       data-parsley-required-message="Preencha seu nome"
                       data-parsley-minlength="3"
                       data-parsley-minlength-message="O nome deve ter no mínimo 3 caracteres.">
            </div>

            <div class="mb-3">
                <label for="cli_email" class="form-label">E-mail:</label>
                <input type="email" class="form-control" id="cli_email" name="email" placeholder="Digite seu email" 
                       required 
                       data-parsley-required-message="Por favor, insira seu email." 
                       data-parsley-type-message="Digite um e-mail válido">
            </div>

            <div class="mb-3">
                <label for="cli_telefone" class="form-label">Telefone:</label>
                <input type="text" name="telefone" id="cli_telefone" class="form-control" 
                       required 
                       data-parsley-required-message="Digite um telefone"
                       data-parsley-mask-complete data-parsley-mask-complete-message="O telefone está incompleto. Preencha todos os dígitos."> 
            </div>

            <div class="input-group mb-3">
    <input type="password" class="form-control" id="cli_senha" name="senha" placeholder="Digite sua senha" 
           required 
           data-parsley-required-message="Por favor, insira sua senha."
           data-parsley-minlength="6"
           data-parsley-minlength-message="A senha deve ter no mínimo 6 caracteres."
           data-parsley-errors-container="#erro-container-senha"> <button class="btn btn-outline-secondary" type="button" onclick="mostrarSenha()"><i class="fas fa-eye"></i></button>
</div>

<div id="erro-container-senha"></div>

            <div class="mb-3">
                <label for="cli_senhaRedigitada">Redigite sua senha:</label>
                <input type="password" name="senhaRedigitada" id="cli_senhaRedigitada" class="form-control" 
                       required 
                       data-parsley-required-message="Por favor, redigite sua senha." 
                       data-parsley-equalto="#cli_senha" 
                       data-parsley-equalto-message="As senhas estão diferentes">
            </div>
            <br>
            <button type="submit" class="btn btn-login">Efetuar cadastro</button>
        </form>
    </div>
    </div>
</div>

<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/jquery.inputmask.min.js"></script>
<script src="js/parsley.min.js"></script>

<script>
// Este código "ensina" o Parsley a entender o que é 'data-parsley-mask-complete'
window.Parsley.addValidator('maskComplete', {
    validateString: function(value, requirement, parsleyInstance) {
        var elem = parsleyInstance.$element[0]; // Pega o campo (input)
        
        // Pergunta para a biblioteca InputMask se o campo está completo
        if (typeof $(elem).inputmask === 'function') {
            return $(elem).inputmask('isComplete');
        }
        return false; // Segurança, caso o inputmask não carregue
    }
});
</script>

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
<script>
    $(document).ready(function(){
        $('#formCadastro').parsley();
        
        $('#cli_telefone').inputmask(["(99) 9999-9999", "(99) 99999-9999"]);
    });
</script>