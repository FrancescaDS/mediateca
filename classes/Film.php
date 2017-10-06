<?php
Class Film{
    protected $db;
    
    public $Director;
    public $Poster;
    
    //idCountry, Country, idDirector, Director, Title, Year
    protected $data;
    
    public $lista_Actors = [];
    
    public function __construct(PDO $connection_object, $id = 0) {
        $this->db = $connection_object;
        if ($id != 0){
            $statement = $this->selectFilm($id);
            if ($statement->rowCount() == 1) {
                $stored_data = $statement->fetch(PDO::FETCH_ASSOC);
                $this->data = $stored_data;
                $this->lista_Actors = $this->getListaActors($id);
                $this->Director = new Persona($connection_object, 'Director', $this->data['IDDirector']);
                
                $sql = "SELECT * FROM Posters WHERE IDFilm = :film_id";
                $stat = $this->db->prepare($sql);
                $stat->bindParam(':film_id', $id); 
                $stat->execute();
                $this->Poster = $stat->fetchObject('Poster');
                
            }
        }
    }
    
    public function getData() {
        return $this->data;
    }
    
   
    private function selectFilm($id){
        $query ="SELECT Film.IDFilm, Posters.IDPoster, Type, Poster, Title, "
                . "Film.IDDirector, Year, Country FROM Film "
                . "LEFT JOIN Countries ON Countries.IDCountry = Film.IDCountry "
                . "LEFT JOIN Posters ON Posters.IDFilm = Film.IDFilm "
                . "WHERE Film.IDFilm=" . $id ;
        
        $statement = $this->db->prepare($query);
        $statement->execute();
        return $statement;
    }
    
    protected function getListaActors($id){
        $sql ="SELECT Actors.IDActor, Name, Surname, IDFilm FROM Actors "
                . "LEFT JOIN FilmActor ON FilmActor.IDActor = Actors.IDActor "
                . "WHERE FilmActor.IDFilm = " . $id . " ORDER By Surname, Name ";

        $result = $this->db->prepare($sql);
        $result->execute();
        return $result;
    }
    
    
    
}



?>

