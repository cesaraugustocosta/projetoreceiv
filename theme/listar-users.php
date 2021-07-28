<?php
$clientes = (new \App\Models\Cliente())->read()->fetch(true);
?>
<div class="row container">
    <?php
    if (!empty($_SESSION['msn'])) {
        echo $_SESSION['msn'];
        unset($_SESSION['msn']);
    }

    if (!empty($clientes)): ?>
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>CPF</th>
                <th>Vencimento</th>
                <th>Valor (R$)</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($clientes as $cliente):
                ?>
                <tr>
                    <td><?= $cliente->id; ?></td>
                    <td><?= $cliente->nome; ?></td>
                    <td><?= $cliente->cpf; ?></td>
                    <td><?= date("d/m/Y", strtotime($cliente->data_vencimento)); ?></td>
                    <td><?= number_format($cliente->valor, 2, ",", "."); ?></td>
                    <td>
                        <a href="<?= URL_BASE . "/editar-user/{$cliente->id}"; ?>"
                           class="waves-effect waves-light btn-small"><i
                                    class="material-icons left">create</i>Editar</a>
                        <a href="#"
                          data-delete="<?= $cliente->id; ?>"
                          data-uri="<?= URL_BASE . "/theme/deletar-user.php"; ?>"
                          class="waves-effect waves-light btn-small"><i class="material-icons left">delete</i>Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php
    else:
        echo 'Nenhum cliente cadastrado';
    endif;
    ?>
</div>





