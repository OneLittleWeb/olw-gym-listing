<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function organization()
    {
        return $this->belongsTo(Organization::class,'organization_guid','organization_guid');
    }
    public function pictures()
    {
        return $this->hasMany(Picture::class, 'organization_guid','organization_guid');
    }
}
