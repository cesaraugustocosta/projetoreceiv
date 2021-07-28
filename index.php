<?php

ob_start();
session_start();

require __DIR__ . "/src/Config.php";
require __DIR__ . "/vendor/autoload.php";


// ROTA
$rota = trim(strip_tags(filter_input(INPUT_GET, "url", FILTER_DEFAULT) ?? "/"));
$rota = (substr($rota, "-1") == "/" ? substr($rota, 0, -1) : $rota);
$rota = ($rota ? $rota : 'index');
$rota = explode('/', $rota);


$tema = URL_BASE . "/theme";
$dir_tema = __DIR__ . "/theme";

?><!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--CSS do materialize-->
        <link type="text/css" rel="stylesheet" href="<?= $tema; ?>/assets/css/materialize.min.css"
              media="screen,projection"/>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Sistema</title>
    </head>
    <body>

    <nav class="blue-grey">
        <div class="nav-wrapper container">
            <div class="brand-logo light"><a href="<?=URL_BASE;?>">Dashboard</a></div>
            <ul class="right">
                <li><a href="<?= URL_BASE; ?>/listar-users"><i class="material-icons left">account_circle</i>Clientes</a></li>
                <li><a href="<?= URL_BASE; ?>/cadastrar-user"><i class="material-icons left">add_circle</i>Novo Cliente</a></li>
            </ul>
        </div>
    </nav>

    <?php
    if($rota[0] == 'editar-user' && !empty($rota[1])) {
        require "{$dir_tema}/{$rota[0]}.php";
    }elseif($rota[0] == 'deletar-user' && !empty($rota[1])) {
        require "{$dir_tema}/{$rota[0]}.php";
    }elseif(empty($rota[1]) && file_exists("{$dir_tema}/{$rota[0]}.php")){
        require "{$dir_tema}/{$rota[0]}.php";
    }else{
        require "{$dir_tema}/home.php";
    }
    ?>

    <!--ARQUIVOS JQUERY e JavaScript-->
    <script type="text/javascript" src="<?= $tema; ?>/assets/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="<?= $tema; ?>/assets/js/materialize.min.js"></script>

    <!-- INICIALIZAÇÃO JQUERY-->
    <script type="text/javascript">
        $(document).ready(function () {
            // Ações aqui
            $("[data-delete]").click(function (e) {
                e.preventDefault();

                const clicked = $(this);
                const data = clicked.data();

                const deleteConfirm = confirm("Deseja deletar esse cliente?");
                if (!deleteConfirm) {
                    return;
                }
                $.post(data.uri, data, function (response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                }, "json");

            });
        });
    </script>
    </body>
    </html>
<?php
ob_end_flush();