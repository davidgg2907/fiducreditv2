<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OauthRefreshToken extends Model
{
    protected $table = 'oauth_refresh_tokens';
    protected $primaryKey = 'id'; public $incrementing = false; protected $keyType = 'string'; public $timestamps = false;
    protected $fillable = ['id', 'access_token_id', 'revoked', 'expires_at'];
    protected function casts(): array { return ['revoked' => 'boolean', 'expires_at' => 'datetime']; }
}
