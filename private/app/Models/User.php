<?php declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Filterable;
use App\Models\Traits\Paginable;
use App\Models\Traits\Sortable;
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
    use HasApiTokens, Authenticatable, Sortable, Paginable, Filterable;

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
     * @param null|string $sort
     * @param array       $pages
     * @param array       $filters
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder
     */
    public function search(?string $sort, array $pages = [], array $filters = [])
    {
        $query = $this->select();

        $this->addSorts($query, $sort);
        $this->addFilters($query, $filters);

        return $this->addPagination($query, $pages);
    }
}
