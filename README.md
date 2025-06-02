# Projet Hackathon DWWM

## Pour Commencer

### Prérequis

- PHP 8.2
- Composer
- Symfony CLI
- Git
- MySQL 8.0

### Installation

1. Cloner le dépôt
```bash
git clone https://github.com/your-username/hackathon-DWWM.git
cd hackathon-DWWM
```

2. Installer les dépendances
```bash
composer install
```

3. Configurer l'environnement
```bash
cp .env .env.local
# Modifier .env.local avec vos identifiants de base de données
```

4. Créer la base de données et exécuter les migrations
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

5. Démarrer le serveur Symfony
```bash
symfony server:start
```

### Workflow de Développement

1. Créer et basculer sur une nouvelle branche de fonctionnalité
```bash
git checkout -b feature/your-feature-name
```

2. Effectuer vos modifications et les commiter
```bash
git add .
git commit -m "feat(scope): your commit message"
```

3. Maintenir votre branche à jour avec main
```bash
git checkout main
git pull origin main
git checkout feature/your-feature-name
git merge main
```

### Commandes Git Utiles

- Vérifier le statut : `git status`
- Voir l'historique des commits : `git log`
- Annuler les modifications : `git checkout -- <file>`
- Mettre en attente les modifications : `git stash`
- Appliquer les modifications en attente : `git stash pop`

### Commandes Git Flow

- Initialiser Git Flow : `git flow init`
- Démarrer une fonctionnalité : `git flow feature start feature-name`
- Terminer une fonctionnalité : `git flow feature finish feature-name`
- Démarrer une release : `git flow release start v1.0.0`
- Terminer une release : `git flow release finish v1.0.0`
- Démarrer un hotfix : `git flow hotfix start v1.0.1`
- Terminer un hotfix : `git flow hotfix finish v1.0.1`

### Commandes GitHub CLI

- Créer une PR : `gh pr create`
- Lister les PRs : `gh pr list`
- Récupérer une PR : `gh pr checkout <number>`
- Créer une issue : `gh issue create`
- Lister les issues : `gh issue list`

### Commandes Symfony Utiles

- Vider le cache : `php bin/console cache:clear`
- Créer une entité : `php bin/console make:entity`
- Créer une migration : `php bin/console make:migration`
- Exécuter les migrations : `php bin/console doctrine:migrations:migrate`
- Créer un contrôleur : `php bin/console make:controller`
- Créer un formulaire : `php bin/console make:form`
- Créer un CRUD : `php bin/console make:crud`

## Structure du Projet

```
hackathon-DWWM/
├── config/
├── public/
├── src/
│   ├── Controller/
│   ├── Entity/
│   ├── Form/
│   ├── Repository/
│   └── Service/
├── templates/
├── tests/
├── translations/
├── var/
└── vendor/
```

## Contribution

1. Créer une nouvelle branche pour votre fonctionnalité
2. Effectuer vos modifications
3. Soumettre une pull request

## Licence

Ce projet est sous licence MIT - voir le fichier LICENSE pour plus de détails. 