<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct() 
    {
        $this->middleware([
            'auth', 
            'admin',
        ]);
    } // à chaque appel d'AdminController, le middleware vérifie que l'user est bien authentifié
            // cf: app/Http/Middleware/Authenticate.php
            // renseigné en tant que 'auth' dans app/Http/kernel.php
    // auth -> vérifie que les utilisateurs sont connectés
    // admin -> vérifie que l'utilisateur connecté est un admin

    public function index() 
    {
        return view('admin.index');
    }
}
