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
		//classes and vars
		$livraisonDetailNumber = 0;
		$totalReglement = 0;
		$totalLivraison = 0;
		$titreLivraison ="Détails de la livraison";
		$livraison = "Vide";
		$fournisseur = "Vide";
		$projet = "Vide";
		if( isset($_GET['idLivraison']) ){
			$livraison = $livraisonManager->getLivraisonById($_GET['idLivraison']);
			$fournisseur = $fournisseurManager->getFournisseurById($livraison->idFournisseur());
			$projet = $projetManager->getProjetById($livraison->idProjet());
			$livraisonDetail = $livraisonDetailManager->getLivraisonsDetailByIdLivraison($livraison->id());
			$totalLivraisonDetail = 
			$livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id());
			$nombreArticle = 
			$livraisonDetailManager->getNombreArticleLivraisonByIdLivraison($livraison->id());
		}
ob_start();
?>
<style type="text/css">
	p, h1, h2, h3, h4{
		text-align: center;
		text-decoration: underline;
	}
	.detailLivraison{
		text-decoration: none;
		text-align: center;
		font-size: 16px;
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
    <br>
    <h4>Informations de Livraison</h4>
	<table class="detailLivraison">
		<tr>
			<th style="width: 10%">Projet </th>
			<td style="width: 15%"><?= $projet->nom() ?></td>
			<th style="width: 10%">Fournisseur</th>
			<td style="width: 15%"><?= $fournisseur->nom() ?></td>
			<th style="width: 10%">Libelle</th>
			<td style="width: 15%"><?= $livraison->libelle() ?></td>
			<th style="width: 10%">Date</th> 
			<td style="width: 15%"><?= date('d/m/Y', strtotime($livraison->dateLivraison())) ?></td>
		</tr>
	</table>
	<br>
	<h4>Détails des articles de la livraison</h4>
    <table>
		<tr>
			<th style="width: 20%">Désignation</th>
			<th style="width: 20%">Quantité</th>
			<th style="width: 20%">Prix.Uni</th>
			<th style="width: 20%">Total</th>
		</tr>
		<?php
		foreach($livraisonDetail as $livraison){
		?>		
		<tr>
			<td><?= $livraison->libelle() ?></td>
			<td><?= $livraison->designation() ?></td>
			<td><?= $livraison->quantite() ?></td>
			<td><?= number_format($livraison->prixUnitaire(), 2, ',', ' ') ?></td>
			<td><?= number_format($livraison->prixUnitaire()*$livraison->quantite(), 2, ',', ' ') ?></td>
		</tr>	
		<?php
		}//end of loop
		?>
	</table>
	<br />
	<table>
		<tr>
			<th style="width: 60%"><strong>Nombre d'article de la livraison</strong></th>
			<td style="width: 40%">
				<strong>
					<a>
						<?= $nombreArticle ?> 
					</a>
				</strong>
			</td>
		</tr>
		<tr>
			<th style="width: 60%"><strong>Total de la livraison</strong></th>
			<td style="width: 40%">
				<strong>
					<a>
						<?= number_format($totalLivraisonDetail, 2, ',', ' ') ?> 
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
		$fileName = "DetailsLivraison-".date('Ymdhi').'.pdf';
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