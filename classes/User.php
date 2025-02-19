<?php


class User {
    protected ?int $id = null;
    protected ?string $nom = null;
    protected ?string $prenom = null;
    protected ?string $email = null;
    protected ?string $passwordHash = null; // Utilisé pour stocker le hash du mot de passe
    protected ?string $role = null;
    protected ?string $status =null; // Valeur par défaut

    public function __construct(?int $id, string $nom, string $prenom, string $email, string $role, ?string $password, ?string $status ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->role = $role;
        $this->passwordHash = $password;
        $this->status = $status; 
    }

    public function __toString() {
        return $this->nom . " " . $this->prenom;
    }

    // Getters
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }
    public function getStatus(): ?string { return $this->status; } // Ajout d'un getter pour status


    // Password hashing method
    public function setPasswordHash($password) {
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }

    // Setters
    public function setNom(string $nom): void { $this->nom = $nom; }
    public function setPrenom(string $prenom): void { $this->prenom = $prenom; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setRole(string $role): void { $this->role = $role; }
    public function setStatus(string $status): void { $this->status = $status; }

    public function getPasswordHash(): ?string { return $this->passwordHash; }


    // Save user to the database
    public function save() {
        $bd = Database::getInstance();
        $pdo = $bd->getConnection();
        if ($this->id) {
            $stmt = $pdo->prepare("UPDATE user SET nom = ?, prenom = ?, email = ?, password = ?, role = ?, status = ? WHERE iduser = ?");
            return $stmt->execute([$this->nom, $this->prenom, $this->email, $this->passwordHash, $this->role, $this->status, $this->id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO user (nom, prenom, email, password, role,status) VALUES (?, ?, ?, ?, ?,?)");
            $result = $stmt->execute([$this->nom, $this->prenom, $this->email, $this->passwordHash, $this->role,$this->status]);
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

        $stmt = $db->prepare("SELECT * FROM user WHERE nom LIKE :name OR prenom LIKE :name");
        $stmt->bindValue(':name', '%' . $name . '%', PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($results as $result) {
            $users[] = new User(
                $result['id'],
                $result['nom'],
                $result['prenom'],
                $result['email'],
                $result['role'],
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
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
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

        return null; 
    }

    // Static method to search user by email
    public static function findByEmail($email) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            if ($result['role'] == 'Enseignant') {
                $user = new Enseignant($result['iduser'], $result['nom'], $result['prenom'], $result['email'],$result['role'], $result['password'],$result['status']);
            } elseif ($result['role'] == 'etudiant') {
                $user = new Etudiant($result['iduser'], $result['nom'], $result['prenom'], $result['email'],$result['role'], $result['password'],$result['status']);
                
            }elseif ($result['role'] == 'admin') {
                $user = new Admin($result['iduser'], $result['nom'], $result['prenom'], $result['email'],$result['role'], $result['password'],$result['status']); 
            }
            
            
            return $user;
            
        }
    }
    // Method to register a new user (signup)
    public static function signup($nom, $prenom, $email, $role, $password) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Format d'email invalide.");
        }

        if (strlen($password) < 6) {
            throw new Exception("Le mot de passe doit contenir au moins 6 caractères.");
        }

        $nom = htmlspecialchars($nom);
        $prenom = htmlspecialchars($prenom);

        if (self::findByEmail($email)) {
            throw new Exception("L'email existe déjà.");
        }

        $status = $role === 'Enseignant' ? 'en attente' : 'accepter';
        $user = new User(null, $nom, $prenom, $email, $role, null, $status);
        $user->setPasswordHash($password);

        return $user->save();
    }


    // Method to login (signin)
    public static function signin($email, $password) {
        $user = self::findByEmail($email);

        if (!$user) {
            throw new Exception("Utilisateur introuvable.");
        }else{
            echo $user->getStatus().'<br>';
        }

        if (!password_verify($password, $user->passwordHash)) {
            throw new Exception("Email ou mot de passe invalide.");
        }
        if ($user->getStatus() === 'en attente') {
            throw new Exception("Votre compte est en attente d'approbation. Veuillez attendre la confirmation.");
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_role'] = $user->role;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_prenom'] = $user->prenom;
        $_SESSION['user_nom'] = $user->nom;
        $_SESSION['user_status'] = $user->status;

        return $user; 
    }


    public static function obtenirTousLesCours() {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT cours.idcours, cours.titre, cours.description, cours.documentation, cours.path_vedio, cours.dateCreation, user.nom AS enseignant_nom, user.prenom AS enseignant_prenom, categorie.categorie 
                                  FROM cours
                                  INNER JOIN user ON cours.idEnseignant = user.iduser
                                  INNER JOIN categorie ON cours.idcategorie = categorie.idcategorie");
            $stmt->execute();
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