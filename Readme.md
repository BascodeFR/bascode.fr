# L'objectif est de créer le site internet de Bascode.

# Structure de la Bdd

![](Bdd.png)



















str_replace([' ' ,  'á' ,  'à', 'é', 'í', 'ó', 'ú'],
        ['-', 'a', 'a', 'e', 'i', 'o', 'u'],
        strtolower($params['name'])


## API

` cd api/`
` php -S localhost:8000 -t public`

### Avant de Commit

`  .\vendor\bin\phpcs`
`  .\vendor\bin\phpcbf`
` .\vendor\bin\phpunit`  

Tips pour les logs git
` git log --all --decorate --oneline --graph `

### pour le contenu des actualités


{{ content | nl2br | excerpt}}

# Idée de mise à jour : 
- intégration 3d avec Spline






