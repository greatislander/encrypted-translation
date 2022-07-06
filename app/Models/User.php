<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use ParagonIE\CipherSweet\EncryptedRow;
use ParagonIE\CipherSweet\JsonFieldMap;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use Spatie\Translatable\HasTranslations;

class User extends Authenticatable implements CipherSweetEncrypted
{
    use UsesCipherSweet, HasApiTokens, HasFactory, HasTranslations, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'bio',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'bio' => 'array',
        'email_verified_at' => 'datetime',
    ];

    public $translatable = ['bio'];

    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $localeMap = (new JsonFieldMap())
            ->addTextField('en')
            ->addTextField('fr');

        $encryptedRow->addJsonField('bio', $localeMap);
    }
}
