<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($organization) {
            $organization->slug = $organization->generateUniqueSlug($organization->organization_name);
        });
    }

    public function generateUniqueSlug($organization_name)
    {
        $slug = Str::slug($organization_name); // Generate the slug from the title

        $originalSlug = $slug;
        $iteration = 1;

        while (Organization::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $iteration++; // Append a number to the slug if it already exists
        }

        return $slug;
    }

    public function incrementViewCount()
    {
        $this->views++;
        return $this->save();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class, 'organization_guid');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'organization_guid', 'organization_guid');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
