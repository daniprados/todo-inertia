# Todo (Laravel + Vue + Inertia)

Exemple d'un gestor de tasques desenvolupat amb Laravel, Vue, Inertia i TailwindCSS.

Per executar l'aplicació hem d'executar les següents comandes.
Ens cal tenir instal·lat el PHP, Composer i NodeJS.

```sh
$ cp .env.example .env
$ php artisan key:generate
```

Hem de crear una base de dades i un usuari amb permisos per gestionar-la i ajustar la configuració del fitxer .env als paràmetres de la base de dades que hem creat.

```
DB_CONNECTION=mysql   #el motor de base de dades que estiguis utilitzant.
DB_HOST=host # en entorn de desenvolupament normalment serà o localhost o 127.0.0.1
DB_PORT=3306   # port de connexió
DB_DATABASE=nom_de_la_base_de_dades
DB_USERNAME=nom_de_l_usuari
DB_PASSWORD=password_de_l'usuari
```

```sh
$ npm intall
$ npm run build
$ php artisan migrate
$ php artisan serve
```