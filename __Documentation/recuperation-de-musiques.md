# Récupération de tous les titres disponibes

- Nomenclature des fichiers titres
  année - durée (minutes) - Artiste - Album
  |_ n° titre - Nom

1. Boucle sur le dossier pour récupérer les noms dans un tableau
2. Explode du nom des dossiers avec le tiret
3. Insertion dans la base de données des 4 champs
4. Aller dans le dossier
5. Boucler sur les titres pour récupérer les noms
6. Explode sur le tiret pour insérer les titres en base de données


[
  id
  artist[ 
      albums[
        name
        release
        length
        cover
        title[
          name
          length
          position
        ]
    ]
  ]
]

Manque : 
- Cover Artist
- Cover Album
- Slug  Album