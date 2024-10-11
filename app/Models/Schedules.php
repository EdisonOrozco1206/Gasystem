<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Environment;

class Schedules extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "environment_id", "date", "startTime", "endTime "];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function environment(): BelongsTo {
        return $this->belongsTo(Environment::class);
    }
}
