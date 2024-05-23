<?php
require 'based.php';
class EmployesDeBank {
    private $employe_id;
    private $prenom;
    private $nom;
    private $poste;
    private $email;
    private $mot_de_passe;
    private $photo_profil;

    public function __construct($prenom, $nom, $poste, $email, $mot_de_passe, $photo_profil = null) {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->poste = $poste;
        $this->email = $email;
        $this->mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $this->photo_profil = $photo_profil;
    }

    public static function createEmploye($conn, $prenom, $nom, $poste, $email, $mot_de_passe, $photo_profil = null) {
        $sql = "INSERT INTO Employes (prenom, nom, poste, email, mot_de_passe, photo_profil) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $hashedPassword = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $stmt->bind_param("ssssss", $prenom, $nom, $poste, $email, $hashedPassword, $photo_profil);
        return $stmt->execute();
    }

    public static function getEmployeById($conn, $employe_id) {
        $sql = "SELECT * FROM Employes WHERE employe_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $employe_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function updateEmploye($conn, $employe_id, $prenom, $nom, $poste, $email, $mot_de_passe = null, $photo_profil = null) {
        $sql = "UPDATE Employes SET prenom = ?, nom = ?, poste = ?, email = ?";
        if ($mot_de_passe) {
            $hashedPassword = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            $sql .= ", mot_de_passe = ?";
        }
        if ($photo_profil) {
            $sql .= ", photo_profil = ?";
        }
        $sql .= " WHERE employe_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $prenom, $nom, $poste, $email, $hashedPassword, $employe_id);
        return $stmt->execute();
    }

    public static function deleteEmploye($conn, $employe_id) {
        $sql = "DELETE FROM Employes WHERE employe_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $employe_id);
        return $stmt->execute();
    }

    public static function authenticate($conn, $email, $mot_de_passe) {
        $sql = "SELECT * FROM Employes WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if (password_verify($mot_de_passe, $row['mot_de_passe'])) {
                return $row; // Successfully authenticated
            }
        }
        return false; // Authentication failed
    }

    // Additional methods like listing all employees can be added if needed.
}
?>
