<?php
    function rechercher_par_login($logins)
    {
        global $pdo;
        $requetelogin=$pdo->prepare("SELECT * FROM utilisateur WHERE logins=?");
        $requetelogin->execute(array($logins));
        return $requetelogin->rowCount();
    }

    function rechercher_par_email($email)
    {
        global $pdo;
        $requeteemail=$pdo->prepare("SELECT * FROM utilisateur WHERE email=?");
        $requeteemail->execute(array($email));
        return $requeteemail->rowCount();
    }

    function rechercher_user_par_email($email)
    {
        global $pdo;
        $requeteuserparemail=$pdo->prepare("SELECT * FROM utilisateur WHERE email=?");
        $requeteuserparemail->execute(array($email));
        $nbr_user=$requeteuserparemail->rowCount();
        return $nbr_user;
    }
?>