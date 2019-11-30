<?php
require_once( __DIR__ . '/DAO.php');

class GamesDAO extends DAO {



  public function selectAll(){
    $sql = "SELECT * FROM `LanGames`";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectById($id){
    $sql = "SELECT * FROM `LanGames` WHERE `GameID` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectSnacksById($id){
    $sql = "SELECT * FROM `Lanparty_LanGames` WHERE `GamesID` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetchALL(PDO::FETCH_ASSOC);
  }



  public function delete($id){
    $sql = "DELETE FROM `Lanparty_LanGames` WHERE `SnacksID` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    return $stmt->execute();
  }

  public function updateLan($toUpdate,$value){
    if ($toUpdate == "Name"){
      $sql = "UPDATE `LanParties` SET `Name` = :valu WHERE PartyID = :id";
    }
    if ($toUpdate == "Date"){
      $sql = "UPDATE `LanParties` SET `Date` = :valu WHERE PartyID = :id";
    }
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':valu', $value);
    $stmt->bindValue(':id', $_GET["id"]);
    return $stmt->execute();
  }

  public function insertGamesid($snackdata) {
      $sql = "INSERT INTO `Lanparty_LanGames` (`GamesID`, `GameID`) VALUES (:gamesid,:gameid)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':gamesid', $snackdata['gamesid']);
      $stmt->bindValue(':gameid', $snackdata['gameid']);
      if ($stmt->execute()) {
        return $this->selectById($this->pdo->lastInsertId());
      }
    return false;
  }

  public function insertSnack($data) {
    $errors = $this->validate( $data );
    if (empty($errors)) {
      $sql = "INSERT INTO `LanParties` (`Name`, `LocationID`, `Date`) VALUES (:naam, :locationid, :datum)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':naam', $data['name']);
      $stmt->bindValue(':locationid', $data['locationID']);
      $stmt->bindValue(':datum', $data['date']);
      if ($stmt->execute()) {
        return $this->selectById($this->pdo->lastInsertId());
      }
    }
    return false;
  }

  public function validate( $data ){
    $errors = [];
    if (!isset($data['name'])) {
      $errors['Name'] = 'This field is required';
    }
    if (!isset($data['locationID'])) {
      $errors['LocationID'] = 'This field is required';
    }
    if (!isset($data['date'])) {
      $errors['Date'] =  'This field is required';
    }
    return $errors;
  }

}
