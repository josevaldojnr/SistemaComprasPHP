<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class User extends Authenticatable
{
    use Notifiable;

    // ROLES
    public const ROLE_REQUISITANTE = 1;
    public const ROLE_PRICING     = 2;
    public const ROLE_COMPRAS     = 3;
    public const ROLE_GERENTE     = 4;
    public const ROLE_ADMIN       = 5;

    /**
     * The attributes that are mass assignable.
     *
     * Ajuste conforme suas colunas reais (setor_id, role_id, is_active etc).
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active',
        'setor_id',
    ];

    /**
     * The attributes that should be hidden for arrays / JSON.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'role_id'   => 'integer',
        'setor_id'  => 'integer',
    ];

    /**
     * Compatibility: em seu model antigo você usava ->role.
     * Aqui expomos um accessor para $user->role que retorna role_id.
     */
    public function getRoleAttribute(): int
    {
        return (int) $this->attributes['role_id'] ?? 0;
    }

    /**
     * Retorna todos os usuários como array (compatibilidade com getAll procedural).
     *
     * @return array
     */
    public static function getAll(): array
    {
        return self::all()->toArray();
    }

    /**
     * Escopo para usuários ativos.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', 1);
    }

    /**
     * Helpers de role
     */
    protected function validateRole(): void
    {
        $role = $this->role;
        if ($role < self::ROLE_REQUISITANTE || $role > self::ROLE_ADMIN) {
            throw new InvalidArgumentException("Role não designada");
        }
    }

    public function isAdmin(): bool
    {
        $this->validateRole();
        return $this->role === self::ROLE_ADMIN;
    }

    public function isGerente(): bool
    {
        $this->validateRole();
        return $this->role === self::ROLE_GERENTE;
    }

    public function isCompras(): bool
    {
        $this->validateRole();
        return $this->role === self::ROLE_COMPRAS;
    }

    public function isPricing(): bool
    {
        $this->validateRole();
        return $this->role === self::ROLE_PRICING;
    }

    public function isRequisitante(): bool
    {
        $this->validateRole();
        return $this->role === self::ROLE_REQUISITANTE;
    }

    /**
     * Relacionamentos (exemplo): se você tiver uma tabela setores
     * e coluna setor_id em users, descomente/ajuste:
     */
    // public function setor()
    // {
    //     return $this->belongsTo(Setor::class, 'setor_id');
    // }

    /**
     * Se quiser, pode adicionar mutator para senha (hash automático)
     */
    public function setPasswordAttribute($value): void
    {
        if ( ! empty($value)) {
            // evita re-hash se já for hash (opcional)
            $this->attributes['password'] = \Illuminate\Support\Facades\Hash::needsRehash($value)
                ? \Illuminate\Support\Facades\Hash::make($value)
                : $value;
        }
    }
}
