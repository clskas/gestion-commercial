<?php
require_once('identifier.php');
require_once('connexiondb.php');

?>
<! DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Gestion des entrées en stock</title>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
        <link rel="stylesheet" type="text/css" href="../css/mef.css">
        <script src="../js/jquery-3.3.1.js"></script>
        <script src="../js/monjs.js"></script>
        <script src="../js/prototype.js"></script>

    </head>
    <body>
    <?php include("menu.php"); ?>
    <div class="container">
        <div class="div_conteneur_parent">

            <div class="div_conteneur_page">
                <a href="." target="_self">
                    <img src="images/formation.png" style="width:50px;border:none;" align="left" alt="formateur informatique" />
                </a>

                <div class="div_int_page">

                    <script language='javascript' type="text/javascript">
                        function recolter()
                        {
                            document.getElementById("formulaire").request({
                                onComplete:function(transport){
                                    if(document.getElementById('tampon').value=='recup')
                                    {
                                        var tab_info = transport.responseText.split('|');
                                        document.getElementById('des_produit').value = tab_info[0];
                                        document.getElementById('qte_produit_avt').value = tab_info[1];
                                        document.getElementById('qte_produit_aps').value = "";
                                        document.getElementById('qte_produit').value = "";
                                    }
                                    else
                                    {
                                        if(transport.responseText=="ok")
                                        {
                                            document.getElementById('qte_produit_aps').value= parseInt(document.getElementById('qte_produit_avt').value) + parseInt(document.getElementById('qte_produit').value);
                                            document.getElementById('msg_reponse').innerText = "Le stock a été mis à jour avec succès";
                                        }
                                        else
                                            document.getElementById('msg_reponse').innerText = "Une erreur est survenue, le stock est inchangé";
                                    }
                                }
                            });
                        }
                    </script>
                    <div style="width:100%;display:block;text-align:center;">
                    </div>

                    <div class="div_saut_ligne" style="height:30px;">
                    </div>

                    <div style="float:left;width:10%;height:40px;"></div>

                    <div style="float:left;width:10%;height:40px;"></div>

                    <div class="div_saut_ligne" style="height:30px;">
                    </div>

                    <div style="float:left;width:10%;height:250px;"></div>
                    <div style="float:left;width:80%;height:250px;text-align:center;">
                        <form id="formulaire" name="formulaire" method="POST" action="stock.php">
                            <div class="titre_h1" style="height:250px;">
                                <div style="width:10%;height:75px;float:left;"></div>
                                <div style="width:35%;height:75px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                                    <label for="ref_produit">Référence à mettre à jour </label><br />
                                    <select id="ref_produit" name="ref_produit" onchange="document.getElementById('tampon').value='recup';recolter();">
                                        <option value="0">Choisir une référence</option>
                                        <?php
                                        $requete = "SELECT Article_code,Article_designation FROM articles ORDER BY Article_code";
                                        $retours=$pdo->query($requete);
                                        while($retour = $retours->fetch())
                                        {
                                            echo "<option value='".$retour["Article_code"]."'>".$retour["Article_code"]."</option>";
                                        }
                                        ?>
                                    </select>
                                    <input type="text" id="tampon" name="tampon" style="visibility:hidden;" />
                                </div>
                                <div style="width:10%;height:75px;float:left;"></div>
                                <div style="width:35%;height:75px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                                    <label for="des_produit">Désignation du produit</label><br />
                                    <input type="text" id="des_produit" name="des_produit" disabled />
                                </div>
                                <div style="width:10%;height:75px;float:left;"></div>


                                <div style="width:10%;height:75px;float:left;"></div>
                                <div style="width:20%;height:75px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                                    <label for="qte_produit">Quantité avant mise à jour</label><br />
                                    <input type="text" id="qte_produit" name="qte_produit" />
                                </div>
                                <div style="width:10%;height:75px;float:left;"></div>
                                <div style="width:20%;height:75px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                                    <label for="qte_produit_avt">Quantité avt MAJ</label><br />
                                    <input type="text" id="qte_produit_avt" name="qte_produit_avt" disabled />
                                </div>
                                <div style="width:10%;height:75px;float:left;"></div>
                                <div style="width:20%;height:75px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                                    <label for="qte_produit_aps">Quantité aps MAJ</label><br />
                                    <input type="text" id="qte_produit_aps" name="qte_produit_aps"  />
                                </div>
                                <div style="width:10%;height:75px;float:left;"></div>

                                <div class="div_saut_ligne" style="height:30px;">
                                </div>

                                <div style="width:10%;height:75px;float:left;"></div>
                                <div style="width:35%;height:75px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                                    <input type="button" id="valider" name="valider" value="Valider la mise à jour" onclick="document.getElementById('tampon').value='maj';recolter();" />
                                </div>
                                <div style="width:10%;height:75px;float:left;"></div>
                                <div id="msg_reponse" style="width:35%;height:75px;float:left;font-size:16px;font-weight:bold;text-align:left;">
                                    <?php
                                    echo "Réponse serveur";
                                    ?>
                                </div>
                                <div style="width:10%;height:75px;float:left;"></div>

                            </div>
                        </form>
                    </div>
                    <div style="float:left;width:10%;height:250px;"></div>

                    <div class="div_saut_ligne" style="height:50px;">
                    </div>

                </div>

            </div>
        </div>
    </div>
    </body>
    <?php
    //mysqli_close($liaison);
    ?>
</html>