<?php
require 'based.php';
class OperationBancaire {
    private $operation_id;
    private $type_operation;
    private $montant;
    private $compte_source_id;
    private $compte_destination_id;
    private $date_operation;

    public function __construct($type_operation, $montant, $compte_source_id = null, $compte_destination_id = null) {
        $this->type_operation = $type_operation;
        $this->montant = $montant;
        $this->compte_source_id = $compte_source_id;
        $this->compte_destination_id = $compte_destination_id;
    }

    public static function recordDeposit($conn, $compte_id, $montant) {
        $sql = "INSERT INTO operationsbancaires (type_operation, montant, compte_source_id) VALUES ('Deposit', ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $montant, $compte_id);
        return $stmt->execute();
    }

    public static function recordWithdrawal($conn, $compte_id, $montant) {
        $sql = "INSERT INTO operationsbancaires (type_operation, montant, compte_source_id) VALUES ('Withdrawal', ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $montant, $compte_id);
        return $stmt->execute();
    }

    public static function recordTransfer($conn, $compte_source_id, $compte_destination_id, $montant) {
        $sql = "INSERT INTO operationsbancaires (type_operation, montant, compte_source_id, compte_destination_id) VALUES ('Transfer', ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dii", $montant, $compte_source_id, $compte_destination_id);
        return $stmt->execute();
    }

    public static function getAllOperations($conn) {
        $sql = "SELECT * FROM operationsbancaires ORDER BY date_operation DESC";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function getOperationsByCompte($conn, $compte_id) {
        $sql = "SELECT * FROM operationsbancaires WHERE compte_source_id = ? OR compte_destination_id = ? ORDER BY date_operation DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $compte_id, $compte_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Additional methods for specific queries or reporting can be added.
}
