# Welcome to IRIS SSO Instagram - WordPress plugin 👋
![Version](https://img.shields.io/badge/version-2.0.0-blue.svg?cacheSeconds=2592000)
[![License: IRISInteractive](https://img.shields.io/badge/License-IRISInteractive-yellow.svg)](https://www.iris-interactive.fr)
![Coverage](https://img.shields.io/badge/coverage-100%25-green.svg?cacheSeconds=2592000)
![Lint](https://img.shields.io/badge/lint-100%25-yellow.svg?cacheSeconds=2592000)
![e2e](https://img.shields.io/badge/e2e-100%25-orange.svg?cacheSeconds=2592000)
![Dependencies](https://img.shields.io/badge/dependencies-100%25-crimson.svg?cacheSeconds=2592000)
![Build](https://img.shields.io/badge/build-success-teal.svg?cacheSeconds=2592000)

> An IRIS Interactive Project

### 🏠 [Homepage](https://www.iris-interactive.fr)

IRIS SSO Instagram is a WordPress plugin who allow to get a valid long token for instagram API (@ March 2020)
* PHP 7
* JS - ES6
* SCSS

## Table of Contents
- **[Getting started](#getting-started)** 
- **[Usage](#usage)** 
- **[Settings](#settings)** 
- **[Settings](#settings)** 
- **[Author](#author)** 
- **[Contributing](#-contributing)** 
- **[Show your support](#show-your-support)** 
- **[License](#license)** 

## Getting Started

Download the plugin, and paste it to the plugin directory of your WordPress installation,

Enter in the plugin directory and run:

`composer install && composer dump-autoload -o`

## Usage

First of all, finalize the configuration of the facebook/instagram application

Get the client id and the client secret of your app and register it in the admin page of the plugin

Then, click to authorize button, and enjoy, your token is getting automatically and refresh automatically if needed

For programmatically getting your token, use this method:

```php
use \IrisSsoInstagram\includes\IrisSsoInstagramUtils;
...
echo IrisSsoInstagramUtils::get_token();
```

## Settings

The configuration of the plugin takes place in two simple steps, from the admin page 'IRIS SSO instagram':

First, register your client id and client secret of your facebook/instagram application

Then, click on authorize button and accept the credential

Finally, your token is generated and you will getting this with the method explain above

## Author

👤 **IRIS Interactive**

## 🤝 Contributing

🐵 [Bernard REDARES](https://www.iris-interactive.fr/lagence/bernard) - Lead Developer

## Show your support

Give a ⭐️ if you like this project


## 📝 License

This project is [IRISInteractive](https://www.iris-interactive.fr) licensed.

***
_This README was generated with ❤️ by [readme-md-generator](https://github.com/kefranabg/readme-md-generator)_