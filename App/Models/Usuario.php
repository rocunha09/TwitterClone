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

    public function procurarPor(){
        $query = "select id, nome, email from usuarios where nome like :nome and id != :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', '%'.$this->__get('nome').'%');
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function listarTodos(){
        $query = "
                select 
                       u.id, u.nome, u.email,
                       (
                           select 
                                  count(*) 
                           from  
                                usuarios_seguidores as us 
                           where 
                                 us.id_usuario = :id_usuario
                            and
                                us.id_usuario_seguindo = u.id 
                           ) as seguindo
                from 
                     usuarios as u
                where 
                      u.id != :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function seguindo($id_usuario_seguindo){
        $query = "
                select 
                    id_usuario, id_usuario_seguindo 
                from 
                    usuarios_seguidores 
                where 
                    id_usuario = :id_usuario and id_usuario_seguindo = :id_usuario_seguindo";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
        $stmt->execute();

        $result = $stmt->rowCount();

        return $result;
    }


    public function seguir($id_usuario_seguindo){
        $query = "
                insert into 
                    usuarios_seguidores(id_usuario, id_usuario_seguindo) 
                values(:id_usuario, :id_usuario_seguindo)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
        $result = $stmt->execute();

        return $result;

    }

    public function deixarDeSeguir($id_usuario_seguindo){
        $query = "
                delete from 
                    usuarios_seguidores
                where
                    id_usuario = :id_usuario and id_usuario_seguindo = :id_usuario_seguindo 
                ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
        $result = $stmt->execute();

        return $result;

    }


}