<?php
// Interface que define os métodos para um endereço
interface EnderecoInterface {
    public function getCep();
    public function getEndereco();
    public function getNumeroResidencia();
    public function getBairro();
    public function getCidade();
    public function getUf();
    public function salvarEndereco($contato_id); // Método abstrato a ser implementado pelas classes concretas
}

// Classe abstrata que fornece implementações padrão para a interface de endereço
abstract class EnderecoAbstrato implements EnderecoInterface {
    protected $cep;
    protected $endereco;
    protected $numero_residencia;
    protected $bairro;
    protected $cidade;
    protected $uf;

    public function getCep() {
        return $this->cep;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getNumeroResidencia() {
        return $this->numero_residencia;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getUf() {
        return $this->uf;
    }

    public function salvarEndereco($contato_id) {
        // Implementação padrão para salvar endereço
        // Este método pode ser sobrescrito pelas classes concretas se necessário
    }
}

// Classe concreta de Endereco que estende a classe abstrata e implementa o construtor
class Endereco extends EnderecoAbstrato {
    public function __construct($cep, $endereco, $numero_residencia, $bairro, $cidade, $uf) {
        $this->cep = $cep;
        $this->endereco = $endereco;
        $this->numero_residencia = $numero_residencia;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->uf = $uf;
    }
}
?>
