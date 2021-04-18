<?php


namespace App\Models;


use MF\Model\Model;

class Usuario extends Model {
    private $id;
    private $nome;
    private $email;
    private $senha;


    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        return $this->$atributo = $valor;
    }


    public function salvar(){
        $query="insert into usuarios(nome, email, senha) values (:nome, :email, :senha)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha')); //vai usar md5 a princípio.
        $stmt->execute();
        $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this;
    }

    public function consultarExistente(){
        $query = "select * from usuarios where email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;

    }

    public function validarCadastro(){

        //validação vazia apenas para conceituar este tipo de funcionalidade.
        if(strlen($this->__get('nome')) < 3 || strlen($this->__get('email')) < 3){

            return false;
        }

        return true;
    }

    public function autenticar(){
        $query = "select id, nome,  email, senha from usuarios where email = :email and senha = :senha";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if(!empty($usuario)){
            $this->__set('id', $usuario['id']);
            $this->__set('nome', $usuario['nome']);
        }

        return $this;
       
    }


}