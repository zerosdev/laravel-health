<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    use HasUuids;

    /**
     * Whether the primary key is autoincrementing or not
     * 
     * @var boolean 
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'id_type',
        'id_no',
        'gender',
        'dob',
        'address',
        'medium_acquisition',
    ];

    /**
     * Type of the primary key
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Relation to User
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
