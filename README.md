# BridgeAPI SDK

[![Latest Version](https://img.shields.io/packagist/v/tonvendor/bridgeapi-sdk.svg?style=flat-square)](https://packagist.org/packages/tonvendor/bridgeapi-sdk)
[![Total Downloads](https://img.shields.io/packagist/dt/tonvendor/bridgeapi-sdk.svg?style=flat-square)](https://packagist.org/packages/tonvendor/bridgeapi-sdk)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](#license)

**BridgeAPI SDK** est un SDK minimaliste pour interagir avec l’API Bridge (ex‑Bankin’).
Il fournit une interface simple pour :

- Créer et gérer des **Users**
- Récupérer leurs **Items** (banques connectées)
- Lister et gérer leurs **Accounts**
- Lister et manipuler leurs **Transactions**
- Récupérer leurs **Stocks**

---

## Sommaire

- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
  - [Exemple de code](#exemple-de-code)
- [Ressources disponibles](#ressources-disponibles)
- [Contribuer](#contribuer)
- [Licence](#licence)

---

## Installation

Requiert **PHP >= 7.4** et [Composer](https://getcomposer.org/).

```bash
composer require tonvendor/bridgeapi-sdk
```

Une fois installé, le SDK est disponible via l’autoload de Composer.

## Configuration

Avant d’utiliser le SDK, assurez-vous de disposer de vos identifiants Bridge :
- CLIENT_ID
- CLIENT_SECRET
- ENV (sandbox ou production)

Vous pouvez les stocker dans un fichier .env (ou utiliser n’importe quel autre moyen), puis transmettre ces valeurs au SDK via la classe BridgeConfig.

## Utilisation

### Exemple de code

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use TonVendor\BridgeSDK\BridgeConfig;
use TonVendor\BridgeSDK\BridgeClient;

// 1. Créez la config
$config = new BridgeConfig(
    'YOUR_CLIENT_ID',
    'YOUR_CLIENT_SECRET',
    false // false => sandbox, true => production
);

// 2. Instanciez le client
$client = new BridgeClient($config);

// 3. Créez un utilisateur
$user = $client->users()->create([
    'email'    => 'example.user@yourapp.com',
    'country'  => 'FR',
    'currency' => 'EUR',
]);

// 4. Récupérez la liste de ses comptes
$accounts = $client->accounts()->listUserAccounts($user['uuid']);

// 5. Transactions du premier compte
if (!empty($accounts)) {
    $transactions = $client->transactions()->listAccountTransactions(
        $user['uuid'],
        $accounts[0]['uuid'],
        ['limit' => 50, 'offset' => 0]
    );
    print_r($transactions);
}
```

Pour plus de détails sur les endpoints, référez-vous à la documentation officielle Bridge.

## Ressources disponibles

Le SDK propose différentes resources pour interagir avec les entités principales de l’API Bridge :
- Users : create(), get(), etc.
- Items : listUserItems(), etc.
- Accounts : listUserAccounts(), etc.
- Transactions : listAccountTransactions(), etc.
- Stocks : listAccountStocks(), etc.

Chacune est accessible via les méthodes du BridgeClient.
Libre à vous d’hériter de ces classes si vous souhaitez ajouter des méthodes personnalisées.

## Licence

Ce SDK est distribué sous licence MIT.
Vous êtes libre de l’utiliser, le modifier et le redistribuer.

© Bruno ANTUNES – 2024