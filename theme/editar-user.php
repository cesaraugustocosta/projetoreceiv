<?php

if (!is_numeric($rota[1])) {
    redirect();
}

$post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if(!empty($post)){
    $cliente_update = new \App\Controllers\Clientes();
    $cliente_update->editar($rota[1], $post);
}

$cliente = (new \App\Models\Cliente())->read("id=:id", "id={$rota[1]}")->fetch();
?>
<!--FORMULARIO DE CADASTRO-->
<div class="row container">
    <p>&nbsp;</p>
    <form action="" method="post" class="col s12">
        <fieldset class="formulario">
            <legend><img src="<?= $tema; ?>/assets/imagens/avatar.jpg" alt=[imagem] width="100"></legend>
            <h5 class="light center"> Editar Cliente</h5>

            <div class="input-field col s12">
                <i class="material-icons prefix">account_circle</i>
                <input type="text" name="nome" id="nome" maxlength="40" required="autofocus"
                       value="<?= $cliente->nome; ?>">
                <label for="nome">Nome do Cliente</label>
            </div>

            <div class="input-field col s12">
                <i class="material-icons prefix">fingerprint</i>
                <input type="number" name="cpf" id="cpf" maxlength="15" required value="<?= $cliente->cpf; ?>">
                <label for="cpf">CPF do Cliente</label>
            </div>
            <div class="input-field col s12">
                <i class="material-icons prefix">date_range</i>
                <input type="date" name="data_nasc" id="data_nasc" maxlength="40" required
                       value="<?= date("Y-m-d", strtotime($cliente->data_nasc)); ?>">
                <label for="data_nasc">Data de Nascimento</label>
            </div>
            <div class="input-field col s12">
                <i class="material-icons prefix">home</i>
                <input type="text" name="endereco" id="endereco" maxlength="40" required
                       value="<?= $cliente->endereco; ?>">
                <label for="endereco">Endereço</label>
            </div>


            <div class="input-field col s12">
                <i class="material-icons prefix">home</i>
                <input type="number" name="valor" id="valor" required value="<?= $cliente->valor; ?>">
                <label for="valor">Valor (R$)</label>
            </div>
            <div class="input-field col s12">
                <i class="material-icons prefix">home</i>
                <input type="date" name="data_vencimento" id="data_vencimento" required
                       value="<?= date("Y-m-d", strtotime($cliente->data_vencimento)); ?>">
                <label for="data_vencimento">Data de vencimento</label>
            </div>
            <div class="input-field col s12">
                <i class="material-icons prefix">home</i>
                <textarea class="materialize-textarea" rows="5" name="descricao" id="descricao"
                          required><?= $cliente->descricao; ?></textarea>
                <label for="descricao">Descrição do título</label>
            </div>


            <!--Botoes-->
            <div class="input-field col s12">
                <input type="submit" value="atualizar" class="btn blue">
                <input type="reset" value="limpar" class="btn red">
            </div>
        </fieldset>
    </form>
</div>
