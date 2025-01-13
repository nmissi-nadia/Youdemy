# Youdemy
La plateforme de cours en ligne Youdemy vise à révolutionner l’apprentissage en proposant un système interactif et personnalisé pour les étudiants et les enseignants.  ​


# Youdemy

## Description
Youdemy est une plateforme de cours en ligne innovante qui vise à transformer l'apprentissage en proposant des fonctionnalités interactives et personnalisées pour les étudiants et les enseignants. La plateforme inclut des outils de gestion avancés pour les administrateurs et un système robuste de navigation et d'interaction pour les utilisateurs.

---

## Fonctionnalités

### **Front Office**
#### Visiteur
- Accès au catalogue des cours avec pagination.
- Recherche de cours par mots-clés.
- Création d’un compte avec choix du rôle (Etudiant ou Enseignant).

#### Etudiant
- Visualisation du catalogue des cours.
- Recherche et consultation des détails des cours (description, contenu, enseignant, etc.).
- Inscription à un cours après authentification.
- Accès à une section **“Mes cours”** regroupant les cours rejoints.

#### Enseignant
- Ajout de nouveaux cours avec :
  - Titre, description, contenu (vidéo ou document), tags, et catégorie.
- Gestion des cours : modification, suppression et consultation des inscriptions.
- Accès à une section **Statistiques** sur les cours :
  - Nombre d’étudiants inscrits.
  - Nombre total de cours.

### **Back Office**
#### Administrateur
- Validation des comptes enseignants.
- Gestion des utilisateurs : activation, suspension ou suppression.
- Gestion des contenus : cours, catégories et tags.
- Accès aux statistiques globales :
  - Nombre total de cours.
  - Répartition des cours par catégorie.
  - Classement des enseignants selon le nombre d’étudiants inscrits.

### **Fonctionnalités Transversales**
- Un cours peut contenir plusieurs tags (relation many-to-many).
- Système d’authentification et d’autorisation.
- Contrôle d’accès basé sur les rôles.
- Implémentation du polymorphisme pour ajouter et afficher les cours.

### **Bonus**
- Recherche avancée avec filtres (catégories, tags, auteur).
- Statistiques avancées (engagement, popularité des catégories).
- Notifications : validation de compte ou inscription confirmée.
- Génération de certificats PDF pour les cours complétés.

---

## Exigences Techniques
- **Backend** : PHP avec MySQL pour la gestion de la base de données.
- **Frontend** : HTML, Tailwind CSS, JavaScript.
- Respect des principes OOP : encapsulation, héritage, polymorphisme.
- Gestion des relations (one-to-many, many-to-many) dans MySQL.
- Validation des données pour garantir la sécurité.

---

## Installation

### **Prérequis**
- PHP ≥ 8.0
- MySQL ≥ 5.7
- Serveur local (Laragon, XAMPP, etc.)
- Navigateur compatible (Chrome, Firefox, etc.)

### **Étapes d'installation**
1. **Cloner le dépôt GitHub** :
   ```bash
   git clone https://github.com/nmissi-nadia/Youdemy.git
   ```

2. **Configurer la base de données** :
   - Importer le fichier `youdemy.sql` dans votre serveur MySQL.
   - Mettre à jour les informations de connexion dans le fichier `config.php` :
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', 'votre-mot-de-passe');
     define('DB_NAME', 'youdemy');
     ```

3. **Lancer le serveur local** :
   - Démarrer votre serveur local (Laragon, XAMPP).
   - Accéder au projet via `http://localhost/youdemy`.

4. **Vérifier l'installation** :
   - Créez un compte et testez les fonctionnalités disponibles.

---

## Structure du Projet

```
Youdemy/
├── index.php               # Page d'accueil
├── config.php              # Configuration de la base de données
├── assets/                 # Fichiers CSS, JS, et images
├── views/                  # Fichiers HTML pour l'affichage
├── models/                 # Gestion des interactions avec la base de données
├── routes/                 # Définition des routes
└── youdemy.sql             # Script SQL pour la base de données
```



---

## Auteurs
- **Nadia NMISSI** : Conception et développement principal

---


## Contact
Pour toute question ou suggestion, veuillez contacter :
- **Email** : nmissinadia@gmail.com
- **GitHub** : [Nadia NMISSI](https://github.com/nmissi-nadia)

