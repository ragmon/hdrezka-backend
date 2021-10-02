<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class StatusfulModel extends Model
{
    const STATUS_CREATED = 'created';
    const STATUS_PROCESSING = 'processing';
    const STATUS_DONE = 'done';
    const STATUS_ERROR = 'error';
    const STATUSES = [
        self::STATUS_CREATED,
        self::STATUS_PROCESSING,
        self::STATUS_DONE,
        self::STATUS_ERROR,
    ];
}