<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="User model",
 *     description="User model",
 *     type="object"
 * )
 *
 * @OA\Property(
 *     property="id",
 *     format="int64",
 *     description="ID",
 *     title="ID"
 * )
 *
 * @OA\Property(
 *     property="name",
 *     description="Name",
 *     title="Name"
 * )
 *
 * @OA\Property(
 *     property="email",
 *     format="email",
 *     description="Email",
 *     title="Email"
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, Uuids;

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

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
