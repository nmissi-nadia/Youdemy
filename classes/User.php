<?php
require_once __DIR__ . './../config/db_config.php';

abstract class User {
    protected int $id;
    protected string $nom;
    protected string $prenom;
    protected string $telephone;
    protected string $email;
    protected string $password;
    protected string $role;
    protected string $photo;
    protected bool $status;
    protected $database;

    public function __construct() {
        $this->database = Database::getInstance()->getConnection();
    }

    // GETTERS
    public function getId(): int {
        return $this->id;
    }
    public function getNom(): string {
        return $this->nom;
    }
    public function getPrenom(): string {
        return $this->prenom;
    }
    public function getTelephone(): string {
        return $this->telephone;
    }
    public function getEmail(): string {
        return $this->email;
    }
    public function getPassword(): string {
        return $this->password;
    }
    public function getRole(): string {
        return $this->role;
    }
    public function getPhoto(): string {
        return $this->photo;
    }
    public function getStatus(): bool {
        return $this->status;
    }

    // SETTERS
    public function setNom(string $nom): void {
        $this->nom = $nom;
    }
    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }
    public function setTelephone(string $telephone): void {
        $this->telephone = $telephone;
    }
    public function setEmail(string $email): void {
        $this->email = $email;
    }
    public function setPassword(string $password): void {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    public function setRole(string $role): void {
        $this->role = $role;
    }
    public function setStatus(string $status): void {
        $this->status = $status;
    }
    public static function connexion($email, $password) {
        $bd = BaseDeDonnees::getInstance();
        $pdo = $bd->getConnexion();

        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['iduser'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_prenom'] = $user['prenom'];
            $_SESSION['user_nom'] = $user['nom'];

            if ($user['role'] == 'admin') {
                return new Admin();
            } elseif ($user['role'] == 'Enseignant') {
                return new Enseignant();
            } elseif ($user['role'] == 'etudiant') {
                return new Etudiant();
            }
        } else {
            return null;
        }
    }

    
}