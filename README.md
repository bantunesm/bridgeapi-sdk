
# 🛠️ **BridgeAPI SDK**

[![Latest Version](https://img.shields.io/packagist/v/tonvendor/bridgeapi-sdk.svg?style=flat-square)](https://packagist.org/packages/tonvendor/bridgeapi-sdk)
[![Total Downloads](https://img.shields.io/packagist/dt/tonvendor/bridgeapi-sdk.svg?style=flat-square)](https://packagist.org/packages/tonvendor/bridgeapi-sdk)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](#license)

**BridgeAPI SDK** est un SDK minimaliste conçu pour faciliter l'intégration avec l'API **BridgeAPI**. Il fournit une interface simple pour :

- ✅ **Créer et gérer des utilisateurs (Users)**
- ✅ **Authentifier des utilisateurs et obtenir des tokens sécurisés**
- ✅ **Créer et gérer des sessions de connexion (ConnectSession)**

---

## 📚 **Sommaire**

- [🚀 Installation](#installation)
- [⚙️ Configuration](#configuration)
- [📦 Utilisation](#utilisation)
  - [Exemple de code](#exemple-de-code)
- [🔗 Ressources disponibles](#ressources-disponibles)
- [🤝 Contribuer](#contribuer)
- [📝 Licence](#licence)

---

## 🚀 **Installation**

Requiert **PHP >= 8.0** et [Composer](https://getcomposer.org/).

```bash
composer require tonvendor/bridgeapi-sdk
```

Une fois installé, le SDK est disponible via l’autoload de Composer.

---

## ⚙️ **Configuration**

Avant d’utiliser le SDK, assurez-vous de disposer de vos identifiants **BridgeAPI** :

- **CLIENT_ID**
- **CLIENT_SECRET**
- **API_VERSION** (par défaut : `2025-01-15`)

Ajoutez ces informations dans votre fichier `.env` :

```dotenv
BRIDGE_CLIENT_ID=your_client_id
BRIDGE_CLIENT_SECRET=your_client_secret
BRIDGE_API_VERSION=2025-01-15
```

---

## 📦 **Utilisation**

### 🔑 **1. Initialisation du client**

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Intervalle\BridgeSDK\BridgeConfig;
use Intervalle\BridgeSDK\BridgeClient;

// Initialisation de la configuration
$config = new BridgeConfig(
    getenv('BRIDGE_CLIENT_ID'),
    getenv('BRIDGE_CLIENT_SECRET'),
    getenv('BRIDGE_API_VERSION')
);

// Création du client
$client = new BridgeClient($config);
```

---

### 👤 **2. Création d'un utilisateur**

```php
// Créer un nouvel utilisateur
$userUuid = $client->users()->createUser('user-001');
echo "UUID de l'utilisateur : $userUuid";
```

---

### 🔐 **3. Authentification utilisateur**

```php
// Authentifier l'utilisateur et obtenir un token
$userToken = $client->auth()->getUserToken($userUuid);
echo "Token utilisateur : $userToken";
```

---

### 🌐 **4. Créer une session Connect**

```php
// Créer une session pour connecter un compte bancaire
$connectUrl = $client->connectSession()->createSession($userToken, 'testuser@example.com');
echo "Lien de connexion : $connectUrl";
```

---

## 🔗 **Ressources disponibles**

Le SDK propose différentes ressources pour interagir avec les entités principales de l’API Bridge :

| 📚 **Ressource** | 🔑 **Méthodes disponibles** |
|------------------|----------------------------|
| **Users**       | `createUser()`             |
| **Auth**        | `getUserToken()`           |
| **ConnectSession** | `createSession()`       |

Ces ressources sont accessibles via le client principal :

```php
$client->users();
$client->auth();
$client->connectSession();
```

---

## 🤝 **Contribuer**

Les contributions sont les bienvenues ! Voici les étapes pour participer :

1. **Fork** le dépôt.
2. **Clone** votre fork : `git clone https://github.com/votre-nom-utilisateur/bridgeapi-sdk.git`
3. Créez une nouvelle branche : `git checkout -b feature/your-feature`
4. Faites vos modifications et ajoutez-les : `git add .`
5. Committez vos modifications : `git commit -m "Ajout d'une nouvelle fonctionnalité"`
6. Poussez votre branche : `git push origin feature/your-feature`
7. Créez une **Pull Request** sur GitHub.

---

## 📝 **Licence**

Ce SDK est distribué sous licence **MIT**.
Vous êtes libre de l’utiliser, le modifier et le redistribuer.

© **Bruno ANTUNES** – 2024

---

## 📧 **Support**

En cas de problème, ouvrez une issue sur le [dépôt GitHub](https://github.com/bantunesm/bridgeapi-sdk/issues).

---
