<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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

        $categories = Category::paginate(10);
            // avec Category::paginate(10) on récupère les résultats dans des pages de 10 items
                // y a pas les boutons, par contre.. go index !
            // avec Category::all() on récupère toutes les catégories dans une variable...

        return view('admin.categories.index', compact('categories'));
            // ... puis on rajoute cette variable à la view
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validation des données
        $validator = Validator::make($request->all(), 
        [
            "name" => ["required", "string", "max:255", "unique:categories"],
        ], 
        [
            "name.required" => "Ce champ est obligatoire.",
            "name.string" => "Veuillez entrer un nom valide.",
            "name.max" => "Veuillez entrer un nom de 255 caractères maximum.",
            "name.unique" => "Cette catégorie existe déjà.",
        ]);

        // traitement des erreurs
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // stockage des données
        Category::create([
            "name" => $request->name,
        ]);

            // on passe par le modèle de laisser passer les info...

        // redirection vers l'index des catégories
        return redirect()->route('admin.categories.index')->with([
            "success" => "Catégorie créée avec succès."
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::where("id", $id)->first();
            // on cherche la catégorie où la propriété 'id' correspond à $id
            // on aurait aussi pu faire : 
            // $category = Category::find($id)->first();
                // mais cette méthode ne fonctionne que pour chercher un id

        if (!$category) 
        {
            return redirect()->route('admin.categories.index')->with([
                "warning" => "cette catégorie n'existe pas."
            ]);
        }
        else 
        {
            return view('admin.categories.edit', compact('category'));
        }
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
        $category = Category::find($id);

        $validator = Validator::make($request->all(), 
        [
            "name" => 
            [
                "required", 
                "string", 
                "max:255", 
                Rule::unique('categories')->ignore($category->id)
            ]
        ], 
        [
            "name.required" => "Ce champ est obligatoire.",
            "name.string" => "Veuillez entrer un nom valide.",
            "name.max" => "Veuillez entrer un nom de 255 caractères maximum.",
            "name.unique" => "Cette catégorie existe déjà.",
        ]);

        if ($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // suppression du slug actuel pour qu'un nouveau puisse être généré
        $category->slug = null;

        $category->update([
            "name" => $request->name
        ]);

        return redirect()->route('admin.categories.index')->with([
            "success" => "La catégorie a été modifiée avec succès."
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
        // requête pour récupérer la catégorie
        $category = Category::find($id);

        // suppression de la catégorie
        $category->delete();

        // redirection
        return redirect()->route('admin.categories.index')->with([
            "success" => "La catégorie <i>$category->name</i> a été supprimée avec succès."
        ]);
    }
}
