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
        $projetManager = new ProjetManager($pdo);
		$fournisseurManager = new FournisseurManager($pdo);
		$livraisonManager = new LivraisonManager($pdo);
		$livraisonDetailManager = new LivraisonDetailManager($pdo);
		$reglementsFournisseurManager = new ReglementFournisseurManager($pdo);
		if( isset($_GET['idFournisseur']) and isset($_GET['idProjet']) and 
		$fournisseurManager->getOneFournisseurBySearch($_GET['idFournisseur']>=1)){
			$fournisseur = $fournisseurManager->getOneFournisseurBySearch(htmlentities($_GET['idFournisseur']));
			$idProjet = $_GET['idProjet'];
			$livraisonNumber = $livraisonManager->getLivraisonsNumberByIdFournisseurByProjet($fournisseur, $idProjet);
			if($livraisonNumber != 0){
				$livraisons = $livraisonManager->getLivraisonsByIdFournisseurByProjet($fournisseur, $idProjet);
				$titreLivraison = "Bilan des livraisons du fournisseur <strong>"
				.$fournisseurManager->getFournisseurById($fournisseur)->nom()."</strong> / Projet: <strong>"
				.$projetManager->getProjetById($idProjet)->nom()."</strong>";	
				//get the sum of livraisons details using livraisons ids (idProjet and idFournisseur)
				$livraisonsIds = $livraisonManager->getLivraisonIdsByIdFournisseurIdProjet($fournisseur, $idProjet);
				$sommeDetailsLivraisons = 0;
				foreach($livraisonsIds as $idl){
					$sommeDetailsLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($idl);
				}
				$totalLivraison = 
				$livraisonManager->getTotalLivraisonsIdFournisseurProjet($fournisseur, $idProjet) +
				$sommeDetailsLivraisons;
				$totalReglement = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseurByProjet($fournisseur, $idProjet);
			}
		}
		else if( isset($_GET['idFournisseur']) and
		$fournisseurManager->getOneFournisseurBySearch($_GET['idFournisseur']>=1)){
			$fournisseur = $fournisseurManager->getOneFournisseurBySearch(htmlentities($_GET['idFournisseur']));
			$livraisonNumber = $livraisonManager->getLivraisonsNumberByIdFournisseur($fournisseur);
			if($livraisonNumber != 0){
				$livraisons = $livraisonManager->getLivraisonsByIdFournisseur($fournisseur);
				$titreLivraison ="Bilan des livraisons du fournisseur <strong>".$fournisseurManager->getFournisseurById($fournisseur)->nom()."</strong>";
				//get the sum of livraisons details using livraisons ids (idFournisseur)
				$livraisonsIds = $livraisonManager->getLivraisonIdsByIdFournisseur($fournisseur);
				$sommeDetailsLivraisons = 0;
				foreach($livraisonsIds as $idl){
					$sommeDetailsLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($idl);
				}	
				$totalReglement = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseur($fournisseur);
				$totalLivraison = 
				$livraisonManager->getTotalLivraisonsIdFournisseur($fournisseur)+
				$sommeDetailsLivraisons;
				$totalReglement = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseur($fournisseur);
			}
		}
		else {
			$livraisonNumber = $livraisonManager->getLivraisonNumber();
			if($livraisonNumber != 0){
				$livraisons = $livraisonManager->getLivraisons();
				$titreLivraison ="Bilan de toutes les livraisons";
				//$totalLivraison = $livraisonManager->getTotalLivraisons();
				$totalLivraison = 
				$livraisonManager->getTotalLivraisons() + $livraisonDetailManager->getTotalLivraison();
				$totalReglement = $reglementsFournisseurManager->getTotalReglement();	
			}	
		}		

ob_start();
?>
<style type="text/css">
	p, h1, h2, h3{
		text-align: center;
		text-decoration: underline;
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
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <img src="../assets/img/logo_company.png" style="width: 110px" />
    <h3><?= $titreLivraison ?></h3>
    <p>Imprimé le <?= date('d/m/Y') ?> | <?= date('h:i') ?> </p>
    <table>
		<tr>
			<th style="width: 20%">Fournisseur</th>
			<th style="width: 20%">Projet</th>
			<th style="width: 20%">Date Livraison</th>
			<th style="width: 20%">Nombre d'articles</th>
			<th style="width: 20%">Total</th>
		</tr>
		<?php
		foreach($livraisons as $livraison){
		?>		
		<tr>
			<td><?= $fournisseurManager->getFournisseurById($livraison->idFournisseur())->nom() ?></td>
			<td><?= $projetManager->getProjetById($livraison->idProjet())->nom() ?></td>
			<td><?= date('d/m/Y', strtotime($livraison->dateLivraison())) ?></td>
			<td>
				<?php 
				if($livraisonDetailManager->getNombreArticleLivraisonByIdLivraison($livraison->id())==0){
					echo 1;
				} 
				else {
					echo $livraisonDetailManager->getNombreArticleLivraisonByIdLivraison($livraison->id());
				}
				?>
			</td>
			<td>
				<?php
				if($livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id())==0){
					echo number_format($livraison->quantite()*$livraison->prixUnitaire(), 2, ',', ' ');
				} 
				else{
					echo number_format($livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id()), 2, ',', ' ');	
				} 
				?>
			</td>
		</tr>	
		<?php
		}//end of loop
		?>
	</table>
	<br />
	<table>
		<tr>
			<th style="width: 60%"><strong>Total Livraisons</strong></th>
			<td style="width: 40%">
				<strong>
					<a>
						<?= number_format($totalLivraison, 2, ',', ' ') ?> 
					</a>
					&nbsp;DH
				</strong>
			</td>
		</tr>
		<tr>
			<th style="width: 60%"><strong>Total Réglements</strong></th>
			<td style="width: 40%">
				<strong>
					<a>
						<?= number_format($totalReglement, 2, ',', ' ') ?> 
					</a>
					&nbsp;DH
				</strong>
			</td>
		</tr>
		<tr>
			<th style="width: 60%"><strong>Solde</strong></th>
			<td style="width: 40%">
				<strong>
					<a>
						<?= number_format($totalLivraison-$totalReglement, 2, ',', ' ') ?> 
					</a>
					&nbsp;DH
				</strong>
			</td>
		</tr>
	</table> 
    <br><br>
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;">STE MERLA TRAV SARL : Au capital de 100 000,00 DH – Siège social Hay Al Matar En face de l'institution AR'RISSALA 2, Nador. 
    	<br>Tèl 0536381458/ 0661668860 IF : 40451179   RC : 10999  Patente 56126681</p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
		$fileName = "BilanLivraison-".date('Ymdhi').'.pdf';
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