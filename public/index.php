<?php
require "../config/Conexao.php";
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCE Celulares</title>

    <base href="http://<?= $_SERVER["SERVER_NAME"] . $_SERVER["SCRIPT_NAME"] ?>">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/all.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand" href="index"><img src="images/logo.png" alt="logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="produto" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Produtos
          </a>
          <ul class="dropdown-menu">
      <?php
        // Carregamento mínimo e seguro: evita avisos se a API estiver ausente ou retornar JSON inválido.
        $urlCategoria = "http://localhost/techAcademy4/public/apis/categoria.php";
        $respostaCategoria = @file_get_contents($urlCategoria);
        $dadosDecodificados = json_decode($respostaCategoria);

        if ($dadosDecodificados && (is_array($dadosDecodificados) || is_object($dadosDecodificados))) {
          // Converter para array para que foreach sempre funcione (objeto vira array de um elemento)
          foreach ((array)$dadosDecodificados as $categoria) {
            $idCategoria = $categoria->id ?? $categoria->ID ?? '';
            $nomeCategoria = $categoria->nome ?? $categoria->descricao ?? 'Categoria';
            $idCategoriaEsc = htmlspecialchars((string)$idCategoria, ENT_QUOTES);
            $nomeCategoriaEsc = htmlspecialchars((string)$nomeCategoria, ENT_QUOTES);
            echo "<li><a class='dropdown-item' href='produto/categoria/{$idCategoriaEsc}'>{$nomeCategoriaEsc}</a></li>";
          }
        }
      ?>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="carrinho"><i class="fas fa-shopping-cart"></i></a>
        </li>
      </ul>
    </div>
  </div>
</nav>
    <main class="container">
        <?php
        $param = "index";
        $img = "http://localhost/techacademy4/public/arquivos/";

        if (isset($_GET["param"])) {
            $param = explode("/", $_GET["param"]);
        }

        $controller = $param[0] ?? "index";
        $acao = $param[1] ?? "index";
        $id = $param[2] ?? NULL;

        $controller = ucfirst($controller) . "Controller";

        if (file_exists("../controllers/{$controller}.php")) {
          require "../controllers/{$controller}.php";  
          $control = new $controller();
            $control->$acao($id, $img);
        } else {
            require "../views/index/erro.php";
        }
        ?>
    </main>

</body>

</html>