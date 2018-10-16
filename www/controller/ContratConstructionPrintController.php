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
        //class managers
        $companyManager = new CompanyManager($pdo);
        $projetManager  = new ProjetManager($pdo);
        //obj and vars
        $idProjet        = htmlentities($_POST['idProjet']);
        $idCompany1      = htmlentities($_POST['company1']);
        $idCompany2      = htmlentities($_POST['company2']);
        $projet          = $projetManager->getProjetById($idProjet);
        $company1        = $companyManager->getCompanyById($idCompany1);
        $company2        = $companyManager->getCompanyById($idCompany2);
        
ob_start();
?>
<style type="text/css">
    .bottom{
        width:100%;
        font-size: 14px;        
        padding: 5px;
        font-weight: bold;
        margin-top: 100px;
    }
    .title{
        width:100%;
        border: solid 5px black;
        padding: 5px;
    }
    .article{
        font-size:11pt;
        text-align: justify;
    }
    .article-title{
        text-decoration: underline;
    }
    .specification{
        font-size:10.48pt;
    }
    .specification-title{
        text-decoration: underline;
    }
    p{
        line-height: 20px;
    } 
</style>
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
    <h1 style="font-size:28px; text-align: center;">Royaume du Maroc</h1>
    <h2 style="font-size:22px; text-align: center;">Province de Nador</h2>
    <h3 style="font-size:18px; text-align: center;">Municipalité de Nador</h3>
    <br>
    <table class="title" style="margin-top:200px">
        <tr>
            <td style="font-size:30px; text-align: center; width:100%; padding: 20px;">
                <span style="text-decoration: underline"><strong>CONTRAT</strong><br><br>
                Objet : Contrat de Construction d'un Immeuble</span><br><br>
                <strong><?= $projet->description() ?></strong><br><br>
                LOT N° <strong><?= $projet->numeroLot() ?></strong>
            </td>
        </tr>    
    </table>
    <p style="text-decoration: underline; margin-top:400px; font-size: 16px;">Entre les sousignés:</p>
    <p style="font-size: 14px;text-align: justify">
    La Société <?= $company1->nom() ?> dont le siège se trouve à <?= $company1->adresse() ?> représentée aux fins 
    des présentes par Mr. <?= $company1->directeur() ?> CIN  N° <?= $company1->cinDirecteur() ?> agissant en tant que GERANT, inscrite au registre du commerce de Nador Sous le N° <?= $company1->rc() ?> .et ayant <?= $company1->patente() ?> Comme numéro de patente. Désigné ci- après par : «Entrepreneur».    
    </p>
    <p style="text-align: right; text-decoration:underline; font-size: 14px;">D'une part</p>
    <p style="text-align: left; text-decoration:underline; font-size: 14px;">ET</p>
    <p style="font-size: 14px;text-align: justify">
    La Société <?= $company2->nom() ?> dont le siège se trouve à <?= $company2->adresse() ?> représentée aux fins 
    des présentes par Mr. <?= $company2->directeur() ?> CIN  N° <?= $company2->cinDirecteur() ?> agissant en tant que GERANT, inscrite au registre du commerce de Nador Sous le N° <?= $company2->rc() ?> .et ayant <?= $company2->patente() ?> Comme numéro de patente. Désigné ci- après par : «Entrepreneur».    
    </p>
    <p style="text-align: right; text-decoration:underline; font-size: 14px;">D'autre part</p>
    <p style="font-size: 14px;text-align: justify">
        Vu que le Maître d’ouvrage est une société dont l’objet principal est la promotion immobilière.
    </p>
    <p style="font-size: 14px;text-align: justify"> 
        Vu la disponibilité, le savoir-faire et la connaissance de l’entrepreneur à la fois dans le secteur du 
        bâtiment, gros-œuvre et structures en béton armé et pour ce qui est des travaux concernant la construction
        d’immeubles et la transformation de bâtiments, terrassement, génie-civil, maçonnerie et la réalisation 
        de gros œuvres,
    </p> 
    <p style="text-align: left; text-decoration:underline; font-size: 18px;">
    Les deux parties ont arrêté et convenu ce qui suit :
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 1</span> : Le Maître d’ouvrage charge 
    l’entrepreneur qui accepte la réalisation de la main d’œuvre des travaux en lot gros œuvres d’un immeuble
    <?= $projet->description() ?>, sis LOT N° « <?= $projet->numeroLot() ?> » <?= $projet->adresse() ?>.
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 2</span> : Vu l’autorisation N° 
    <?= $projet->numeroAutorisation() ?>. Datant du <?= date('d/m/Y', strtotime($projet->dateAutorisation())) ?>. Et délivrée par le président du conseil municipal de Nador, le projet sera conçue sur 
    une surface totale approximative de <?= $projet->superficie() ?> m<sup>2</sup>, à savoir :
    <br>
    <ul>
        <li>Sous-sol de : <?= $projet->sousSol() ?>&nbsp;m<sup>2</sup></li>
        <li>Rez de Chausser de : <?= $projet->rezDeChausser() ?>&nbsp;m<sup>2</sup></li>
        <li>Mezzanin de : <?= $projet->mezzanin() ?>&nbsp;m<sup>2</sup></li>
        <li>1<sup>er</sup> à <?= $projet->nombreEtages() ?><sup>ème</sup> étage de : (<?= $projet->superficieEtages() ?>&nbsp;m<sup>2</sup> x <?= $projet->nombreEtages() ?>) = <?= $projet->superficieEtages() * $projet->nombreEtages() ?>&nbsp;m<sup>2</sup></li>
        <li>Cage d'escaliers de : <?= $projet->cageEscalier() ?>&nbsp;m<sup>2</sup></li>
        <li>Terrasse de : <?= $projet->terrase() ?>&nbsp;m<sup>2</sup></li>
    </ul>
    </p>
    <br><br><br><br>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 3</span> : Le présent marché ne sera 
    valable, définitif et exécutoire qu'après visas des deux parties contractantes. En conséquence, 
    le délai d’exécution des travaux est fixé à <?= $projet->delai() ?> mois du calendrier grégorien, à compter de la date 
    de signature du présent qui représente le jour de la notification de l'ordre de service qui prescrit 
    de les commencer.
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 4</span> : Les prix des 
    travaux réalisés par l’entrepreneur sont déterminés au prix unitaire du mètre carré couvert non 
    actualisable et non révisable exécuté par l’entrepreneur et validé par le maître d’ouvrage, l’architecte 
    et le B.E.T ainsi l'entrepreneur s’engage à exécuter les travaux dont 
    <?= number_format($projet->prixParMetreTTC(), 2, ',', ' ') ?> DH T.T.C par m<sup>2</sup>  
    (<?= number_format($projet->prixParMetreHT(), 2, ',', ' ') ?> DH H.T + 
    <?= number_format($projet->TVA(), 2, ',', ' ') ?> DH TVA) couvert que ce soit pour les fondations, 
    le sous-sol, le R.D.C et les étages et autres. Les mesures sont fournies par l’architecte ou le B.E.T. 
    Le prix comprend notamment le nettoyage des ouvrages, des locaux et abords utilisés.
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 5</span> : Il est formellement stipulé 
    que l’entrepreneur est réputé avoir une parfaite connaissance de la nature, des conditions et des 
    difficultés d’exécution du projet, avoir visité et apprécié toutes difficultés résultantes de 
    l’emplacement du projet, s’être entourée de tous les renseignements nécessaires à la composition des 
    prix, avoir fait préciser tous  points susceptibles de contestations et avoir eu toutes précisions 
    pour finir  l’ouvrage conformément aux règles.
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 6</span> : Les ouvrages seront exécutés
    conformément aux plans (ne variatures) dressés par :
    <br>
    <ul>
        <li>ARCHITECTE : <?= $projet->architecte() ?>.</li>
        <li>BET : <?= $projet->bet() ?>.</li>
    </ul>
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 7</span> : L’entrepreneur s'engage à 
    présenter les factures pour recevoir les décomptes du Maitre d’ouvrage par virement ou par chèque de la 
    manière suivante : 100% à la réalisation des fondations, 50% à la réalisation d’un plancher, 25% à la 
    réalisation du cloisonnement intérieur et extérieur et finalement 25% à la réalisation des enduits 
    intérieurs et extérieurs y/c pose des faux cadres. 
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 8</span> : L’entrepreneur ne peut pas 
    céder, faire apport ou sous-traiter tout ou partie des travaux faisant l'objet du présent contrat sans 
    autorisation préalable du Maître d’ouvrage.
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 9</span> : L’entrepreneur s'engage à 
    livrer les travaux au Maître d’ouvrage dans les meilleurs délais. 
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 10</span> : Les réunions de chantier 
    se tiendront sur le lieu des travaux à chaque fois qu’il est nécessaire. Elles réuniront outre le Maître 
    d’Ouvrage, l’architecte, le B.E.T, l’entrepreneur et tous autres mandataires du maître d’ouvrage habilités 
    à contrôler les travaux. A chaque réunion, un procès-verbal sera établi, résumant l’état d’avancement des 
    travaux, les décisions prises, les anomalies constatées et les instructions données. L’entrepreneur devra 
    commencer l’exécution immédiate de toutes ces décisions ou instruction concernant les travaux. Si des 
    malfaçons venaient à être décelées, les travaux seront refaits à la charge de l’entrepreneur.
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 11</span> : A la fin des travaux du 
    présent contrat, il sera procédé à la réception des travaux, le maître d’ouvrage, le B.E.T et l’architecte 
    décideront après visite du Bâtiment si cette réception peut être prononcée. Si des malfaçons venaient à 
    être décelées, les travaux seront refaits à la charge de l’entrepreneur. Le nettoyage et la remise en état 
    des emplacements mis à la disposition de l’entrepreneur, est fixé à 10 (dix) jours de calendrier à compter 
    de la date de la réception. Après cette réception, l’entrepreneur restera soumis à la responsabilité de 
    droit commun marocain.
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 12</span> : L’entrepreneur sera soumis 
    pour l’exécution de ses travaux au contrôle du maître d’ouvrage  et de la maîtrise d’œuvre : Architecte et 
    B.E.T. Le maître d’ouvrage  se réserve le droit de procéder à d’autres contrôles qu’il jugera nécessaires, 
    soit par ses propres moyens, soit par d’autres organismes de contrôle. Ainsi, pendant toute la durée des 
    travaux, les agents de contrôle auront libre accès sur le chantier et pourront prélever aussi souvent que 
    nécessaire les échantillons de matériaux et matériels mis en œuvre pour essais et examens. Ils vérifieront 
    la conformité de l’exécution avec les plans visés « bon pour exécution » remis à l’entrepreneur. Pour ce 
    faire, l’entrepreneur doit laisser le libre accès du chantier, aux ingénieurs chargés du contrôle, et leur 
    présenter, s’ils le demandent toutes pièces du marché et leur fournir tous renseignements et explications 
    utiles pour l’accomplissement de leur mission. L’entrepreneur s’engage également à accepter l’arbitrage 
    du maître d’ouvrage  sur tout différend l’opposant aux agents des organismes de contrôle désignés pour 
    contrôler les travaux.
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 13</span> : L’entrepreneur, de part sa 
    signature, reconnaît qu’il est seul responsable de tous accidents de toute perte ou dommage, matériel ou 
    corporel, du fait direct ou indirect des travaux ou fournitures objet du marché ou causés par son personnel 
    ou son matériel. L’entrepreneur s'engage de prendre ou de faire prendre toutes dispositions afin d'assurer 
    la sécurité du chantier, l'hygiène, la santé et la sécurité de ses travailleurs et la sécurité publique, 
    en répondant à toutes les obligations mises à sa charge. L’entrepreneur s'engage également à respecter 
    les règles de l'art, les dispositions légales et réglementaires et à se conformer aux mesures prises pour 
    le bon ordre et l'organisation générale du chantier et en particulier aux règles communes prescrites en 
    matière de sécurité, de santé, de code de travail, de retraite, de prévoyance, de santé et de sécurité 
    sociale. L’entrepreneur déclare assumer toutes les charges occasionnées par ses travaux aussi bien pendant 
    l’exécution ou à la rupture du présent contrat des indemnisations pour fin de carrière ou risque d'atteinte 
    à la santé ou à l'intégrité physique ou morale de ses travailleurs et autres intervenants pour l’exécution 
    des travaux pour le compte de l’entrepreneur. Cette responsabilité s’entend aussi bien pendant l’exécution 
    des travaux qu’après leur achèvement.
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 14</span> : Le présent contrat est 
        résilié de plein droit lorsque:
        <ul>
            <li>Le marché est résilié sans qu'il y ait faute du maître d’ouvrage. Dans ce cas, aucune indemnité n'est due de part et d'autre.</li>
            <li>Le maître d’ouvrage est en procédure de sauvegarde, en redressement ou liquidation judiciaire.</li>
            <li>Le présent contrat est résilié au bénéfice du maître d’ouvrage après une mise en demeure restée infructueuse pendant un délai de 10 jours pour inexécution par l’entrepreneur d'une de ses obligations contractuelles, sans préjudice de dommages et intérêts. Le maître d’ouvrage pourra alors lui substituer un autre entrepreneur. Les coûts résultants du changement de l’entrepreneur, ainsi que le coût des reprises seront à la charge du l’entrepreneur défaillant. Ces sommes pourront être déduites des sommes qui resteraient dues à l’entrepreneur défaillant. L’entrepreneur ou ses ayants droit doivent, à la demande du maître d’ouvrage, céder ou mettre à disposition les ouvrages provisoires, le matériel et les matériaux approvisionnés indispensables à la poursuite des travaux.</li>
        </ul>
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 15</span> : Les parties seront 
    momentanément, totalement ou partiellement déliées de leurs obligations dans la mesure où celles-ci 
    seront affectées par un cas de force majeure qui rendrait impossible leur exécution au titre du présent 
    contrat. La force majeure s’entend de tout acte ou évènement imprévisible, irrésistible et indépendant de 
    la volonté des parties : les accidents graves, grèves, incendies, injonctions ou restrictions 
    gouvernementales mais sans que la liste soit limitative.
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 16</span> : L’entrepreneur s'engage à 
    ne pas divulguer à des tiers des informations techniques, commerciales ou autres qui lui ont été révélées 
    ou dont il a eu connaissance dans le cadre de ses relations avec le Maître d’ouvrage. A l'expiration du 
    Contrat ou en cas de résiliation de celui-ci pour quelque cause que ce soit, il s'engage à ne pas tirer 
    profit desdites informations pour lui-même ou pour le compte de tout tiers.
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 17</span> : La maintenance au niveau 
    de l’eau et de l’électricité, sauf que, les matériels de construction sont à la charge de maître d’ouvrage.
    </p>
    <p style="text-align: left; font-size: 14px;">
    <span style="text-decoration: underline;font-weight: bold">Article 18</span> : Le Contrat sera interprété 
    et exécuté conformément à la loi marocaine et toute contestation et tous litiges relatifs à 
    l’interprétation ou à l’exécution du présent contrat doivent faire l’objet d’un règlement amiable, 
    notamment par la médiation. Au cas où tel règlement ne peut être obtenu à propos du différend, 
    compétence est donnée aux juridictions sociales marocaines.
    </p>
    <p style="text-align: left; font-size: 14px;">
    Fait à Nador, le <?= date('d/m/Y') ?> en 3 (trois) exemplaires de 5 pages. Ce contrat n’a aucune valeur juridique sans légalisation des autorités locales.
    </p>
    <table class="bottom">
        <tr>
            <td style="width: 70%">Lu et acceptée</td>
            <td style="width: 50%">Lu et acceptée</td>
        </tr>
    </table>        
    <page_footer>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
        $fileName = "contrat-".date('Y-m-d-h-i').'.pdf';
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