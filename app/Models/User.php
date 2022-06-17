<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'firstName',
        'infix',
        'lastName',
        'email',
        'password',
        'academy_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The roles that belong to the user
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, "user-role", "user_id", "role_id")
            ->withTimestamps();
    }

    /**
     * The loan requests that this user has made
     */
    public function requestLoan()
    {
        return $this->hasMany(RequestLoan::class);
    }

    /*
     * The academy that this user is a part of
     */
    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }

    /**
     * Get the full name of the user in a single string
     *
     * @return string
     */
    public function getFullName() : string
    {
        return $this->firstName
            . (isset($this->infix) && $this->infix != '' ? " {$this->infix} " : " ") // if infix isn't null nor an empty string, then add infix inbetween 2 spaces, otherwise just add a single space
            . $this->lastName;
    }

    /**
     * Method to assign a single role to the user
     * 
     * @param string $name
     * @return static
     */
    public function assignRole(string $name) {
        $this->assignRoles($name);
    }

    /**
     * Method to assign roles to the user
     * 
     * @param string $names
     * @return static 
     */
    public function assignRoles(string ...$names)
    {
        $role = Role::whereIn('name', $names)->first();
        $this->roles()->attach($role);
        return $this;
    }

    /**
     * Method to remove a single role from the user
     * 
     * @param string $name
     * @return static
     */
    public function removeRole(string $name) {
        $this->removeRoles($name);
    }

    /**
     * Method to remove roles from the user
     * 
     * @param string $names
     * @return static 
     */
    public function removeRoles(string ...$names)
    {
        $role = Role::whereIn('name', $names)->first();
        $this->roles()->detach($role);
        return $this;
    }

    /**
     * Check if user has a specific role
     *
     * @param string $role to check
     * @return boolean true if the user has the given role
     */
    public function hasRole($role): bool
    {
        foreach($this->roles as $currentRole) { // foreach role that user has
            if ($currentRole->name == $role) { // check if it's the role we're looking for
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user has one of many roles
     *
     * @param string $roles to look for
     * @return boolean true if the user has one of the given roles
     */
    public function hasARole(...$roles): bool
    {
        foreach($this->roles as $currentRole) { // foreach role that user has
            if (in_array($currentRole->name, $roles)) { // check if in $roles
                return true;
            }
        }

        return false;
    }
}
