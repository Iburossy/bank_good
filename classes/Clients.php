<?php
require 'based.php';

class Client {
    private $client_id;
    private $nom;
    private $adresse;
    private $telephone;

    public function __construct($nom, $adresse, $telephone) {
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->telephone = $telephone;
    }

    public static function getClientById($conn, $client_id) {
        $sql = "SELECT * FROM clients WHERE client_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $client_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public static function getClientIdByName($conn, $nom) {
        $sql = "SELECT client_id FROM clients WHERE nom = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nom);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['client_id'];
        } else {
            return false; // Client not found
        }
    }

    public static function getAllClients($conn) {
        $sql = "SELECT client_id, nom FROM clients";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
