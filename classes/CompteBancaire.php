<?php
require 'based.php';

class CompteBancaire {
    private $compte_id;
    private $numero_compte;
    private $solde;
    private $client_id;

    public function __construct($numero_compte, $solde, $client_id) {
        $this->numero_compte = $numero_compte;
        $this->solde = $solde;
        $this->client_id = $client_id;
    }

    // Method to create a new bank account
    public static function createCompte($conn, $numero_compte, $solde, $client_id) {
        $sql = "INSERT INTO comptesbancaires (numero_compte, solde, client_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdi", $numero_compte, $solde, $client_id);
        return $stmt->execute();
    }

    // Method to get all accounts from the database
    public static function getAllComptes($conn) {
        $sql = "SELECT * FROM comptesbancaires";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Retrieve an account by its ID
    public static function getCompteById($conn, $compte_id) {
        $sql = "SELECT * FROM comptesbancaires WHERE compte_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $compte_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Method to deposit money
    public static function deposit($conn, $compte_id, $amount) {
        $sql = "UPDATE comptesbancaires SET solde = solde + ? WHERE compte_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $amount, $compte_id);
        return $stmt->execute();
    }

    // Method to withdraw money
    public static function withdraw($conn, $compte_id, $amount) {
        $current_balance = self::getBalance($conn, $compte_id);
        if ($current_balance === false || $current_balance < $amount) {
            return false; // Not enough funds
        }

        $sql = "UPDATE comptesbancaires SET solde = solde - ? WHERE compte_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $amount, $compte_id);
        return $stmt->execute();
    }

    // Method to get the balance of an account
    public static function getBalance($conn, $compte_id) {
        $sql = "SELECT solde FROM comptesbancaires WHERE compte_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $compte_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return (float) $row['solde'];
        } else {
            return false; // Account not found
        }
    }

    public static function transfer($conn, $source_id, $destination_id, $amount) {
        // Start transaction
        $conn->begin_transaction();

        try {
            // Perform withdrawal from the source account
            if (!self::withdraw($conn, $source_id, $amount)) {
                throw new Exception('Failed to withdraw from source account');
            }

            // Perform deposit into the destination account
            if (!self::deposit($conn, $destination_id, $amount)) {
                throw new Exception('Failed to deposit into destination account');
            }

            // Record the transaction in the OperationsBancaires table
            if (!OperationBancaire::recordTransfer($conn, $source_id, $destination_id, $amount)) {
                throw new Exception('Failed to record the transfer');
            }

            // Commit transaction
            $conn->commit();
            return true;
        } catch (Exception $e) {
            // Rollback transaction
            $conn->rollback();
            return false;
        }
    }
}