<?php


namespace App\Controllers;


use App\Models\Cliente;

class Clientes
{
    public function cadastrar(array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $cliente = new Cliente();
        $cliente->nome = $data['nome'];
        $cliente->cpf = $data['cpf'];
        $cliente->data_nasc = $data['data_nasc'];
        $cliente->endereco = $data['endereco'];
        $cliente->valor = $data['valor'];
        $cliente->data_vencimento = $data['data_vencimento'];
        $cliente->descricao = $data['descricao'];

        if($cliente->save()){
            redirect("listar-users");
        }
    }

    public function editar(int $id, array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $cliente = (new \App\Models\Cliente())->read("id=:id", "id={$id}")->fetch();
        $cliente->nome = $data['nome'];
        $cliente->cpf = $data['cpf'];
        $cliente->data_nasc = $data['data_nasc'];
        $cliente->endereco = $data['endereco'];
        $cliente->valor = $data['valor'];
        $cliente->data_vencimento = $data['data_vencimento'];
        $cliente->descricao = $data['descricao'];

        if($cliente->save()){
            redirect("listar-users");
        }
    }

    public function deletar(int $id)
    {
        $cliente = (new \App\Models\Cliente())->delete('id=:id',"id={$id}");
        return $cliente;
    }
}