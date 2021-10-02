<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PageRequest
 * @package App\Models
 * @property int id
 * @property int search_request_id
 * @property string url
 * @property string type
 * @property array payload
 * @property string status
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class PageRequest extends StatusfulModel
{
    use HasFactory;

    const TYPE_FILM = 'films';
    const TYPE_SERIES = 'series';
    const TYPES = [
        self::TYPE_FILM,
//        self::TYPE_SERIES,
    ];
    
    protected $fillable = [
        'search_request_id',
        'url',
        'type',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function searchRequest()
    {
        return $this->belongsTo(SearchRequest::class);
    }
}
