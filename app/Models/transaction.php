<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'date',
        'deposit',
        'expense',
    ];

    /**
     * Relation "Une transaction appartient à un utilisateur".
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
