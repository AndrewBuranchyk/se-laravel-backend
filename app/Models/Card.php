<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory;

    /**
     * Get the department that owns the card
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);

    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'department_id',
        'gr',
        'el',
        'ms',
        'rp',
        'data',
    ];

}
