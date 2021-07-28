<?php


namespace App\Models;


use App\Db\Modelo;

class Cliente extends Modelo
{
    public function __construct()
    {
        parent::__construct("tb_clientes", ["id"]);
    }

    public function save()
    {
        $data = $this->safe();
        var_dump($data);

        if (!empty($this->id)) {
            $userId = $this->id;

            $response = $this->update($data, "id = :id", "id={$userId}");
            if (empty($response)) {
                $_SESSION['msn'] = "Erro ao atualizar, verifique os dados";
                return false;
            }
        } else {
            $response = $this->create($data);
            var_dump($response);
            if (empty($response)) {
                $_SESSION['msn'] = "Erro ao cadastrar, verifique os dados";
                return false;
            }
        }

        $_SESSION['msn'] = "Cadastrado com sucesso";
        return true;
    }
}