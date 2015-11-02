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
    include('../config.php');  
    //classes loading end
    session_start();
    if( isset($_SESSION['userMerlaTrav']) and $_SESSION['userMerlaTrav']->profil()=="admin" ){
        $clientManager = new ClientManager($pdo);
        $appartementManager = new AppartementManager($pdo);
		$contratManager = new ContratManager($pdo);
		$projetManager = new ProjetManager($pdo);
		$idAppartement = 0;
		if(isset($_GET['idAppartement']) and $_GET['idAppartement']>0 and $_GET['idAppartement']<=$appartementManager->getLastId()){
			$idAppartement = $_GET['idAppartement'];
			$appartement = $appartementManager->getAppartementById($idAppartement);
	        $contrat = $contratManager->getContratByIdBien($appartement->id());
	        $client = $clientManager->getClientById($contrat->idClient());
	        $projet = $projetManager->getProjetById($contrat->idProjet());
			$piecesAppartementManager = new PiecesAppartementManager($pdo);
			$pieces = $piecesAppartementManager->getPiecesAppartementByIdAppartement($idAppartement);
			$piecesNumber = $piecesAppartementManager->getPiecesAppartementNumberByIdAppartement($idAppartement);
			$image = "";
			if($piecesNumber>0){
				$image = $pieces[0]->url();	
			}
		}
//property data

ob_start();
?>
<style type="text/css">
	table{
	    width:100%;
	    border: solid 1px black;
	}
</style>
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <img src="../assets/img/logo_company.png" style="width: 110px" />
    <br><br><br><br>
    <h2 style="font-size:20px; text-align: center; text-decoration: underline">Fiche descriptif</h2>
    <br><br>
    <table>
        <tr>
            <td style="width:30%"><strong>Programme </strong></td>
            <td style="width:70%"> : <?= $projet->nom() ?></td>
        </tr>
        <tr>
            <td><strong>Type du bien </strong></td>
            <td> : Appartement</td>
        </tr>
        <tr>
            <td><strong>Code du bien </strong></td>
            <td> : <?= $appartement->nom() ?></td>
        </tr>
        <tr>        	
            <td><strong>Niveau du bien </strong></td>
            <td> : <?= $appartement->niveau() ?></td>
        </tr>
        <tr>
            <td><strong>Superficie Approximative</strong></td>
            <td> : <?= $appartement->superficie() ?> m²</td>
        </tr>
        <tr>
            <td><strong>Nombre de prièces</strong></td>
            <td> : <?= $appartement->nombrePiece() ?></td>
        </tr>
        <tr>
            <td><strong>Façade</strong></td>
            <td> : <?= $appartement->facade() ?></td>
        </tr>
        <tr>
            <td><strong>Cave</strong></td>
	        <?php
			if($appartement->cave()=="Avec"){
				echo "<td> : Avec cave</td>";
			} 
			else{
				echo "<td> : Sans cave</td>";
			}
			?>
        </tr>
        <tr>
            <td><strong>Prix H.T </strong></td>
            <td> : <?= $contrat->prixVente() ?>&nbsp;DH</td>
        </tr>
    </table>
    <br>
    <?php
    if($piecesNumber>0){
    ?>
    <img src="<?= "http://www.merlatrav.esy.es/".$image ?>" style="width:100%">
    <?php
    }
    ?>
    <page_footer>
    <hr/>
    <p style="text-align: center">STE MERLA TRAV SARL : Au capital de 100 000,00 DH – Siège social Hay Al Matar En face de l'institution AR'RISSALA 2, Nador. 
    	<br>Tèl 0536381458 / 0661668860 IF : 40451179   RC : 10999  Patente 56126681</p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
		$pdf->setTestIsImage(false);
        $pdf->writeHTML($content);
		$fileName = "FicheDescriptifAppartement-".$appartement->nom()."-".date('Y-m-d-h-i').'.pdf';
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