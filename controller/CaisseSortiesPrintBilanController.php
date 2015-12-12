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
        $projetManager = new ProjetManager($pdo);
		$caisseSortiesManager = new CaisseSortiesManager($pdo);
		$projets = $projetManager->getProjets();
		$sorties = "";
		$total = 0;
		if(isset($_GET['destination'])){
			$choice = htmlentities($_GET['destination']);
			if($choice=="Bureau"){
				$sorties = $caisseSortiesManager->getCaisseSortiesBureau();
				$total = $caisseSortiesManager->getTotalCaisseSortiesBureau();
			}
			else if($choice=="toutes"){
				$sorties = $caisseSortiesManager->getCaisseSorties();
				$total = $caisseSortiesManager->getTotalCaisseSorties();
			}
			else{
				$sorties = $caisseSortiesManager->getCaisseSortiesProjet($choice);
				$total = $caisseSortiesManager->getTotalCaisseSortiesProjet($_GET['destination']);
			}
		}
		else{
			$sorties = $caisseSortiesManager->getCaisseSorties();
			$total = $caisseSortiesManager->getTotalCaisseSorties();
		}

ob_start();
?>
<style type="text/css">
	p, h1{
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
    <br><br><br><br><br><br><br>
    <h1>Bilan des Sorties de la Caisse</h1>
    <p>Imprimé le <?= date('d-m-Y') ?> | <?= date('h:i') ?> </p>
    <br><br><br><br><br><br><br>
    <table>
		<tr>
			<th style="width: 15%">N°Sortie</th>
			<th style="width: 15%">Montant</th>
			<th style="width: 20%">Date opération</th>
			<th style="width: 20%">Désignation</th>
			<th style="width: 15%">Pour</th>
			<th style="width: 15%">Saisie par</th>
		</tr>
		<?php
		foreach($sorties as $sortie){
		?>		
		<tr>
			<td><a><?= $sortie->id() ?></a></td>
			<td><?= $sortie->montant() ?></td>
			<td><?= $sortie->dateOperation() ?></td>
			<td><?= $sortie->designation() ?></td>
			<?php
			$destination = "Bureau";
			if( $sortie->destination()!="Bureau" ){
				$destination = $projetManager->getProjetById($sortie->destination())->nom(); 
			}
			?>	
			<td><?= $destination ?></td>
			<td><?= $sortie->utilisateur() ?></td>
		</tr>	
		<?php
		}//end of loop
		?>
		<tr>
			<th>Total</th>
			<td><?= $total ?></td>
		</tr>
	</table> 
    <br><br>
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;">STE MERLA TRAV SARL : Au capital de 100 000,00 DH – Siège social Hay Al Matar En face de l'institution AR'RISSALA 2, Nador. 
    	<br>Tèl 0536601818 / 0661668860 IF : 40451179   RC : 10999  Patente 56126681</p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
		$fileName = "BilanCaisseSorties-".date('Ymdhi').'.pdf';
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