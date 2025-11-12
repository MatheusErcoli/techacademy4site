<div class="login-page" style="margin-top: 120px;">
    <div class="cadastro-container">
        <div class="login-header">
            <h1>Bem-vindo</h1>
            <p>Cadastre-se no nosso site!</p>
        </div>

        <div class="login-body">

            <form method="post" name="formLogin" id="formCadastro" action="carrinho/cadastrar" data-parsley-validate>
                <div class="row">
                    <div class="mb-3 col-12 col-md-6">
                        <label for="cli_nome" class="form-label">Seu Nome:</label>
                        <input type="text" name="nome" id="cli_nome" class="form-control"
                            required
                            placeholder="Digite seu nome"
                            data-parsley-required-message="Insira seu nome"
                            data-parsley-minlength="3"
                            data-parsley-minlength-message="O nome deve ter no mínimo 3 caracteres.">
                    </div>

                    <div class="mb-3 col-12 col-md-6">
                        <label for="cli_email" class="form-label">E-mail:</label>
                        <input type="email" class="form-control" id="cli_email" name="email" placeholder="Digite seu email"
                            required
                            data-parsley-required-message="insira seu email."
                            data-parsley-type-message="Digite um e-mail válido">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="mb-3 col-12 col-md-4">
                        <label for="cli_telefone" class="form-label">Telefone:</label>
                        <input type="text" name="telefone" id="cli_telefone" class="form-control"
                            required
                            placeholder="digite seu telefone"
                            data-parsley-required-message="Digite um telefone"
                            data-parsley-mask-complete data-parsley-mask-complete-message="O telefone está incompleto. Preencha todos os dígitos.">
                    </div>

                    <div class="mb-3 col-12 col-md-4">
                        <label for="cli_senha" class="form-label">Senha:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="cli_senha" name="senha" placeholder="Digite sua senha"
                                required
                                data-parsley-required-message="insira sua senha."
                                data-parsley-minlength="6"
                                data-parsley-minlength-message="A senha deve ter no mínimo 6 caracteres."
                                data-parsley-errors-container="#erro-container-senha">
                            <button class="btn btn-outline-secondary" type="button" onclick="mostrarSenha()">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="erro-container-senha"></div>
                    </div>

                    <div class="mb-3 col-12 col-md-4">
                        <label for="cli_senhaRedigitada" class="form-label">Redigite sua senha:</label>
                        <input type="password" name="senhaRedigitada" id="cli_senhaRedigitada" class="form-control"
                            required
                            placeholder="Redigite sua senha"
                            data-parsley-required-message="redigite sua senha."
                            data-parsley-equalto="#cli_senha"
                            data-parsley-equalto-message="As senhas estão diferentes">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="mb-3 col-12 col-md-4">
                        <label for="cep" class="form-label">CEP:</label>
                        <input type="text" name="cep" id="cep" class="form-control"
                            required
                            placeholder="Digite seu CEP"
                            data-parsley-required-message="insira seu CEP.">
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="endereco" class="form-label">Endereço:</label>
                        <input type="text" name="endereco" id="endereco" class="form-control"
                            required
                            placeholder="Digite seu endereço"
                            data-parsley-required-message="insira seu endereço.">
                    </div>
                    <div class="mb-3 col-12 col-md-2">
                        <label for="numero" class="form-label">Número:</label>
                        <input type="text" name="numero" id="numero" class="form-control"
                            required
                            placeholder="Nº"
                            data-parsley-required-message="insira o número.">

                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="mb-3 col-12 col-md-3">
                        <label for="complemento" class="form-label">Complemento:</label>
                        <input type="text" name="complemento" id="complemento" class="form-control"
                            placeholder="Complemento (opcional)">
                    </div>
                    <div class="mb-3 col-12 col-md-3">
                        <label for="bairro" class="form-label">Bairro:</label>
                        <input type="text" name="bairro" id="bairro" class="form-control"
                            required
                            placeholder="Digite seu bairro"
                            data-parsley-required-message="insira seu bairro.">
                    </div>
                    <div class="mb-3 col-12 col-md-3">
                        <label for="cidade" class="form-label">Cidade:</label>
                        <input type="text" name="cidade" id="cidade" class="form-control"
                            required
                            placeholder="Digite sua cidade"
                            data-parsley-required-message="insira sua cidade.">
                    </div>
                    <div class="mb-3 col-12 col-md-3">
                        <label for="estado" class="form-label">Estado:</label>
                        <input type="text" name="estado" id="estado" class="form-control"
                            required
                            placeholder="Digite seu estado"
                            data-parsley-required-message="insira seu estado.">
                    </div>
                </div>
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
    $(document).ready(function() {
        $('#formCadastro').parsley();

        $('#cli_telefone').inputmask(["(99) 9999-9999", "(99) 99999-9999"]);
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const campoCep = document.getElementById("cep");
    const campoEndereco = document.getElementById("endereco");
    const campoBairro = document.getElementById("bairro");
    const campoCidade = document.getElementById("cidade");
    const campoEstado = document.getElementById("estado");

    // Máscara simples de CEP
    campoCep.addEventListener("input", function() {
        let cep = campoCep.value.replace(/\D/g, ""); // remove tudo que não é número
        if (cep.length > 5) {
            cep = cep.slice(0, 5) + "-" + cep.slice(5, 8);
        }
        campoCep.value = cep;
    });

    // Busca automática de endereço via ViaCEP
    campoCep.addEventListener("blur", async function() {
        const cep = campoCep.value.replace(/\D/g, "");
        if (cep.length === 8) {
            try {
                const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await response.json();

                if (!data.erro) {
                    campoEndereco.value = data.logradouro || "";
                    campoBairro.value = data.bairro || "";
                    campoCidade.value = data.localidade || "";
                    campoEstado.value = data.uf || "";
                } 
            }catch (error) {
                console.error("Erro ao buscar o CEP:", error);
            }
        }      
    });
});
</script>
