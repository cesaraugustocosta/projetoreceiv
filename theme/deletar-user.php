<?php

require __DIR__ . "/../src/Config.php";
require __DIR__ . "/../vendor/autoload.php";

$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if (!empty($post)) {
    $cliente = new \App\Controllers\Clientes();
    $delete = $cliente->deletar($post['delete']);

    if ($delete) {
        echo json_encode(["redirect" => URL_BASE . "/listar-users"]);
    }
}

