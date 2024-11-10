#!/bin/bash

# php-local-security-checker
composer security_checker

# Lint Yaml
composer yamllint

# Lint Twig
composer twiglint

# Twig CS
composer twigcs

# PHP Stan
composer phpstan

# PHP Mnd
composer phpmnd

# PHP Cs Fixer
composer csfixer:dryrun

# ES Lint
npm run eslint:js

# Style Lint
npm run stylelint