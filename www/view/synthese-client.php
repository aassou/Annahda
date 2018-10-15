<?php
    include('../autoload.php');
    //process begin
    if ( isset($_POST['idContrat']) ) {
        //load classes managers
        $clientManager = new ClientManager($pdo);
        $contratManager = new ContratManager($pdo);
        $projetManager = new ProjetManager($pdo);
        $appartementManager = new AppartementManager($pdo);
        $locauxManager = new LocauxManager($pdo);
        $operationManager = new OperationManager($pdo);
        //begin processing
        $idContrat = htmlentities($_POST['idContrat']);
        $requete = "SELECT * FROM t_operation WHERE idContrat = '".$idContrat."' ORDER BY status ASC, date ASC";
        // exécution de la requête
        $resultat = $pdo->query($requete) or die(print_r($bdd->errorInfo()));
        // résultats
        echo '<strong>Synthèse client</strong><br />';
        echo '<div class="tab-pane ">
            <div class="controls controls-row">
                <input disabled="disabled" class="span2 m-wrap input-bold-text" type="text" value="DateOpé" />
                <input disabled="disabled" class="span2 m-wrap input-bold-text" type="text" value="DateRég" />
                <input disabled="disabled" class="span3 m-wrap input-bold-text" type="text" value="Montant" />
                <input disabled="disabled" class="span2 m-wrap input-bold-text" type="text" value="Compte" />
                <input disabled="disabled" class="span2 m-wrap input-bold-text" type="text" value="Chèque" />
                <input disabled="disabled" class="span1 m-wrap input-bold-text" type="text" value="V" />
            </div>
        </div>';
        echo '<div class="tab-pane synthese-client">';
        while ( $operation = $resultat->fetch(PDO::FETCH_ASSOC)) {
            $status = "Non Validé";
            $checkbox = '<input class="span1 operationValue" type="radio" name="operationValue" value="'.$operation['id'].'" />';
            $classStatus = "input-error-text";
            if ( $operation['status'] != 0 ) {
                $status = "Validé";
                $classStatus = "input-success-text";
                $checkbox = '<input class="span1" type="hidden" />';
            }
            $res = '<div class="controls controls-row">'.
                        '<input disabled="disabled" class="span2 m-wrap '.$classStatus.'" type="text" value="'.date('d/m/y', strtotime($operation['date'])).'" />'.
                        '<input disabled="disabled" class="span2 m-wrap '.$classStatus.'" type="text" value="'.date('d/m/y' , strtotime($operation['dateReglement'])).'" />'.
                        '<input disabled="disabled" class="span3 m-wrap '.$classStatus.'" type="text" value="'.number_format($operation['montant'], 2, ',', ' ').'" />'.
                        '<input disabled="disabled" class="span2 m-wrap '.$classStatus.'" type="text" value="'.$operation['compteBancaire'].'" />'.
                        '<input disabled="disabled" class="span2 m-wrap '.$classStatus.'" type="text" value="'.$operation['numeroCheque'].'" />'.
                        $checkbox.
                    '</div>';
            echo $res;
        }
        echo '</div>';
    }
?>