<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Transaction",
 *     description="Transaction model",
 *     @OA\Xml(name="Transaction")
 * )
 */
class Transaction extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *     title="ID",
     *     description="Unique identifier of the transaction",
     *     format="int64",
     *     example=1
     * )
     *
     * @var int
     */
    protected $id;

    /**
     * @OA\Property(
     *     title="User ID",
     *     description="ID of the user to whom the transaction belongs",
     *     format="int64",
     *     example=123
     * )
     *
     * @var int
     */
    protected $user_id;

    /**
     * @OA\Property(
     *     title="Name",
     *     description="Name or description of the transaction",
     *     example="Salary"
     * )
     *
     * @var string
     */
    protected $name;

    /**
     * @OA\Property(
     *     title="Date",
     *     description="Date of the transaction",
     *     format="date",
     *     example="2024-09-01"
     * )
     *
     * @var string
     */
    protected $date;

    /**
     * @OA\Property(
     *     title="Deposit",
     *     description="Amount deposited in the transaction",
     *     format="float",
     *     example=1000.00
     * )
     *
     * @var float|null
     */
    protected $deposit;

    /**
     * @OA\Property(
     *     title="Expense",
     *     description="Amount spent in the transaction",
     *     format="float",
     *     example=0.00
     * )
     *
     * @var float|null
     */
    protected $expense;

    /**
     * @OA\Property(
     *     title="Created At",
     *     description="Timestamp when the transaction was created",
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
     *     description="Timestamp when the transaction was last updated",
     *     format="date-time",
     *     example="2024-09-01T00:00:00Z"
     * )
     *
     * @var \Carbon\Carbon|null
     */
    protected $updated_at;

    /**
     * Relation "Une transaction appartient à un utilisateur".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
