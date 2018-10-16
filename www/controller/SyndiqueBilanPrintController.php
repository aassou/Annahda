<?php
    //classes loading begin
    function classLoad ($myClass) {
        if(file_exists('../model/'.$myClass.'.php')){
            include('../model/'.$myClass.'.php');
        }
        elseif(file_exists('../controller/'.$myClass.'.php')){
            include('../controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('../config/config.php');
    //classes loading end
    session_start();
    if( isset($_SESSION['userMerlaTrav']) ){
        //classes managers  
        $projetManager     = new ProjetManager($pdo);
        $clientManager     = new ClientManager($pdo);
        $syndiqueManager   = new SyndiqueManager($pdo);
        $chargeManager     = new ChargeSyndiqueManager($pdo);
        $typeChargeManager = new TypeChargeSyndiqueManager($pdo);
        //obj and vars
        $idProjet                     = $_GET['idProjet'];
        $projet                       = $projetManager->getProjetById($idProjet);
        $projets                      = $projetManager->getProjets();    
        //syndique
        $syndiques                    = $syndiqueManager->getSyndiquesByIdProjet($idProjet);
        $totalSyndiquePaiementsClient = $syndiqueManager->getSyndiquesTotalByIdProjet($idProjet);
        //chargeSyndique
        $typeCharges          = $typeChargeManager->getTypeChargeSyndiques();
        $charges              = $chargeManager->getChargeSyndiquesByIdProjet($idProjet);
        $totalChargesSyndique = $chargeManager->getTotalByIdProjet($idProjet);
        //solde
        $solde = $totalSyndiquePaiementsClient - $totalChargesSyndique;

ob_start();
?>
<style type="text/css">
    p, h1{
        text-align: center;
        text-decoration: underline;
        font-size: 16px;
    }
    h2{
        text-align: center;
        text-decoration: underline;
        font-size: 12px;
    }
    table {
        border-collapse: collapse;
        width:100%;
    }
    
    table, th, td {
        border: 1px solid black;
    }
    td, th{
        padding : 5px;
    }
    
    th{
        background-color: grey;
    }
</style>
<page backtop="5mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
    <h1>Bilan Syndique Projet <?= $projet->nom() ?></h1>
    <h2>Imprimé le <?= date('d-m-Y') ?> | <?= date('h:i') ?> </h2>
    <br>
    <table>
        <tr>
            <th style="width: 80%">Solde (Paiements Clients - Charges)</th>
            <td style="width: 20%; text-align: center"><strong><?= number_format($solde, 2, ',', ' ') ?>&nbsp;DH</strong></td>
        </tr>
    </table>
    <br>
    <h2>Paiements Clients</h2>
    <table>
        <tr>
            <th style="width: 40%">Client</th>
            <th style="width: 20%">Date Paiement</th>
            <th style="width: 20%">Status</th>
            <th style="width: 20%">Montant</th>
        </tr>
        <?php
        foreach($syndiques as $syndique){
            $nomClient = $clientManager->getClientById($syndique->idClient())->nom();
        ?>      
        <tr>
            <td style="width: 40%"><?= $nomClient ?></td>
            <td style="width: 20%"><?= date('d/m/Y', strtotime($syndique->date())) ?></td>
            <td style="width: 20%"><?= $syndique->status() ?></td>
            <td style="width: 20%;text-align: right"><?= number_format($syndique->montant(), 2, ',', ' ') ?></td>
        </tr>   
        <?php
        }//end of loop
        ?>
    </table>
    <table>
        <tr>
            <th style="width: 80%">Total Paiements Clients</th>
            <td style="width: 20%;text-align: right"><?= number_format($totalSyndiquePaiementsClient, 2, ',' , ' ') ?></td>
        </tr>
    </table>
    <br>
    <h2>Charges Syndique</h2>
    <table>
        <tr>
            <th style="width: 20%">Type</th>
            <th style="width: 20%">Date Opération</th>
            <th style="width: 40%">Désignation</th>
            <th style="width: 20%">Montant</th>
        </tr>
        <?php
        foreach($charges as $charge){
        ?>      
        <tr>
            <td style="width: 20%"><?= $typeChargeManager->getTypeChargeSyndiqueById($charge->type())->nom() ?></td>
            <td style="width: 20%"><?= date('d/m/Y', strtotime($charge->dateOperation())) ?></td>
            <td style="width: 40%"><?= $charge->designation() ?></td>
            <td style="width: 20%;text-align: right"><?= number_format($charge->montant(), 2, ',', ' ') ?></td>
        </tr>   
        <?php
        }//end of loop
        ?>
    </table>
    <table>
        <tr>
            <th style="width: 80%">Total Charges Syndique</th>
            <td style="width: 20%;text-align: right"><?= number_format($totalChargesSyndique, 2, ',' , ' ') ?></td>
        </tr>
    </table>
    <br><br>
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;">STE GROUPE ANNAHDA LIL IAAMAR SARL – Quartier Ouled Brahim N°B-1 en face Lycée Nador Jadid (Anaanaa), Nador. 
        <br>Tél : 05 36 33 10 31 - Fax : 05 36 33 10 32 </p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
        $fileName = "BilanSyndique-".date('Ymdhi').'.pdf';
        $pdf->Output($fileName);
    }
    catch(HTML2PDF_exception $e){
        die($e->getMessage());
    }
}
else{
    header("Location:index.php");
}
?>