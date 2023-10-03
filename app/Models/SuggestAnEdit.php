<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuggestAnEdit extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function organization()
    {
        return $this->belongsTo(Organization::class,'organization_id','id');
    }
}
