<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laravel\Passport\HasApiTokens;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     type="object",
 *     required={"name", "email", "password"},
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email"
 *      ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time"
 *     ),
 * )
 */
class User extends Model implements AuthenticatableContract
{
    use HasApiTokens, Authenticatable;

    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
