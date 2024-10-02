<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Observers\CardObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CardObserver::class])]
class Card extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the department that owns the card
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);

    }
}
