<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{
    protected $table = 'oauth_access_tokens';
    protected $primaryKey = 'id'; public $incrementing = false; protected $keyType = 'string';
    protected $fillable = ['id', 'user_id', 'name', 'scopes', 'revoked', 'expires_at'];
    protected function casts(): array { return ['revoked' => 'boolean', 'expires_at' => 'datetime']; }
}
