<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Member extends Model
{
    use HasFactory;

    const STATUS_LEADER = 'leader';
    const STATUS_PERMANENT = 'permanent';
    const STATUS_PART_TIME = 'part_time';
    const STATUS_TRAINING = 'training';

    public function account(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
