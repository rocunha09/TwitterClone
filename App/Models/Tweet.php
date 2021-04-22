<?php


namespace App\Models;


use MF\Model\Model;

class Tweet extends Model {
    private $id;
    private $id_usuario;
    private $tweet;
    private $data;


    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        return $this->$atributo = $valor;
    }

    public function salvar(){
        $query = 'insert into tweets (id_usuario, tweet) values(:id_usuario, :tweet)';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':tweet', $this->__get('tweet'));
        $result = $stmt->execute();

        return $result;

    }
    //incluído limit e offset para paginação
    public function listar($limit, $offset){
        $query = "
                select 
                        t.id, t.id_usuario, t.tweet, u.nome, DATE_FORMAT(t.data, '%d/%m/%Y %H:%i') as data 
                from 
                        tweets as t 
                left join
                        usuarios as u 
                on 
                        (t.id_usuario = u.id)
                where 
                        t.id_usuario = :id_usuario
                or 
                        t.id_usuario            
                in 
                        (
                            select 
                                id_usuario_seguindo
                            from
                                usuarios_seguidores 
                            where 
                                id_usuario = :id_usuario
                        )         
                order by
                         t.data desc 
                limit
                    $limit
                offset
                    $offset                
                ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function totTweets(){
        $query = "
                select 
                        t.id, t.id_usuario, t.tweet, u.nome, DATE_FORMAT(t.data, '%d/%m/%Y %H:%i') as data 
                from 
                        tweets as t 
                left join
                        usuarios as u 
                on 
                        (t.id_usuario = u.id)
                where 
                        t.id_usuario = :id_usuario
                or 
                        t.id_usuario            
                in 
                        (
                            select 
                                id_usuario_seguindo
                            from
                                usuarios_seguidores 
                            where 
                                id_usuario = :id_usuario
                        )                       
                ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        $result = $stmt->rowCount();
        return $result;
    }

    public function excluir(){
        $query = "
                delete from 
                    tweets
                where
                    id = :id and id_usuario = :id_usuario  
                ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $result = $stmt->execute();

        return $result;

    }

}