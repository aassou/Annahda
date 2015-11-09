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
        //classes managers	
        $idProjet = 0;
    	$projetManager = new ProjetManager($pdo);
		$clientManager = new ClientManager($pdo);
		$contratManager = new ContratManager($pdo);
		$operationManager = new OperationManager($pdo);
		if(isset($_GET['codeContrat']) and (bool)$contratManager->getCodeContrat($_GET['codeContrat']) ){
			$codeContrat = $_GET['codeContrat'];
			$contrat = $contratManager->getContratByCode($codeContrat);
			$projet = $projetManager->getProjetById($contrat->idProjet());
			$client = $clientManager->getClientById($contrat->idClient());
			$sommeOperations = $operationManager->sommeOperations($contrat->id());
			$biens = "";
			$niveau = "";
			if($contrat->typeBien()=="appartement"){
				$appartementManager = new AppartementManager($pdo);
				$biens = $appartementManager->getAppartementById($contrat->idBien());
				$niveau = $biens->niveau();
			}
			else if($contrat->typeBien()=="localCommercial"){
				$locauxManager = new LocauxManager($pdo);
				$biens = $locauxManager->getLocauxById($contrat->idBien());
			}
			$operations = "";
			//test the locaux object number: if exists get operations else do nothing
			$operationsNumber = $operationManager->getOpertaionsNumberByIdContrat($contrat->id());
			if($operationsNumber != 0){
				$operations = $operationManager->getOperationsByIdContrat($contrat->id());	
			}
		}
		
ob_start();
?>
<style type="text/css">
	p, h1, h2, h4{
        text-align: center;
        font-family : Arial;
        font-weight: 100;
        margin-bottom: 0px;
    }
    h2{
        font-size: 20px;
    }
	table {
	    border-collapse: collapse;
	    width:auto;
	    border: 1px solid black;
	}
	td, th{
		padding : 5px;
	}
	
	th{
		background-color: grey;
	}
	table, a{
		text-decoration: none;
	}
</style>
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
    <h1>Résumé du Contrat Client</h1>
    <h2>Projet <?= $projet->nom() ?> </h2>
    <p>Imprimé le <?= date('d-m-Y') ?> | <?= date('h:i') ?> </p>
    <br><br>
    <h3>Résumé du Contrat</h3>
    <hr>
    <div>
		<table style="width: 100%">
			<tr>
				<td><h4>Informations du client</h4></td>
				<td></td>
				<td><h4>Informations du contrat</h4></td>
				<td></td>
			</tr>
			<tr>
				<td style="width: 15%"><strong>Client</strong></td>
				<td style="width: 25%"><a><strong><?= $client->nom() ?></strong></a></td>
				<td style="width: 15%"><strong>Type</strong></td> 
				<td style="width: 25%"><a><strong>
				<?php 
					if($contrat->typeBien()=="localCommercial"){
						echo "Local commercial"; 
					} 
					else{
						echo "Appartement";
					} 
				?>
				</strong></a></td>
			</tr>
			<tr>
				<td><strong>CIN</strong></td>
				<td><a><strong><?= $client->cin() ?></strong></a></td>
				<td><strong>Nom du Bien</strong></td>
				<td><a><strong><?= $biens->nom() ?></strong></a></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td><strong>Superficie</strong></td>
				<td><a><strong><?= $biens->superficie() ?>&nbsp;m<sup>2</sup></strong></a></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td><strong>Niveau</strong></td>
				<td><a><strong><?= $niveau ?></strong></a></td>
			</tr>
			<tr>
				<td><strong>Téléphone 1</strong></td>
				<td><a><strong><?= $client->telephone1() ?></strong></a></td>
				<td><strong>Prix de Vente</strong></td>
				<td><a><strong><?= number_format($contrat->prixVente(), 2, ',', ' ') ?>&nbsp;DH</strong></a></td>
			</tr>
			<tr>
				<td><strong>Téléphone 2</strong></td>
				<td><a><strong><?= $client->telephone2() ?></strong></a></td>
				<?php
				if($contrat->avance()!=0 or $contrat->avance()!='NULL' ){
				?>
				<td><strong>Avance</strong></td>
				<td><a><strong><?= number_format($contrat->avance(), 2, ',', ' ') ?>&nbsp;DH</strong></a></td>
				<?php
				}
				?>
			</tr>
			<tr>
				<td><strong>Adresse</strong></td>
				<td><a><strong><?= $client->adresse() ?></strong></a></td>
				<td><strong>Réglements</strong></td>
				<td><a><strong><?= number_format($sommeOperations, 2, ',', ' ') ?></strong></a></td>
			</tr>
			<tr>
				<td><strong>Email</strong></td>
				<td><a><strong><?= $client->email() ?></strong></a></td>
				<td><strong>Echeance</strong></td>
				<td><a><strong><?= number_format($contrat->echeance(), 2, ',', ' ') ?></strong></a></td>
			</tr>
		</table>
	</div>
	<h3>Détails des réglements</h3>
    <div>
		<table style="width:100%;">
			<tr>
				<th style="width: 30%; border: 1px solid black">Date opération</th>
				<th style="width: 40%; border: 1px solid black">Montant</th>
				<th style="width: 30%; border: 1px solid black">Mode Paiement</th>
			</tr>
			<?php
			if($operationsNumber != 0){
			foreach($operations as $operation){
			?>		
			<tr>
				<td style="border: 1px solid black"><a><?= date('d/m/Y', strtotime($operation->date())) ?></a></td>
				<td style="border: 1px solid black"><?= number_format($operation->montant(), 2, ',', ' ') ?>&nbsp;DH</td>
				<td style="border: 1px solid black"><?= $operation->modePaiement() ?></td>
			</tr>	
			<?php
			}//end of loop
			}//end of if
			?>
			<!--tr>
				<td style="border: 1px solid black"><a><?= date('d/m/Y', strtotime($contrat->dateCreation())) ?></a></td>											
				<?php
				if($contrat->avance()!=0 or $contrat->avance()!='NULL' ){
				?> 
					<td style="border: 1px solid black"><?= number_format($contrat->avance(), 2, ',', ' ')." DH";?></td>
				<?php
				}
				?>
				<td style="border: 1px solid black"><?= $contrat->modePaiement() ?></td>
			</tr-->
			<tr>
				<td style="border: 1px solid black"><strong>Somme Réglements</strong></td>
				<td style="border: 1px solid black">
					<strong>
						<?= number_format($operationManager->sommeOperations($contrat->id()), 2, ',', ' ')." DH";?>
					</strong>		
				</td>
				<td></td>
			</tr>
			<tr>
				<td style="border: 1px solid black"><strong>Reste</strong></td>
				<td style="border: 1px solid black">
					<strong>
						<?= number_format($contrat->prixVente()-$operationManager->sommeOperations($contrat->id()), 2, ',', ' ')." DH";?>
					</strong>		
				</td>
				<td></td>
			</tr>
		</table>
	</div>
    <br><br> 
    <br><br>
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;">STE Annahda SARL : Au capital de 200 000,00 DH – siège social XXXXXXXXXX, Nador. 
        <br>Tél XXXXX / XXXXX IF : XXXXX   RC : XXXXX  Patente XXXXX</p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
		$fileName = "FicheSituationClient-".date('Ymdhi').'.pdf';
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