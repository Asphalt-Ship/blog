<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth', 'admin']);
        // on s'assure que l'utilisateur est enregistré ET admin
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
            // latest() retourne une collection dont on récupère les données avec get()
            // c'est comme un 'all' mais là on récupère d'abord le dernier article entré
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
            // on récup les catégories pour pouvoir les afficher
            // elles sont stockées dans un tableau
        return view('admin.posts.create', compact('categories'));
            // puis on joint ces données à la view
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // conditions de validation
        $validator = Validator::make($request->all(), 
        [
            "title" => ["required", "string", "max:255"],
            "category_id" => ["required", "integer", "exists:categories,id"],
                // dans la table 'categories', vérifie si l'id correspond à ce qui est entré par l'user
            "image" => ["required", "image", "dimensions:min_width=100,min_height=100"],
                // pour un post, il faut obligatoirement une image
                // mais cette donnée de BDD est nullable car si elle était requise, 
                // il faudrait rentrer à nouveau une image à chaque édition de l'article concerné
            "content" => ["required", "string"]
        ],
        [
            "title.required" => "Ce champ est obligatoire.",
            "title.string" => "Veuillez entrer un titre valide.",
            "title.max" => "Veuillez entrer un titre de 255 catactères maximum.",
            "category_id.required" => "Ce champ est obligatoire.",
            "category_id.integer" => "Ce champ doit être un nombre entier.",
            "category_id.exists" => "Cette catégorie n'existe pas.",
            "image.required" => "Ce champ est obligatoire.",
            "image.image" => "Ce type de fichier n'est pas supporté.",
            "image.dimensions" => "Veuillez insérer une image d'au moins 100x100px",
            "content.required" => "Ce champ est obligatoire.",
            "content.string" => "Format invalide."
        ]);

        // redirection en cas d'erreur
        if($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
                // le 'withInput()' permet de récupérer les données pour le champ 'old()'
        }

        // récupération de l'image depuis les données du formulaire
        // toutes les données de form sont récupérées dans la classe Laravel/Symfony '$request'
        $image = $request->image;
            // on assigne à l'image (pas le chemin) une variable

        // création d'un nom complet pour l'image pour éviter les doublons
        $image_complete_name = time() . "_" . rand(1, 999999) . "_" . $image->getClientOriginalName();
            // time() permet de compter le nombre de secondes écoulées de puis le 01/01/1970
            // rand() génère un nombre aléatoire entre les deux valeurs données
            // getClientOriginalName() récupère le nom de l'image tel qu'il est enregistré chez l'user

        // déplacement de l'image (dans le dossier indiqué) en lui pour nom $image_complete_name
        $image->move('uploads/posts/images/', $image_complete_name);
            // move() pointe sur 'public' par défaut

        // stockage des données
        Post::create([
            "title" => $request->title,
            "category_id" => $request->category_id,
            "image" => "uploads/posts/images/" . $image_complete_name,
            "content" => $request->content
        ]);

        // redirection
        return redirect()->route("admin.posts.index")->with([
            "success" => "L'article a été sauvegardé."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        if ($post)
        {
            return view('admin.posts.show', compact('post'));
        }
        else
        {
            return redirect()->route("admin.posts.index")->with([
                "warning" => "Cet article n'existe pas."
            ]);
        }
    }

    // méthode pour activer la publication au toggle
    public function published(Request $request, $id)
    {
        $post = Post::find($id);

        // le toggle renvoie une value soit 'on', soit 'null'. Du coup on teste : 
        // s'il y a une valeur pour 'published_input', alors c'est forcément 'on'
        if ($request->has('published_input'))
        {
            $post->update([
                "published" => true,
                "published_at" => now()
            ]);

            return redirect()->back()->with([
                "success" => "L'article a été publié avec succès."
            ]);
        }
        else
        {
            // si le toggle renvoie null, alors cela suppose que l'user veut dé-publier son article
            $post->update([
                "published" => false,
                "published_at" => null
            ]);

            return redirect()->back()->with([
                "warning" => "L'article a été retiré avec succès."
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::all();
            // pour importer les catégories

        if (!$post)
        {
            return redirect()->route('admin.posts.index')->with([
                "warning" => "Cet article n'existe pas."
            ]);
        }

        return view('admin.posts.edit', compact('post', 'categories'));
            // on n'oublie surtout pas de compacter !!
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // mise en place des règles de validation
        $validator = Validator::make($request->all(), 
        [
            "title" => ["required", "string", "max:255"],
            "category_id" => ["required", "integer", "exists:categories,id"],
            "image" => ["image", "dimensions:min_width=100,min_height=100"],
            "content" => ["required", "string"]
        ],
        [
            "title.required" => "Ce champ est obligatoire.",
            "title.string" => "Veuillez entrer un titre valide.",
            "title.max" => "Veuillez entrer un titre de 255 catactères maximum.",
            "category_id.required" => "Ce champ est obligatoire.",
            "category_id.integer" => "Ce champ doit être un nombre entier.",
            "category_id.exists" => "Cette catégorie n'existe pas.",
            "image.image" => "Ce type de fichier n'est pas supporté.",
            "image.dimensions" => "Veuillez insérer une image d'au moins 100x100px",
            "content.required" => "Ce champ est obligatoire.",
            "content.string" => "Format invalide."
        ]);

        // redirection en cas d'erreur
        if($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // récupération des données de $post
        $post = Post::find($id);

        // suppression du slug actuel pour qu'un nouveau puisse être généré
        $post->slug = null;

        if ($request->image)
        {
            // traitement de l'image
            $image = $request->image;
            $image_complete_name = time() . "_" . rand(1, 999999) . "_" . $image->getClientOriginalName();

            // suppression de l'ancienne image dans $post
            $path = parse_url($post->image);
                // on récupère le path de l'image
            File::delete(public_path($path['path']));
                // on delete le path

            // déplacement de la nouvelle image à son emplacement
            $image->move('uploads/posts/images/', $image_complete_name);

            // stockage des données
            $post->update([
                "title" => $request->title,
                "category_id" => $request->category_id,
                "image" => "uploads/posts/images/" . $image_complete_name,
                "content" => $request->content
            ]);
        }
        else 
        {
            $post->update([
                "title" => $request->title,
                "category_id" => $request->category_id,
                "content" => $request->content
            ]);
        }

        // redirection
        return redirect()->route("admin.posts.index")->with([
            "success" => "L'article a été modifié avec succès."
        ]);
    }

    // fonction de mise à la corbeille
    public function trashed($id)
    {
        $post = Post::find($id);

        // on dépublie l'article avant de le déplacer à la corbeille
        $post->update([
            "published" => false,
            "published_at" => null
        ]);

        $post->delete();
            // grâce à softDeletes(), l'article n'est pas purement supprimé
            // il est déplacé dans la 'corbeille'
            // il faut activer le softDeletes dans le modèle !

        return redirect()->route('admin.posts.index')->with([
            "warning" => "L'article <i>$post->name</i> a été déplacé dans la corbeille."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
