<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class TrashController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth', 'admin']);
        // on s'assure que l'utilisateur est enregistré ET admin
    }

    public function index()
    {
        $posts = Post::onlyTrashed()->get();
            // récupère les articles mis à la corbeille

        return view('admin.trash.index', compact('posts'));
    }

    public function restore($id) 
    {
        $post = Post::withTrashed()->where('id', $id)->first();
            // on utilise cette syntaxe car le find() ne fonctionnera pas
            // on recherche le post dans la corbeille où l'id équivaut à l'id du post

        $post->restore();
            // ici, c'est la fonction de Laravel pour restaurer

        return redirect()->back()->with([
            "success" => "L'article a été restauré avec succès"
        ]);
            // comme on ne manipule pas l'url, un simple redirect-back fonctionne pour afficher le message
    }

    public function delete($id)
    {
        $post = Post::withTrashed()->where('id', $id)->first();

        $path = parse_url($post->image);
        File::delete(public_path($path['path']));
            // on supprime l'image de l'article, sinon elle reste

        $post->forceDelete();
            // cette fonction contourne le softDeletes et supprime effectivement

        return redirect()->back()->with([
            "warning" => "L'article <i>$post->name</i> a été définitivement supprimé."
        ]);
    }
}
