<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\StatusAcademicSchoolScope;

class SmSetupAdmin extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();
  
        static::addGlobalScope(new StatusAcademicSchoolScope);
    }
   
}
