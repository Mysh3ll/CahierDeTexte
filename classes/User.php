<?php

/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:29
 */
class User
{
    private $_db,
        $_donnees,
        $_sessionNom,
        $_cookieNom,
        $_etreLogger;

    public function __construct($user)
    {
        $this->_db = DB::getInstance();
        $this->_sessionNom = Config::get('session/session_nom');
        $this->_cookieNom = Config::get('remember/cookie_nom');

        if (!$user) {
            if (Session::existe($this->_sessionNom)) {
                $user = Session::get($this->_sessionNom);

                if ($this->trouver($user)) {
                    $this->_etreLogger = true;
                } else {
                    // logout
                }
            }
        } else {
            $this->trouver($user);
        }
    }

    public function miseAJour($champs = [], $idUser = null)
    {
        if (!$idUser && $this->etreLogger()) {
            $idUser = $this->donnees()->idUser;
        }

        if (!$this->_db->miseAJour('Utilisateur', $idUser, $champs)) {
            throw new Exception('Problème lors de la mise à jours des données');
        }
    }

    public function creer($champs = [])
    {
        if (!$this->_db->insertion('Utilisateur', $champs)) {
            throw new Exception('Il y a eu un problème lors de la création du compte');
        }
    }

    public function trouver($user = null)
    {
        if ($user) {
            $champs = (is_numeric($user)) ? 'idUser' : 'mailUser';
            $donnees = $this->_db->get('Utilisateur', [$champs, '=', $user]);

            if ($donnees->count()) {
                $this->_donnees = $donnees->premierResultat();

                return true;
            }
        }

        return false;
    }

    public function login($mailUser = null, $pwdUser = null, $seSouvenir = false)
    {

        if (!$mailUser && !$pwdUser && $this->existe()) {
            Session::put($this->_sessionNom, $this->donnees()->idUser);
        } else {
            $user = $this->trouver($mailUser);

            if ($user) {
                if ($this->donnees()->pwdUser === $pwdUser) {
                    Session::put($this->_sessionNom, $this->donnees()->idUser);
                    $this->_db->miseAJour('Utilisateur', $this->donnees()->idUser, [
                                'timeTokenUser' => date('Y-m-d H:i:s')
                            ]);

                    if ($seSouvenir) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('Utilisateur', ['idUser', '=', $this->donnees()->idUser]);

                        if (!$hashCheck->count()) {
                            $this->_db->miseAJour('Utilisateur', $this->donnees()->idUser, [
                                'tokenUser' => $hash
                            ]);
                        } else {
                            $hash = $hashCheck->premierResultat()->tokenUser;
                            $this->_db->miseAJour('Utilisateur', $this->donnees()->idUser, [
                                'timeTokenUser' => date('Y-m-d H:i:s')
                            ]);

                        }

                        Cookie::put($this->_cookieNom, $hash, Config::get('remember/cookie_expiration'));
                    }

                    return true;
                }
            }
        }

        return false;
    }

    public function existe()
    {
        return (!empty($this->_donnees() ? true : false));
    }

    public function logout()
    {
        Session::effacer($this->_sessionNom);
        Cookie::effacer($this->_cookieNom);
    }

    public function donnees()
    {
        return $this->_donnees;
    }

    public function etreLogger()
    {
        return $this->_etreLogger;
    }
}