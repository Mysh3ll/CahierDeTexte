<?php

/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:28
 */
class DB
{
    private static $_instance = null;
    private $_pdo,
        $_query,
        $_erreur = false,
        $_resutats,
        $_count = 0,
        $_colonne = 0;

    private function __construct()
    {
        try {
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
        } catch (PDOException $e) {
            if (Config::get('env') == 'dev') {
                die("Échec lors de la connexion : " . $e->getMessage());
            } else {
                die();
            }
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }

        return self::$_instance;
    }

    public function query($sql, $parametres = [])
    {
        $this->_erreur = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $numeroParametre = 1;
            if (count($parametres)) {
                foreach ($parametres as $parametre) {
                    $this->_query->bindValue($numeroParametre, $parametre);
                    $numeroParametre++;
                }
            }
            if ($this->_query->execute()) {
                $this->_resutats = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
                $this->_colonne = $this->_query->columnCount();
                if ($this->_count == 0 && $this->_colonne == 0) {
                    $this->_erreur = true;
                }
            } if ($this->_count == 0) {
                $this->_erreur = true;
            }
        }

        return $this;
    }

    public function action($action, $table, $where = [])
    {
        if (count($where) === 3) {
            $comparateurs = ['=', '>', '<', '>=', '<='];

            $champ = $where[0];
            $comparateur = $where[1];
            $valeur = $where[2];

            if (in_array($comparateur, $comparateurs)) {
                $sql = " " . $action . " FROM " . $table . " WHERE " . $champ . " " . $comparateur . " ?";

                if (!$this->query($sql, [$valeur])->erreur()) {
                    return $this;
                } else {
                    $this->_count = 0;

                    return $this;
                }
            }
        }

        return false;
    }

    public function get($table, $where)
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function effacer($table, $where)
    {
        return $this->action('DELETE', $table, $where);
    }

    public function insertion($table, $champs = [])
    {
        $keys = array_keys($champs);
        $valeurs = '';
        $compteur = 1;

        foreach ($champs as $champ) {
            $valeurs .= "?";
            if ($compteur < count($champs)) {
                $valeurs .= ', ';
            }
            $compteur++;
        }

        $sql = "INSERT INTO " . $table . " (" . implode(',', $keys) . ") VALUES (" . $valeurs . ")";
        if (!$this->query($sql, $champs)->erreur()) {
            return true;
        }

        return false;
    }

    public function miseAJour($table, $idUser, $champs)
    {
        $selection .= '';
        $compteur = 1;

        foreach ($champs as $nom => $champ) {
            $selection .= " " . $nom . " = ?";
            if ($compteur < count($champs)) {
                $selection .= ', ';
            }
            $compteur++;
        }

        $sql = "UPDATE " . $table . " SET " . $selection . " WHERE idUser = " . $idUser . " ";
        if (!$this->query($sql, $champs)->erreur()) {
            return true;
        }

        return false;
    }

    public function resultats()
    {
        return $this->_resutats;
    }

    public function premierResultat()
    {
        return $this->resultats()[0];
    }

    public function erreur()
    {
        return $this->_erreur;
    }

    public function count()
    {
        return $this->_count;
    }
}