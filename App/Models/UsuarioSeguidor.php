<?php

namespace App\Models;

use MF\Model\Model;

class UsuarioSeguidor extends Model
{
    private $id;
    private $id_usuario;
    private $id_usuario_seguindo;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function seguirUsuario(int $idUsuarioSeguindo) : bool
    {
        $query = "insert into usuarios_seguidores(id_usuario, id_usuario_seguindo)
                  values (:id_usuario, :id_usuario_seguindo)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':id_usuario_seguindo', $idUsuarioSeguindo);
        $stmt->execute();

        return true;
    }

    public function deixarSeguirUsuario(int $idUsuarioSeguindo) : bool
    {
        $query = "delete from 
                    usuarios_seguidores
                  where id_usuario = :id_usuario and
                        id_usuario_seguindo = :id_usuario_seguindo";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':id_usuario_seguindo', $idUsuarioSeguindo);
        $stmt->execute();

        return true;
    }

    public function getTotalSeguindo()
    {
        $query = "select
                    COUNT(id_usuario_seguindo) AS seguindo
                  from
                    usuarios_seguidores
                  where
                    id_usuario = :id_usuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

    public function getTotalSeguidores()
    {
        $query = "select
                    COUNT(id_usuario_seguindo) AS seguidores
                  from
                    usuarios_seguidores
                  where
                    id_usuario_seguindo = :id_usuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}