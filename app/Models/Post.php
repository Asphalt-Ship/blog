<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = [];
        // on dit au modèle de laisser passer les données

    protected $dates = 
    [
        "created_at", 
        "updated_at",
        "deleted_at",
        "published_at"
    ];
        // on indique que ces champs doivent recevoir le format de date souhaité

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    // fonction du Merise
    public function category() 
    {
        return $this->belongsTo(Category::class);
        // on indique qu'un post doit avoir une seule catégorie (1,1)
    }
}
