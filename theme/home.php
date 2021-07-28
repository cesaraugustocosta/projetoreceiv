<?php
$clientes = (new \App\Models\Cliente())->read('1=1 LIMIT 10')->fetch(true);

$labels = [];
$data = [];
?>
<div class="row container">


    <!--grafico-->
    <canvas class="line-chart"></canvas>


    <main><!-- Tables -->
        <div class="container">

            <div class="row">
                <div class="col s12">
                    <h2 class="section-title">Últimos Clientes Cadastrados</h2>

                    <div class="card">
                        <?php
                        if (!empty($_SESSION['msn'])) {
                            echo $_SESSION['msn'];
                            unset($_SESSION['msn']);
                        }

                        if (!empty($clientes)): ?>
                            <table id="table-custom-elements" class="row-border" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th><label></th>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Endereço</th>
                                    <th>Descrição da Divida</th>
                                    <th>Data de Vencimento</th>
                                    <th>Valor</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($clientes as $cliente):
                                    $labels[] = date("d/m/Y", strtotime($cliente->data_vencimento));
                                    $data[] = number_format($cliente->valor, 2, ".", "");
                                    ?>
                                    <tr>
                                        <th>
                                        <td><?= $cliente->id; ?></td>
                                        </th>
                                        <td><?= $cliente->nome; ?></td>
                                        <td><?= $cliente->cpf; ?></td>
                                        <td><?= $cliente->endereco; ?></td>
                                        <td><?= $cliente->descricao; ?></td>
                                        <td><?= date("d/m/Y", strtotime($cliente->data_vencimento)); ?></td>
                                        <td>R$ <?= number_format($cliente->valor, 2, ",", "."); ?></td>
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
                    <div class="">
                        <ul class="pagination">
                            <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
                            <li class="active"><a href="#!">1</a></li>
                            <li class="waves-effect"><a href="#!">2</a></li>
                            <li class="waves-effect"><a href="#!">3</a></li>
                            <li class="waves-effect"><a href="#!">4</a></li>
                            <li class="waves-effect"><a href="#!">5</a></li>
                            <li class="waves-effect"><a href="#!">
                                    <i class="material-icons">chevron_right</i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </main>

</div>


<!-- incluir Chart JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script>
    var ctx = document.getElementsByClassName("line-chart");

    //Tipo, Dado e Opções
    var chartGraph = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["<?= implode('","', $labels);?>"],
            datasets: [{
                label: "Ultimos Clientes cadastrados e suas dividas",
                data: ["<?= implode('","', $data);?>"],
                borderWidth: 6,
                borderColor: "rgba(77,166,253,0.85)",
                backgroundColor: "transparent",
            },
            ]
        },
        options: {
            title: {
                display: true,
                fontSize: 30,
                text: "RELATÓRIO DE DIVIDAS POR CLIENTES"
            },
            labels: {
                fontStyle: "bold"
            }
        }
    });
</script>