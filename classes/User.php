<?php
require_once __DIR__ . './../config/db_config.php';

class User {
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
    abstract static public function login($email, $password);

    private function  insertion(){
        $db=database::getInstance()->getConnection();
        try {
            
                $stmt=$db->prepare("INSERT INTO user(nom, prenom, email, password, role)
                                    Value(?,?,?,?,?)");
                $stmt->execute([$this->nom,$this->prenom,$this->email,$this->password,$this->role]);
                $this->id=$db->lastInsertId();
          


        } catch (PDOException $e) {
           $e->getMessage();
        }
       
    }

    public static function MailExist($email) {
        $db = database::getInstance()->getConnection();
        try {
            $stmt = $db->prepare("SELECT COUNT(*) as count FROM user WHERE email = ?");
            $stmt->execute([$email]);
            $result = $stmt->fetch();
            return $result['count'] > 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la vérification de l'email : " . $e->getMessage());
        }
    }

    public static function RoleMail($email){
        $db = database::getInstance()->getConnection();
        try{
          $stmt=$db->prepare("SELECT role from user where email=? ");
          if($stmt->execute([$email])){
            $result=$stmt->fetch();
            return $result['role'];
          }else{
            return false;
          }
          
        }catch(PDOException $e){

        }
    }

    private function  StatusEnAttente($iduser){
        $db = database::getInstance()->getConnection();
        try{
            $stmt=$db->prepare("UPDATE user set status='en attente' where  iduser=?");
            $stmt->execute([$iduser]);
            
          }catch(PDOException $e){
  
          }
    }

  

    public static function inscrire($nom,$prenom,$email,$role, $password){
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);// suprimme les caractéres ilegale
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
        htmlspecialchars(trim($nom));
        htmlspecialchars(trim($prenom));
        $user=new static($nom,$prenom,$email,$role,$password);
        $user->setPassword($password);
        if($role=='Enseignant'){
         $user->insertion();
        $user->StatusEnAttente($user->id);
        Session::ActiverSession();
        $_SESSION['success'] = "inscription avec success !"; 
        header('location: ../front/connexion.php'); 
        exit();
        }if($role=='etudiant'){
            $user->insertion();
            Session::ActiverSession();
            $_SESSION['success'] = "inscription avec success !"; 
            header('location: ../front/connexion.php'); 
            exit();
        }
       
       

    }
}