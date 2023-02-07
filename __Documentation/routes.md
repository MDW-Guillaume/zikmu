# Liste des routes du site depuis Figma

https://www.figma.com/file/OU0s4ABT3h2eyCGnVSllfB/Ziq%26MU?node-id=159%3A499&t=FW4WJ5TuTycasjw2-0

<iframe
        height="450"
        width="100%"
        src="https://www.figma.com/embed?embed_host=astra&url=https://www.figma.com/file/OU0s4ABT3h2eyCGnVSllfB/Ziq%26MU?node-id=159%3A499&t=FW4WJ5TuTycasjw2-0"
        allowfullscreen
        >
        </iframe>

| Page dans Figma | Route prévues | Controller |
| :- | :- | :- |
| Landing page | / | HomeController::show |
| Connexion | /connect | ProfileController |
| Inscription | /register | RegisteredUserController |
| Accueil | /home | HomeController::index |
| Genres | /genres | StyleController::index |
| Genres/{slug}| /genres/{slug} | StyleController::show |
| Artistes | /artistes | ArtistController::index |
| Artistes/{slug} | /artistes/{slug} | ArtistController::show |
| Albums | /albums | AlbumController::index |
| Albums/{slug} | /albums/{slug} | AlbumController::show |
| Titres | /titres | SongController::index |
| Titres/{slug} | /titres/{slug} | SongController::show |
| Favoris | /favoris | FavoriteController |
| Recherche | /recherche | SearchController |
| File d'attente | /a-suivre | WaitingController |
| Mon compte | /mon-compte | ProfileController |
| Mes artistes | /mes-artistes | ArtistController::show <br>avec paramètre|
| Mes albums | /mes-albums | AlbumController::show <br>avec paramètre|
| Mes titres | /mes-titres | SongController::show <br>avec paramètre|
| Contact | /contact | ContactController |
| Mentions légales | /mentions-legales | Pas de controller |
| Conditions générales <br> de vente| /cgv | Pas de controller |
