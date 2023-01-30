<?php

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*                Fonctions de base de gestion du panier                   */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* Initialisation du panier */

function ajout($select)
{
    if(!isset($_SESSION['panier']))
    {
        /* Initialisation du panier */
        $_SESSION['panier'] = array();
        /* Subdivision du panier */
        $_SESSION['panier']['code'] = array();
        $_SESSION['panier']['id_sstach'] = array();
        $_SESSION['panier']['tache'] = array();
        $_SESSION['panier']['date_debut'] = array();
        $_SESSION['panier']['date_fin'] = array();
        $_SESSION['panier']['taux'] = array();

    }

    $ajout = false;
    if(!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false)
    {

        if(!verif_panier($select['code']))
        {
            array_push($_SESSION['panier']['code'],$select['code']);
            array_push($_SESSION['panier']['id_sstach'],$select['id_sstach']);
            array_push($_SESSION['panier']['tache'],$select['tache']);
            array_push($_SESSION['panier']['taux'],$select['taux']);
            array_push($_SESSION['panier']['date_debut'],$select['date_debut']);
            array_push($_SESSION['panier']['date_fin'],$select['date_fin']);
            $ajout = true;
        }
        else
        {
            $ajout = modif_st($select['code'],$select['id_sstach'], $select['tache'],$select['date_debut'], $select['date_fin'],$select['taux']);
        }
    }
    return $ajout;
}
/**
 * Modifie le nombre de journalier d'un article dans le panier après vérification que nous ne somme pas en phase de paiement
 *
 * @param String $ref_article    Identifiant de l'article à modifier
 * @param String $tache         tâche à modifier
 * @param String $datedebut      date début à modifier
 * @param String $taux          exécutant à modifier
 * @param String $datefin       date fin à modifier
 * @param String $datefin       date fin à modifier
 * @return Mixed                 Retourne VRAI si la modification a bien eu lieu,
 *                               FAUX sinon,
 *                               "absent" si l'article est absent du panier,
 *                               "nbre_ok" si le nombre n'est pas modifiée car déjà correctement enregistrée.
 */

function modif_st($code,$ref_article, $tache, $datedebut, $datefin,$taux)
{
    /* On initialise la variable de retour */
    $modifie = false;
    if (!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false) {
        if ((nombre_article($code) != false)) {
            /* On compte le nombre d'articles différents dans le panier */
            $nb_articles = count($_SESSION['panier']['code']);
            /* On parcoure le tableau de session pour modifier l'article précis. */
            for ($i = 0; $i < $nb_articles; $i++) {
                if ($code == $_SESSION['panier']['code'][$i]) {
                    $_SESSION['panier']['code'][$i] = $code;
                    $_SESSION['panier']['tache'][$i] = $tache;
                    $_SESSION['panier']['date_debut'][$i] = $datedebut;
                    $_SESSION['panier']['date_fin'][$i] = $datefin;
                    $_SESSION['panier']['taux'][$i] = $taux;
                    $modifie = true;
                }
            }
        } else {
            /* L'article est absent du panier, donc on ne peut pas modifier la quantité ou bien
            * le nombre est exactement le même et il est inutile de le modifier
            * Si l'article est absent, comme on a ni la taille  ni le prix, on ne peut pas l'ajouter
            * Si le nombre est le même, on ne fait pas de changement. On peut donc retourner un autre
            * type de valeur pour indiquer une erreur qu'il faudra traiter à part lors du retour d'appel
            */
            if (nombre_article($code) != false) {
                $modifie = "absent";
            }
            if ($datedebut != nombre_article($code) || $datefin != nombre_article($code)) {
                $modifie = "nbreJ_ok";
            }
        }
    }
    return $modifie;
}



/**
 * Supprimer un article du panier : autre méthode.
 * @param String $ref_article    Identifiant de l'article à supprimer
 * @param Boolean    $reindex : facultatif, par défaut, vaut true pour ré-indexer le tableau après
 *                   suppression. On peut envoyer false si cette ré-indexation n'est pas nécessaire.
 * @return Mixed     Retourne TRUE si la suppression a bien été effectuée,
 *                   FALSE sinon, "absent" si l'article était déjà retiré du panier
 */
function supprim_article($code)
{
    $suppression = false;
    if(!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false)
    {
        /* On vérifie que l'article à supprimer est bien présent dans le panier */
        if(nombre_article($code) != false)
        {
            /* création d'un tableau temporaire de stockage des articles */
            $panier_tmp = array("code"=>array(), "tache"=>array(), "id_sstach"=>array(),"date_debut"=>array(),"date_fin"=>array(),"taux"=>array());
            /* Comptage des articles du panier */
            $nb_articles = count($_SESSION['panier']['code']);
            /* Transfert du panier dans le panier temporaire */
            for($i = 0; $i < $nb_articles; $i++)
            {
                /* On transfère tout sauf l'article à supprimer */
                if($_SESSION['panier']['code'][$i] != $code)
                {
                    array_push($panier_tmp['code'],$_SESSION['panier']['code'][$i]);
                    array_push($panier_tmp['tache'],$_SESSION['panier']['tache'][$i]);
                    array_push($panier_tmp['id_sstach'],$_SESSION['panier']['id_sstach'][$i]);
                    //array_push($panier_tmp['exec'],$_SESSION['panier']['exec'][$i]);
                    array_push($panier_tmp['date_debut'],$_SESSION['panier']['date_debut'][$i]);
                    array_push($panier_tmp['date_fin'],$_SESSION['panier']['date_fin'][$i]);
                    array_push($panier_tmp['taux'],$_SESSION['panier']['taux'][$i]);
                }
            }
            /* Le transfert est terminé, on ré-initialise le panier */
            $_SESSION['panier'] = $panier_tmp;
//            var_dump( $_SESSION['panier']);
            /* Option : on peut maintenant supprimer notre panier temporaire: */
            unset($panier_tmp);
            $suppression = true;
        }
        else
        {
            $suppression = "absent";
        }
    }
    return $suppression;
}
/**
 * Vérifie la présence d'un article dans le panier
 * @param String $ref_article    Identifiant de l'article à verifier
 * @return Boolean Renvoie Vrai si l'article est trouvé dans le panier, Faux sinon
 */
function verif_panier($code)
{
    /* On initialise la variable de retour */
    $present = false;
    /* On vérifie les numéros de références des articles et on compare avec l'article à vérifier */
    if(count($_SESSION['panier']['code']) > 0 && array_search($code,$_SESSION['panier']['code']) !== false)
    {
        $present = true;
    }
    return $present;
}
/**
 * Fonction qui supprime tout le contenu du panier en détruisant la variable après
 * vérification qu'on ne soit pas en phase de paiement.
 *
 * @return Mixed    Retourne VRAI si l'exécution s'est correctement déroulée, Faux sinon et "inexistant" si
 *                  le panier avait déjà été détruit ou n'avait jamais été créé.
 */
function vider_panier()
{
    $vide = false;
    if(!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false)
    {
        if(isset($_SESSION['panier']))
        {
            unset($_SESSION['panier']);
            if(!isset($_SESSION['panier']))
            {
                $vide = true;
            }
        }
        else
        {
            /* Le panier était déjà détruit, on renvoie une autre valeur exploitable au retour */
            $vide = "inexistant";
        }
    }
    return $vide;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*                 Fonctions annexes de gestion du panier                  */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/**
 * Vérifie la quantité enregistrée d'un article dans le panier
 *
 * @param String $ref_article    Identifiant de l'article à verifier
 * @return Mixed Renvoie le nombre d'article s'il y en a, ou Faux si cet article est absent du panier
 */
function nombre_article($code)
{
    /* On initialise la variable de retour */
    $nombre = false;
    /* Comptage du panier */
    $nb_art = count($_SESSION['panier']['code']);

    /* On parcoure le panier à la recherche de l'article pour vérifier le cas échéant combien sont enregistrés */
    for($i = 0; $i < $nb_art; $i++)
    {
        if($_SESSION['panier']['code'][$i] == $code)
            $nombre = $_SESSION['panier']['code'][$i];
    }
    return $nombre;
}

function nombre_article2($ref_article)
{
    /* On initialise la variable de retour */
    $nombre = false;
    /* Comptage du panier */
    $nb_art = count($_SESSION['panier']['libtache']);
    /* On parcoure le panier à la recherche de l'article pour vérifier le cas échéant combien sont enregistrés */
    for($i = 0; $i < $nb_art; $i++)
    {
        if($_SESSION['panier']['idop'][$i] == $ref_article)
            $nombre = $_SESSION['panier']['nbrejourna'][$i];
    }
    return $nombre;
}
/**
 * Calcule le montant total du panier
 *
 * @return Double
 */
//function montant_panier()




/**
 * Fonction de verrouillage du panier pendant la phase de paiement.
 *
 */
function preparerPaiement()
{
    $_SESSION['panier']['verrouille'] = true;
    header("Location: URL_DU_SITE_DE_BANQUE");
}

/**
 * Fonction qui va enregistrer les informations de la commande dans
 * la base de données et détruire le panier.
 *
 */
function paiementAccepte()
{
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
    /*   Stockage du panier dans la BDD   */
    /* ajoutez ici votre code d'insertion */
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
    unset($_SESSION['panier']);
}
?>