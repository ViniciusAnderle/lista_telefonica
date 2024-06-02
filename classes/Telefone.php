<?php
// Definição da interface TelefoneInterface com métodos para obter e definir informações de telefone
interface TelefoneInterface {
    public function getId();
    public function getContatoId();
    public function getTelefone();
    public function getTelefoneResidencial();
    public function getTelefoneCelular();
    public function setId($id);
    public function setContatoId($contato_id);
    public function setTelefone($telefone_comercial);
    public function setTelefoneResidencial($telefone_residencial);
    public function setTelefoneCelular($telefone_celular);
}

// Classe abstrata TelefoneAbstrato que implementa TelefoneInterface e fornece implementações padrão
abstract class TelefoneAbstrato implements TelefoneInterface {
    protected $id;
    protected $contato_id;
    protected $telefone_comercial;
    protected $telefone_residencial;
    protected $telefone_celular;

    // Implementações dos métodos da interface
    public function getId() {
        return $this->id;
    }

    public function getContatoId() {
        return $this->contato_id;
    }

    public function getTelefone() {
        return $this->telefone_comercial;
    }

    public function getTelefoneResidencial() {
        return $this->telefone_residencial;
    }

    public function getTelefoneCelular() {
        return $this->telefone_celular;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setContatoId($contato_id) {
        $this->contato_id = $contato_id;
    }

    public function setTelefone($telefone_comercial) {
        $this->telefone_comercial = $telefone_comercial;
    }

    public function setTelefoneResidencial($telefone_residencial) {
        $this->telefone_residencial = $telefone_residencial;
    }

    public function setTelefoneCelular($telefone_celular) {
        $this->telefone_celular = $telefone_celular;
    }
}

// Classe concreta Telefone que estende TelefoneAbstrato e implementa seu construtor para definir os valores iniciais dos atributos
class Telefone extends TelefoneAbstrato {
    public function __construct($contato_id, $telefone_comercial, $telefone_residencial, $telefone_celular) {
        $this->contato_id = $contato_id;
        $this->telefone_comercial = $telefone_comercial;
        $this->telefone_residencial = $telefone_residencial;
        $this->telefone_celular = $telefone_celular;
    }
}
