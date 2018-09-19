<?php
/**
 * This is a Model class for the project component
 * Created By : AASSOU Abdelilah
 * Date       : 03/11/2015
 * Github     : @aassou
 * email      : aassou.abdelilah@gmail.com
 */
class Projet{

    //attributes
    private $_id;
    private $_nom;
    private $_nomArabe;
    private $_titre;
    private $_adresse;
    private $_adresseArabe;
    private $_superficie;
    private $_description;
    private $_budget;
    private $_numeroLot;
    private $_numeroAutorisation;
    private $_dateAutorisation;
    private $_nombreEtages;
    private $_sousSol;
    private $_rezDeChausser;
    private $_mezzanin;
    private $_cageEscalier;
    private $_terrase;
    private $_superficieEtages;
    private $_delai;
    private $_prixParMetreTTC;
    private $_prixParMetreHT;
    private $_TVA;
    private $_architecte;
    private $_bet;
    private $_created;
    private $_createdBy;
    private $_updated;
    private $_updatedBy;
    //le constructeur
    public function __construct($data){
        $this->hydrate($data);
    }
    
    //la focntion hydrate sert à attribuer les valeurs en utilisant les setters d'une façon dynamique!
    public function hydrate($data){
        foreach ($data as $key => $value){
            $method = 'set'.ucfirst($key);
            
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }
    
    //setters
    public function setId($id){
        $this->_id = $id;
    }
    
    public function setNom($nom){
        $this->_nom = $nom;
    }
    
    public function setNomArabe($nomArabe){
        $this->_nomArabe = $nomArabe;
    }
    
    public function setTitre($titre){
        $this->_titre = $titre;
    }
    
    public function setAdresse($adresse){
        $this->_adresse = $adresse;
    }
    
    public function setAdresseArabe($adresseArabe){
        $this->_adresseArabe = $adresseArabe;
    }
    
    public function setSuperficie($superficie){
        $this->_superficie = $superficie;
    }
    
    public function setDescription($description){
        $this->_description = $description;
    }
    
    public function setBudget($budget){
        $this->_budget = $budget;
    }
    
    public function setNumeroLot($numeroLot){
        $this->_numeroLot = $numeroLot;
    }
    
    public function setNumeroAutorisation($numeroAutorisation){
        $this->_numeroAutorisation = $numeroAutorisation;
    }
    
    public function setDateAutorisation($dateAutorisation){
        $this->_dateAutorisation = $dateAutorisation;
    }
    
    public function setNombreEtages($nombreEtages){
        $this->_nombreEtages = $nombreEtages;
    }
    
    public function setSousSol($sousSol){
        $this->_sousSol = $sousSol;
    }
    
    public function setRezDeChausser($rezDeChausser){
        $this->_rezDeChausser = $rezDeChausser;
    }
    
    public function setMezzanin($mezzanin){
        $this->_mezzanin = $mezzanin;
    }
    
    public function setCageEscalier($cageEscalier){
        $this->_cageEscalier = $cageEscalier;
    }
    
    public function setTerrase($terrase){
        $this->_terrase = $terrase;
    }
    
    public function setSuperficieEtages($superficieEtages){
        $this->_superficieEtages = $superficieEtages;
    }
    
    public function setDelai($delai){
        $this->_delai = $delai;
    }
    
    public function setPrixParMetreTTC($prixParMetreTTC){
        $this->_prixParMetreTTC = $prixParMetreTTC;
    }
    
    public function setPrixParMetreHT($prixParMetreHT){
        $this->_prixParMetreHT = $prixParMetreHT;
    }
    
    public function setTVA($TVA){
        $this->_TVA = $TVA;
    }
    
    public function setArchitecte($architecte){
        $this->_architecte = $architecte;
    }
    
    public function setBet($bet){
        $this->_bet = $bet;
    }
    
    public function setCreated($created){
        $this->_created = $created;
    }
    
    public function setCreatedBy($createdBy){
        $this->_createdBy = $createdBy;
    }
    
    public function setUpdated($updated){
        $this->_updated = $updated;
    }
    
    public function setUpdatedBy($updatedBy){
        $this->_updatedBy = $updatedBy;
    }
    
    //getters
    
    public function id(){
        return $this->_id;
    }
    
    public function nom(){
        return $this->_nom;
    }
    
    public function nomArabe(){
        return $this->_nomArabe;
    }
    
    public function titre(){
        return $this->_titre;
    }
    
    public function adresse(){
        return $this->_adresse;
    }
    
    public function adresseArabe(){
        return $this->_adresseArabe;
    }
    
    public function superficie(){
        return $this->_superficie;
    }
    
    public function description(){
        return $this->_description;
    }
    
    public function budget(){
        return $this->_budget;
    }
    
    public function numeroLot(){
        return $this->_numeroLot;
    }
    
    public function numeroAutorisation(){
        return $this->_numeroAutorisation;
    }
    
    public function dateAutorisation(){
        return $this->_dateAutorisation;
    }
    
    public function nombreEtages(){
        return $this->_nombreEtages;
    }
    
    public function sousSol(){
        return $this->_sousSol;
    }
    
    public function rezDeChausser(){
        return $this->_rezDeChausser;
    }
    
    public function mezzanin(){
        return $this->_mezzanin;
    }
    
    public function cageEscalier(){
        return $this->_cageEscalier;
    }
    
    public function terrase(){
        return $this->_terrase;
    }
    
    public function superficieEtages(){
        return $this->_superficieEtages;
    }
    
    public function delai(){
        return $this->_delai;
    }
    
    public function prixParMetreTTC(){
        return $this->_prixParMetreTTC;
    }
    
    public function prixParMetreHT(){
        return $this->_prixParMetreHT;
    }
    
    public function TVA(){
        return $this->_TVA;
    }
    
    public function architecte(){
        return $this->_architecte;
    }
    
    public function bet(){
        return $this->_bet;
    }
    
    
    public function created(){
        return $this->_created;
    }
    
    public function createdBy(){
        return $this->_createdBy;
    }
    
    public function updated(){
        return $this->_updated;
    }
    
    public function updatedBy(){
        return $this->_updatedBy;
    }
        
}