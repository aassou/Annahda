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
        $contratManager = new ContratManager($pdo);
        $projetManager = new ProjetManager($pdo);
        $appartementManager = new AppartementManager($pdo);
		$locauxManager = new LocauxManager($pdo);
		$biens = "";
		$idContrat = 0;
        if( isset($_GET['idContrat']) and ($_GET['idContrat']>0 and $_GET['idContrat']<=$contratManager->getLastId()) ){
        	$idContrat = $_GET['idContrat'];
        }
		else{
			header('Location:../dashboard.php');
			exit;
		}
        $contrat = $contratManager->getContratById($idContrat);
        $client = $clientManager->getClientById($contrat->idClient());
        $projet = $projetManager->getProjetById($contrat->idProjet());
		$typeBien = "";
        if( $contrat->typeBien()=="appartement" ){
        	$biens = $appartementManager->getAppartementById($contrat->idBien());
			$typeBien = "Appartement";
        }
		else if( $contrat->typeBien()=="localCommercial" ){
			$biens = $locauxManager->getLocauxById($contrat->idBien());
			$typeBien = "Local commercial";
		}
//property data

$programme  = $projet->nom();
$superficie = $biens->superficie();
$prixHt = number_format($contrat->prixVente(), 2, ',', ' ');
//customer data
$clientNom = $client->nom();
$cin = $client->cin();
$adresse = $client->adresse();
$telephone = $client->telephone1(); 
$email = $client->email();
//contract text
$somme = number_format($contrat->avance(), 2, ',', ' ');
$montantMesuel = number_format($contrat->echeance(), 2, ',', ' ');
$modePaiement = $contrat->modePaiement();
$dureePaiement = $contrat->dureePaiement();

$contratTexte = "La somme de : <strong>".$somme."</strong> Dirhams, <strong>{</strong>à verser au plus tard 10 jours après la date de 
signature<strong>}</strong> , représentant un premier versement de réservation de l’appartement <strong>".$biens->nom()."</strong> dépendant 
du programme ci-dessus. 
Le client déclare accepte la désignation de l'appartement objet du présent reçu et les échéances 
de paiement fixé comme suit :";

$contratTexte2 = "<strong>Le reste à ventiler sur ".$dureePaiement." mois soit une constante mensuelle de ".$montantMesuel." DH</strong>";

$remarque = "Dans le cas où le client a marqué trois retards de paiements des mensualités fixés 
ci-dessus, la société a le droit d’annuler la réservation de l’appartement objet de cet avis de 
réservation sans accord du client, et en cas de désistement de l'acquéreur, 
le montant de l'avance ne sera remboursé qu'après vente de l'unité objet de désistement.";

ob_start();
?>
<style type="text/css">
	table{
	    width:100%;
	    border: solid 1px black;
	}
</style>
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
    <br><br><br><br>
    <table>
        <tr>
            <td style="width:30%"><strong>Programme </strong></td>
            <td style="width:70%"> : <?= $programme ?></td>
        </tr>
        <tr>
            <td><strong>Type du bien </strong></td>
            <td> : <?= $typeBien ?></td>
        </tr>
        <tr>
            <td><strong>Nom du bien </strong></td>
            <td> : <?= $biens->nom() ?></td>
        </tr>
        <tr>
			<?php if($contrat->typeBien()=="appartement"){ ?>        	
            <td><strong>Niveau du bien </strong></td>
            <td> : <?= $biens->niveau() ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td><strong>Superficie Approximative</strong></td>
            <td> : <?= $superficie ?> m² <sub>(communiqué par l'architecte selon le plan de construction)</sub></td>
        </tr>
        <tr>
            <td><strong>Prix H.T </strong></td>
            <td> : <?= $prixHt ?>&nbsp;DH</td>
        </tr>
    </table>
    <h2 style="font-size:20px; text-align: center; text-decoration: underline">Avis de réservation</h2>
    <br>
    <table border="0">
        <tr>
            <td style="width:20%"><strong>Client</strong></td>
            <td style="width:80%"> : <strong><em><?= $clientNom ?></em></strong></td>
        </tr>
        <tr>
            <td><strong>CIN</strong></td>
            <td> : <strong><em><?= $cin ?></em></strong></td>
        </tr>
        <tr>
            <td><strong>Adresse</strong></td>
            <td> : <strong><em><?= $adresse ?></em></strong></td>
        </tr>
        <tr>
            <td><strong>Téléphone</strong></td>
            <td> : <strong><em><?= $telephone ?></em></strong></td>
        </tr>
        <tr>
            <td><strong>Email</strong></td>
            <td> : <strong><em><?= $email ?></em></strong></td>
        </tr>
    </table>
    <br><br><br>
    <p style="font-size: 10.48pt; text-align: justify";><?= $contratTexte ?></p>
    <br><br>
    <table>
        <tr>
            <td style="width:100%; text-align: center"><?= $contratTexte2 ?></td>
        </tr>
    </table>
    <br><br>
    <p style="font-size: 10.48pt; text-align: justify"><?= $remarque ?></p>
    <br><br>
    <table>
        <tr>
            <td style="width:30%; text-align: center">Mode de paiement</td>
        </tr>
        <tr>
            <td style="width:40%; text-align: center"><strong><?= $modePaiement; ?></strong></td>
            <td style="width:60%; text-align: center"><strong>Nador, le <?= date('d/m/Y', strtotime($contrat->dateCreation())); ?></strong></td>
        </tr>
    </table>
    <br><br>
    <table border="0">
        <tr>
            <td style="width:70%;"><strong>EMARGEMENT CLIENT</strong></td>
            <td style="width:30%;"><strong>EMARGEMENT SOCIETE</strong></td>
        </tr>
    </table>
    <page_footer>
    <p><strong>N.B</strong> : Ce reçu est délivré sous réserve de l'encaissement du chèque. En cas de rejet pour quelque motif que ce soit, le présent reçu deviendra nul et non avenu.
    Dans la cas de litige, ou la société n’est pas parvenus à la réalisation du projet  le client a le droit de récupérer ses fonds  sans demander une indemnisation ou des intérêts et sans recours au tribunal.
    </p>
    <hr/>
    <p style="text-align: center"></p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
		$fileName = "contrat-".$clientNom."-".$biens->nom().'-'.date('Y-m-d-h-i').'.pdf';
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