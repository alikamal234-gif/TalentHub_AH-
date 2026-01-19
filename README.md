```markdown
# 🎯 Talent HUB – Plateforme de recrutement (MVC PHP)

Talent HUB est une application web développée en **PHP 8 orienté objet**, sans framework, suivant une architecture **MVC** et le **Repository Pattern**.  
Elle vise à mettre en relation **candidats, recruteurs et administrateurs** autour d’un système d’offres d’emploi sécurisé et maintenable.

Ce projet collectif sert de base d’authentification réutilisable, extensible vers une véritable plateforme de recrutement.

---

## 🧠 Objectifs pédagogiques

- Mettre en place une architecture **MVC** claire et maintenable.
- Implémenter le **Repository Pattern** pour isoler l’accès aux données.
- Utiliser **PDO + requêtes préparées** pour sécuriser les interactions avec la base de données.
- Développer un système d’authentification **from-scratch** (sans package).
- Gérer les **rôles utilisateurs** : Admin, Recruteur, Candidat.
- Sécuriser les routes via middleware/guard.
- Manipuler **sessions et cookies**.
- Implémenter le **soft delete** (archivage logique).
- Utiliser **AJAX** pour les recherches et filtres dynamiques.
- Gérer l’**upload sécurisé de fichiers** (CV, images).

---

## 🏗️ Architecture

```

/app
├── Controllers
├── Models
├── Repositories
├── Middlewares
├── Services
└── Views
/config
/public
/uploads
/routes

````

Principes :
- Chaque entité a :
  - un **Model**
  - un **Repository**
  - un **Controller**
- Toutes les requêtes SQL passent par un Repository.
- Les contrôleurs ne contiennent pas de SQL direct.

---

## 👥 Rôles & Accès

| Rôle        | Accès principal |
|------------|----------------|
| Admin      | Gestion globale, statistiques, modération |
| Recruteur  | Gestion des offres et candidatures |
| Candidat   | Recherche d’offres, candidature |
| Visiteur   | Consultation publique des offres |

---

## 🔐 Authentification

Fonctionnalités :
- Inscription
- Connexion
- Déconnexion
- Hashage des mots de passe (`password_hash`)
- Vérification de session
- Redirection selon rôle
- Refus d’accès clair (403)

Middleware :
```php
AuthMiddleware::check(['admin', 'recruteur']);
````

---

## 🗂️ Fonctionnalités

### 🛠️ Back Office (Admin & Recruteurs)

* CRUD Catégories
* CRUD Tags
* CRUD Offres
* Archivage (soft delete)
* Gestion des candidatures
* Tableau de bord Admin :

  * Offres par catégorie
  * Tags populaires
  * Recruteurs actifs

---

### 👤 Recruteur

* Inscription via formulaire entreprise
* Création et gestion des offres
* Consultation des candidatures
* Accès aux CV des candidats

---

### 🧑‍💼 Candidat

* Consultation des offres
* Recherche dynamique (AJAX)
* Filtres : mots-clés, catégories, tags *(optionnel)*
* Candidature avec upload de CV sécurisé
* Jobs recommandés selon :

  * compétences
  * prétentions salariales

---

## 📁 Upload sécurisé

Contraintes :

* Taille maximale contrôlée
* Types autorisés (PDF, DOCX, JPG, PNG)
* Nom de fichier unique
* Dossier `/uploads` protégé
* Pas d’accès direct via URL

---


---

## 🔍 AJAX (Optionnel)

Utilisé pour :

* Recherche d’offres dynamique
* Filtres en temps réel
* Chargement partiel de contenu

---

## 📋 User Stories principales

* Authentification multi-rôles
* Protection des routes
* CRUD complet catégories / tags / offres
* Gestion des candidatures
* Upload CV sécurisé
* Recommandations d’offres
* Soft delete et restauration *(optionnel)*

---

## 🧪 Critères d’acceptation

* Auth fonctionnelle (register/login/logout)
* Redirections par rôle opérationnelles
* Routes protégées + 403 clair
* CRUD Catégories, Tags, Offres
* Soft delete effectif
* Upload sécurisé fonctionnel
* Repositories utilisés partout
* MVC respecté

---

## 🧑‍🤝‍🧑 Organisation

* Travail en **Squad**
* Développement collaboratif via GitHub
* Branches recommandées :

  * `main`
  * `develop`
  * `feature/*`

---

## 🗓️ Planning

| Étape              | Date                   |
| ------------------ | ---------------------- |
| Lancement du brief | **19/01/2026 à 09:00** |
| Deadline           | **25/01/2026 à 23:59** |
| Durée              | **5 jours**            |

---



## 📌 Technologies

* PHP 8
* MySQL
* PDO
* AJAX (Fetch / XMLHttpRequest)
* HTML / CSS / JS
* MVC + Repository Pattern
* Auth from scratch

---

## 🏁 Objectif final

Construire une base **solide, sécurisée et réutilisable** pour toute application PHP MVC avec :

* Auth complète
* Rôles
* Sécurité
* Clean Architecture

---

```
```
