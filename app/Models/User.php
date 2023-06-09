<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use CrudTrait;
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'username',
        'firstname',
        'lastname',
        'is_admin',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Génération d'une adresse e-mail unique
            $email = $user->email;

            // Génération d'un mot de passe aléatoire

            if (isset($user->seeder) && $user->seeder) {
                $password = $user->password;
                // Envoi de l'e-mail avec les informations d'identification
                Mail::send('emails.user_created', ['email' => $email, 'password' => $password], function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Compte utilisateur créé')
                        ->attach('public/img/logo.png', [
                            'as' => 'logo.png',
                            'mime' => 'image/png',
                        ]);
                });
                $user->username = 'user' . rand(100000, 999999);
                unset($user->seeder);
            } else {
                $password = Str::random(8);
                //Envoi de l'e-mail avec les informations d'identification
                Mail::send('emails.user_created', ['email' => $email, 'password' => $password], function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Compte utilisateur créé')
                        ->attach('img/logo.png', [
                            'as' => 'logo.png',
                            'mime' => 'image/png',
                        ]);
                });
                $user->password = Hash::make($password);
            }
        });

        static::updating(function ($user) {

            $password = $user->password;

            // Envoi de l'e-mail avec les informations d'identification
            Mail::send('emails.password_admin_updated', ['email' => $user->email, 'password' => $password], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Compte utilisateur créé')
                    ->attach('img/logo.png', [
                        'as' => 'logo.png',
                        'mime' => 'image/png',
                    ]);
            });

            $user->password = Hash::make($password);
        });

        static::deleting(function ($user) {
            $all_favorites = SongsUser::where('user_id', $user->id)->get();

            foreach ($all_favorites as $favorite) {
                SongsUser::where('id', $favorite->id)->delete();
            }
        });
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
