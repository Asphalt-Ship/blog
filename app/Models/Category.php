<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = [];
        // on dit au modèle de laisser passer les données

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    // fonction du Merise
    public function posts() 
    {
        return $this->hasMany(Post::class);
        // on indique qu'un catégorie peut avoir 0 ou plusieurs posts (0,n)
    }
}