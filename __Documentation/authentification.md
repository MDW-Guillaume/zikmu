# L'authentification Breeze

## Gestion des redirections d'authentification

Si un utilisateur non connecté souhaite accéder au site par l'url, nous le redirigeons vers la page d'accueil qui laisse le choix de s'inscrire ou se connecter.
Cette redirection se fait dans le fichier Middleware\Authenticate.php ( return route('landing'); )

## Cheminement pour se register
Quand on allait sur la page register en étant déja connecté, Breeze se basait sur le fichier RedirectifAuthenticated.
Celui ci se servait du provider RouteServiceProvider::HOME qui renvoyait vers la route /dashboard.
J'ai donc du modifier la redirection pour l'envoyer sur la page souhaitée, à savoir la page /home.

## Cheminement pour se déconnecter
J'ai crée une route /disconnect qui utilisait le controller AuthenticatedSessionController pour lui donner comme fonction 'destroy()'
