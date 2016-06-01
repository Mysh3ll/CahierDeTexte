<?php

/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:29
 */
class Validation
{
    private $_valider = false,
            $_erreurs = [],
            $_db = null;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function check($source, $champs = [])
    {
        foreach ($champs as $champ => $regles) {
            foreach ($regles as $regle => $valeur_regle) {
                $valeur = trim($source[$champ]);
                $champ = protection($champ);
                
                if ($regle === 'required' && empty($valeur)){
                    $this->ajouterErreur("Votre " . $regles['nom'] . " est obligatoire");
                } else if (!empty($valeur)){
                    switch ($regle){
                        case 'min' :
                            if (strlen($valeur) < $valeur_regle) {
                                $this->ajouterErreur("Votre " . $regles['nom'] . " doit contenir au minimum " . $valeur_regle . " charactères. ");
                            }
                        break;
                        case 'max' :
                            if (strlen($valeur) > $valeur_regle) {
                                $this->ajouterErreur("Votre " . $regles['nom'] . " doit contenir au maximum " . $valeur_regle . " charactères. ");
                            }
                        break;
                        case 'correspond' :
                            if ($valeur != $source[$valeur_regle]) {
                                $this->ajouterErreur("Votre mot de passe doit correspondre !");
                            }
                        break;
                        case 'unique' :
                            $check = $this->_db->get($valeur_regle, [$champ, '=', $valeur]);
                            if ($check->count()) {
                                $this->ajouterErreur(" " . $regles['nom'] . " déjà existante.");
                            }
                        break;
                        default :

                        break;
                    }
                }
            }
        }
        if (empty($this->_erreurs)) {
            $this->_valider = true;
        }
        return $this;
    }

    private function ajouterErreur($erreur)
    {
        $this->_erreurs[]= $erreur;
    }

    public function erreurs()
    {
        return $this->_erreurs;
    }

    public function valider()
    {
        return $this->_valider;
    }
}