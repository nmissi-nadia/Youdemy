<?php


class User {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $role;
    private $passwordHash;

    public function __construct($id, $nom, $prenom, $email,$role, $passwordHash) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->role = $role;
        $this->passwordHash = $passwordHash;
    }

    public function __toString() {
        return $this->nom . " " . $this->prenom;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }

    // Password hashing method
    public function setPasswordHash($password) {
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }


    public function setRole(string $role): void {
        $this->role = $role;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }
    // Save user to the database
    public function save() {
        $bd = Database::getInstance();
        $pdo = $bd->getConnection();
        if ($this->id) {
            $stmt = $pdo->prepare("UPDATE user SET nom = ?, prenom = ?, email = ?, password = ?, role = ?, status = ? WHERE iduser = ?");
            return $stmt->execute([$this->nom, $this->prenom, $this->email, $this->passwordHash, $this->role, $this->status, $this->id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO user (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
            $result = $stmt->execute([$this->nom, $this->prenom, $this->email, $this->passwordHash, $this->role]);
            if ($result) {
                $this->id = $pdo->lastInsertId();
            }
            return $result;
        }
    }
    
        // Search user by name
    public function searchUserByName($name)
    {
        $db = Database::getInstance()->getConnection();

        // Prepare the SQL query
        $stmt = $db->prepare("SELECT * FROM user WHERE nom LIKE :name OR prenom LIKE :name");

        // Bind the parameter for name search (using wildcards for partial match)
        $stmt->bindValue(':name', '%' . $name . '%', PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Fetch all matching users
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return an array of User objects
        $users = [];
        foreach ($results as $result) {
            $users[] = new User(
                $result['id'],
                $result['nom'],
                $result['prenom'],
                $result['email'],
                $result['password']
            );
        }

        return $users;
    }

    // Get user by ID
    public function getUserById($id)
    {
        $db = Database::getInstance()->getConnection();

        // Prepare the SQL query
        $stmt = $db->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new User(
                $result['id'],
                $result['nom'],
                $result['prenom'],
                $result['email'],
                $result['password']
            );
        }

        return null; // User not found
    }

    // Static method to search user by email
    public static function findByEmail($email) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
        
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $result['password'];
        if ($result) {
            if ($result['role'] == 'Enseignant') {
                $user = new Enseignant($result['iduser'], $result['nom'], $result['prenom'], $result['email'],$result['role'], $result['password']);
            } elseif ($result['role'] == 'etudiant') {
                $user = new Etudiant($result['iduser'], $result['nom'], $result['prenom'], $result['email'],$result['role'], $result['password']);
            }
             elseif ($result['role'] == 'admin') {
                $user = new Admin($result['iduser'], $result['nom'], $result['prenom'], $result['email'],$result['role'], $result['password']);
                
            }
             else {
                return null;
            }

            // $user->passwordHash = $result['password'];
            return $user;
            
        }
    }
    // Method to register a new user (signup)
    public static function signup($nom, $prenom, $email, $password) {
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format");
    }

    // Validate password length
    if (strlen($password) < 6) {
        throw new Exception("Password must be at least 6 characters long");
    }

    // Sanitize name fields
    $nom = htmlspecialchars($nom);
    $prenom = htmlspecialchars($prenom);

    // Check if email already exists
    if (self::findByEmail($email)) {
        throw new Exception("Email is already registered");
    }

    // Create a new user object
    $user = new User(null, $nom, $prenom, $email);
    $user->setPasswordHash($password); // Hash the password
    return $user->save();
}


    // Method to login (signin)
    public static function signin($email, $password) {

        $user = self::findByEmail($email);
    
        // Check if user exists and password is correct
        if (!$user || !password_verify($password, $user->passwordHash)) {
            throw new Exception("Invalid email or password");
        }
    
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_role'] = $user->role;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_prenom'] = $user->prenom;
        $_SESSION['user_nom'] = $user->nom;
    
        return $user; // Successful login
    }

    // Method to change the user's password
    public function changePassword($newPassword) {
        $this->setPasswordHash($newPassword); // Hash the new password
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->bindParam(':password', $this->passwordHash, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function obtenirTousLesCours() {
        try {
            $db = Database::getInstance()->getConnection();
    
            // Préparation de la requête pour récupérer tous les cours
            $stmt = $db->prepare("SELECT cours.idcours, cours.titre, cours.description, cours.documentation, cours.path_vedio, cours.dateCreation, user.nom AS enseignant_nom, user.prenom AS enseignant_prenom, categorie.categorie 
                                  FROM cours
                                  INNER JOIN user ON cours.idEnseignant = user.iduser
                                  INNER JOIN categorie ON cours.idcategorie = categorie.idcategorie");
            $stmt->execute();
    
            // Récupération des résultats
            $cours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $cours;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des cours : " . $e->getMessage());
        }
    }

    public static function obtenirToutesLesCategories() {
        try {
            $db = Database::getInstance()->getConnection();
    
            $stmt = $db->prepare("SELECT * FROM categorie");
            $stmt->execute();
    
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $categories;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des catégories : " . $e->getMessage());
        }
    }

    public static function obtenirTousLesTags() {
        try {
            $db = Database::getInstance()->getConnection();
    
            // Préparation de la requête pour récupérer tous les tags
            $stmt = $db->prepare("SELECT * FROM tag");
            $stmt->execute();
    
            // Récupération des résultats
            $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $tags;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des tags : " . $e->getMessage());
        }
    }
    
    

    
}