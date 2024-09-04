<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(name="User")
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * @OA\Property(
     *     title="ID",
     *     description="Unique identifier of the user",
     *     format="int64",
     *     example=1
     * )
     *
     * @var int
     */
    protected $id;

    /**
     * @OA\Property(
     *     title="Name",
     *     description="Name of the user",
     *     example="John Doe"
     * )
     *
     * @var string
     */
    protected $name;

    /**
     * @OA\Property(
     *     title="Email",
     *     description="Email address of the user",
     *     format="email",
     *     example="john.doe@example.com"
     * )
     *
     * @var string
     */
    protected $email;

    /**
     * @OA\Property(
     *     title="Password",
     *     description="Password for the user account",
     *     format="string",
     *     example="password123"
     * )
     *
     * @var string
     */
    protected $password;

    /**
     * @OA\Property(
     *     title="Role",
     *     description="Role of the user within the application",
     *     example="user"
     * )
     *
     * @var string
     */
    protected $role;

    /**
     * @OA\Property(
     *     title="Created At",
     *     description="Timestamp when the user was created",
     *     format="date-time",
     *     example="2024-09-01T00:00:00Z"
     * )
     *
     * @var \Carbon\Carbon|null
     */
    protected $created_at;

    /**
     * @OA\Property(
     *     title="Updated At",
     *     description="Timestamp when the user was last updated",
     *     format="date-time",
     *     example="2024-09-01T00:00:00Z"
     * )
     *
     * @var \Carbon\Carbon|null
     */
    protected $updated_at;

    /**
     * Relation "Un utilisateur a plusieurs transactions".
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
