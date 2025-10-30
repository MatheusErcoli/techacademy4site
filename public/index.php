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
            <a class="navbar-brand fw-bold" href="index">
                <img src="images/logo.png" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index">Home</a>
                    </li>

                    <?php
                    $urlCategoria = "http://localhost/techacademy-4/public/apis/categoria.php";
                    $dadosCategoria = json_decode(file_get_contents($urlCategoria));

                    foreach ($dadosCategoria as $dados) {
                    ?>
                        <li class="nav-item">
                            <a href="categoria/index/<?= $dados->id ?>" class="nav-link">
                                <?= $dados->descricao ?>
                            </a>
                        </li>
                    <?php
                    }

                    ?>

                    <li class="nav-item">
                        <a class="nav-link" href="carrinho">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <main class="container">
        <?php
        $param = "index";
        $img = "http://localhost/techacademy-4/public/arquivos/";

        if (isset($_GET["param"])) {
            $param = explode("/", $_GET["param"]);
        }

        $controller = $param[0] ?? "index";
        $acao = $param[1] ?? "index";
        $id = $param[2] ?? NULL;

        $controller = ucfirst($controller) . "Controller";

        if (file_exists("../controllers/{$controller}.php")) {
            $control = new $controller();
            $control->$acao($id, $img);


            require "../controllers/{$controller}.php";
        } else {
            require "../views/index/erro.php";
        }
        ?>
    </main>

</body>

</html>