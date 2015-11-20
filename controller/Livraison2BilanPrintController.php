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
				$titreLivraison ="Bilan des livraisons et réglements de tous les fournisseurs";
				//$totalLivraison = $livraisonManager->getTotalLivraisons();
				$livraisons = $livraisonManager->getLivraisonsByGroup();
                $totalReglement = $reglementsFournisseurManager->getTotalReglement();
                $totalLivraison = $livraisonDetailManager->getTotalLivraison(); 	
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
    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
    <h3><?= $titreLivraison ?></h3>
    <p>Imprimé le <?= date('d/m/Y - h:i') ?> </p>
    <br>
    <table>
		<tr>
			<th style="width: 25%">Fournisseur</th>
			<th style="width: 25%">Total livraisons</th>
			<th style="width: 25%">Total Réglements</th>
			<th style="width: 25%">Solde</th>
		</tr>
		<?php
        foreach($livraisons as $livraison){
            $livraisonsIds = $livraisonManager->getLivraisonIdsByIdFournisseur($livraison->idFournisseur());
            $totalDetailsLivraisons = 0;
            foreach($livraisonsIds as $idl){
                $totalDetailsLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($idl);
            }
		?>		
		<tr>
			<td><?= $fournisseurManager->getFournisseurById($livraison->idFournisseur())->nom() ?></td>
			<td><?= number_format($totalDetailsLivraisons, 2, ',', ' '); ?></td>
            <td><?= number_format($reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseur($livraison->idFournisseur()), 2, ',', ' '); ?></td>
            <td><?= number_format( $totalDetailsLivraisons-$reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseur($livraison->idFournisseur()), 2, ',', ' '); ?></td>
		</tr>	
		<?php
		}//end of loop
		?>
		<tr>
            <td style="width: 25%"></td>
            <th style="width: 25%"><strong>Totaux Livraisons</strong></th>
            <th style="width: 25%"><strong>Totaux Réglements</strong></th>
            <th style="width: 25%"><strong>Total Soldes</strong></th>
        </tr>
        <tr>
            <td style="width: 25%"></td>
            <td style="width: 25%"><strong><?= number_format($totalLivraison, 2, ',', ' ') ?>&nbsp;DH</strong></td>
            <td style="width: 25%"><strong><?= number_format($totalReglement, 2, ',', ' ') ?>&nbsp;DH</strong></td>
            <td style="width: 25%"><strong><?= number_format($totalLivraison-$totalReglement, 2, ',', ' ') ?>&nbsp;DH</strong></td>
        </tr>
	</table>
    <br><br>
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;"></p>
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