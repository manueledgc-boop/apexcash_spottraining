<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'plan', 'premium_until', 'is_admin'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function trainingSessions(): HasMany
    {
        return $this->hasMany(TrainingSession::class);
    }

    public function trainingResults(): HasMany
    {
        return $this->hasMany(TrainingResult::class);
    }

    public function trainingStats(): HasMany
    {
        return $this->hasMany(UserTrainingStat::class);
    }

    public function leaks(): HasMany
    {
        return $this->hasMany(UserLeak::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'premium_until' => 'datetime',
        ];
    }

    public function isPremium(): bool
    {
        return $this->plan === 'premium'
            && (
                $this->premium_until === null
                || $this->premium_until->isFuture()
            );
    }

    public function isAdminPlan(): bool
    {
        return $this->plan === 'admin';
    }

    public function hasPremiumAccess(): bool
    {
        return $this->isAdminPlan() || $this->isPremium();
    }
}
