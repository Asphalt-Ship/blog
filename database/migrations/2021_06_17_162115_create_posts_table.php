<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
                // on référence l'id de la table categories
            $table->string('title');
            $table->string('slug');
            $table->string('image')->nullable();
                // le chemin de l'image est une str
            $table->longText('content');
                // permet de très longs articles, contrairement à 'texte'
            $table->boolean('published')->default(false);
                // permet le contrôle sur la publication
                // permet donc le délayage ou le brouillonnage
            $table->timestamp('published_at')->nullable();
                // on veut pouvoir donner une date de publication nous-même
            $table->softDeletes();
                // permet, à la suppression, de placer l'article dans la 'corbeille'
                // au lieu de le supprimer définitivement dès le départ
            $table->timestamps();
                // génère created_at et updated_at

            $table->foreign('category_id')->references('id')->on('categories');
                // déclaration de la clé étrangère
                // la relation est 'posts' (1,1) - 'categories' (0,n) : 
                // c'est donc 'posts' qui prend la clé étrangère 
                // car elle a la valeur maximale la plus basse
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
