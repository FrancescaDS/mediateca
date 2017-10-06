<?php

class Persona_old
{
    protected $mestiere;
    protected $tabella;
    protected $che_id;
    public $Name;
    public $Surname;
    public $lista_film =[];


    public function __construct($mestiere, $che_id = 0){
        $this->mestiere = $mestiere;
        if ($this->mestiere == 'Actor'){
            $this->tabella = 'Actors';
        } elseif ($this->mestiere == 'Director'){
            $this->tabella = 'Directors';
        }
        $this->che_id = $che_id;
        if ($this->che_id != 0){
            //$db = getDataBase();
            $result = $db->prepare("SELECT ID".$this->mestiere.", Name, Surname FROM ".$this->tabella." where ID".$this->mestiere."=".$this->che_id);
            $result->execute();
            while($riga = $result->fetch()) { 
                $this->Name = $riga['Name'];
                $this->Surname = $riga['Surname'];
                $this->lista_film = $this->getListaFilm();
            }
        }
        
    }
    
    public function getMestiere(){
        return $this->mestiere;
    }
    
    public function setNameSurname($Name, $Surname){
        $this->Name = $Name;
        $this->Surname = $Surname;
    }
    
    public function insertPersona(){
        $cheQuery = "INSERT INTO " . $this->tabella . " (Name, Surname) ";
        $cheQuery = $cheQuery . "VALUES ('". $this->Name ."','".$this->Surname ."')";
        //QUERY
        //settare $che_id
    }
    
    public function updatePersona(){
        $cheQuery = "UPDATE " . $this->tabella . " SET Name='" . $this->Name . "', Surname='" . $this->Surname ."'";
        $cheQuery = $cheQuery . " WHERE ID" . $this->mestiere . "=". $cheID;
        //QUERY
    }
    
    protected function getListaFilm(){
        $db = getDataBase();
        $result = $db->prepare($this->getQueryFilm());
        $result->execute();
        return $result;
    }
    
    protected function getQueryFilm(){
        if ($this->mestiere == 'Actor'){
            $cheQuery ="SELECT Film.IDFilm, Title, Year FROM Film ";
            $cheQuery = $cheQuery . "INNER JOIN FilmActor ON Film.IDFilm = FilmActor.IDFilm ";
            $cheQuery = $cheQuery . "WHERE IDActor=" . $this->che_id . " ORDER by Year, Title";
        } elseif ($this->mestiere == 'Director') {
            $cheQuery ="SELECT IDFilm, Title, Year FROM Film ";
            $cheQuery = $cheQuery . "WHERE IDDirector=" . $this->che_id . " ORDER by Year, Title";
        }
        return $cheQuery;
    }
    
    protected function addFilm($id_film){
        //query INSERT
    }
}


?>
