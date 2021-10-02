<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SearchRequest
 * @package App\Models
 * @property string query
 * @property array payload
 * @property string status
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class SearchRequest extends StatusfulModel
{
    use HasFactory;

    protected $fillable = [
        'query'
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
