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

        // Check if the slug already exists in the database
        $existingSlugCount = Organization::where('slug', 'LIKE', "{$slug}%")->count();

        // If the slug already exists, generate a new one with a unique number
        if ($existingSlugCount > 0) {
            $slug .= '-' . mt_rand(1000000, 9999999); // Append a random number to make the slug unique
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
