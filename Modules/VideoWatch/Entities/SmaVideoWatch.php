<?php

namespace Modules\VideoWatch\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmaVideoWatch extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\VideoWatch\Database\factories\SmaVideoWatchFactory::new();
    }
}
