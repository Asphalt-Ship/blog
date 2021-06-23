<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
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
        $tags = Tag::all();

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
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
            "name" => ["required", "string", "max:255", "unique:tags"]
        ], 
        [
            "name.required" => "Ce champ est obligatoire.",
            "name.string" => "Veuillez entrer un nom valide.",
            "name.max" => "Veuillez entrer un nom de 255 caractères maximum.",
            "name.unique" => "Ce tag existe déjà."
        ]);

        // traitement des erreurs
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // stockage des données
        Tag::create([
            "name" => $request->name,
        ]);

            // on passe par le modèle de laisser passer les info...

        // redirection vers l'index des catégories
        return redirect()->route('admin.tags.index')->with([
            "success" => "Tag créé avec succès."
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
        $tag = Tag::where('id', $id)->first();

        if (!$tag)
        {
            return redirect()->route('admin.tags.index')->with([
                "warning" => "Ce tag n'existe pas."
            ]);
        }
        else
        {
            return view('admin.tags.edit', compact('tag'));
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
        $tag = Tag::find($id);

        $validator = Validator::make($request->all(), 
        [
            "name" => ["required", "string", "max:255", "unique:tags"]
        ], 
        [
            "name.required" => "Ce champ est obligatoire.",
            "name.string" => "Veuillez entrer un nom valide.",
            "name.max" => "Veuillez entrer un nom de 255 caractères maximum.",
            "name.unique" => "Ce tag existe déjà."
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // suppression du slug actuel pour qu'un nouveau puisse être généré
        $tag->slug = null;

        $tag->update([
            "name" => $request->name
        ]);

        return redirect()->route('admin.tags.index')->with([
            "success" => "Le tag a été modifié avec succès."
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
        // requête pour récupérer le tag
        $tag = Tag::find($id);

        // suppression du tag
        $tag->delete();

        // redirection
        return redirect()->route('admin.tags.index')->with([
            "warning" => "Le tag <i>$tag->name</i> a été supprimé avec succès."
        ]);
    }
}
