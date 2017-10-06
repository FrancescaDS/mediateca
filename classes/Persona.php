<?php

class Persona {


    protected $db;

    protected $data = [];
    protected $mestiere;
    protected $tabella;
    protected $Type_id;
    
    public $lista_film =[];

    public function __construct(PDO $connection_object, $mestiere, $id = 0) {
        $this->db = $connection_object;
        $this->mestiere = $mestiere;
        $this->Type_id = 'ID' . $this->mestiere;
        $temp = $this->mestiere;
        //$this->tabella = substr($temp,0,strlen($temp)-1) . 'i';
        $this->tabella = $temp . 's';
        if ($id != 0){
            $statement = $this->selectPersona($id);
            if ($statement->rowCount() == 1) {
                $stored_data = $statement->fetch(PDO::FETCH_ASSOC);
                $this->data = $stored_data;
                $this->lista_film = $this->getListaFilm();
            }
            
        }
    }

    public function insertPersona(){
        $cheQuery = "INSERT INTO " . $this->tabella . " (Name, Surname)
        VALUES (:Name, :Surname)";
        $statement = $this->db->prepare($query);
        $query_data = [
            ':Name' => $Name,
            ':Surname' => $Surname
        ];
        if ($statement->execute($query_data)) {
            // If query successful, add user's data to the $data object property
            $this->data = [
                $this->Type_id => $this->db->lastInsertId(),
                'Name' => $Name,
                'Surname' => $Surname
            ];
            return true;
        } else {
            return false;
        }
    }
    
    public function updatePersona(){
        $cheQuery = "UPDATE " . $this->tabella . " SET Name='" . $this->data['Name'] . "', Surname='" . $this->data['Surname'] ."'";
        $cheQuery = $cheQuery . " WHERE " . $this->Type_id . "=". $this->data[$this->Type_id];
        $statement = $this->db->prepare($query);
        $statement->execute();
    }
      

    /*
     * Public "getter" method so outside code can access the user's data
     * (which is a protected property). As mentioned above, we probably
     * shouldn't store this data in this object... a dedicated "User"
     * object would be preferable...
     */
    public function getData() {
        return $this->data;
    }
    
   
    private function selectPersona($id){
        $query = "SELECT * FROM ". $this->tabella. " WHERE ".$this->Type_id."=".$id;
        $statement = $this->db->prepare($query);
        $statement->execute();
        return $statement;
    }

    
    protected function getListaFilm(){
        $result = $this->db->prepare($this->getQueryFilm());
        $result->execute();
        return $result;
    }
    
    protected function getQueryFilm(){
        if ($this->mestiere == 'Actor'){
            $cheQuery ="SELECT Film.IDFilm, Title, Year FROM Film ";
            $cheQuery = $cheQuery . "INNER JOIN FilmActor ON Film.IDFilm = FilmActor.IDFilm ";
            $cheQuery = $cheQuery . "WHERE IDActor=" . $this->data[$this->Type_id] . " ORDER by Year, Title";
        } elseif ($this->mestiere == 'Director') {
            $cheQuery ="SELECT IDFilm, Title, Year FROM Film ";
            $cheQuery = $cheQuery . "WHERE IDDirector=" . $this->data[$this->Type_id] . " ORDER by Year, Title";
        }
        return $cheQuery;
    }
    
    
    
}
?>
