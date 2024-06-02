<?php
// Definição da interface ContatoInterface com métodos para obter e definir informações de contato
interface ContatoInterface {
    public function getNomeCompleto();
    public function getCpf();
    public function getEmail();
    public function getDataNascimento();
    public function setNomeCompleto($nomeCompleto);
    public function setCpf($cpf);
    public function setEmail($email);
    public function setDataNascimento($dataNascimento);
}

// Classe abstrata ContatoAbstrato que implementa ContatoInterface e fornece implementações padrão
abstract class ContatoAbstrato implements ContatoInterface {
    protected $nomeCompleto;
    protected $cpf;
    protected $email;
    protected $dataNascimento;

    // Implementações dos métodos da interface
    public function getNomeCompleto() {
        return $this->nomeCompleto;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function setNomeCompleto($nomeCompleto) {
        $this->nomeCompleto = $nomeCompleto;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }
}

// Classe concreta Contato que estende ContatoAbstrato e implementa seu construtor para definir os valores iniciais dos atributos
class Contato extends ContatoAbstrato {
    public function __construct($nomeCompleto, $cpf, $email, $dataNascimento) {
        $this->nomeCompleto = $nomeCompleto;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->dataNascimento = $dataNascimento;
    }
}
