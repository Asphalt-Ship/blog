@extends('user.template')

@section('h1', "Accueil des utilisateurs")

@section('mycontent')

    <h3 class="container my-5 text-primary">
        Bienvenu sur la page des utilisateurs !
    </h3>

    <div class="container row">
        <div class="col-4">
          <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Accueil</a>
            <a class="list-group-item list-group-item-action" id="list-posts-list" data-toggle="list" href="#list-posts" role="tab" aria-controls="posts">Articles</a>
          </div>
        </div>
        <div class="col-8">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                Bienvenue sur ce blog ! Ici, vous pourrez consulter les articles postés par notre équipe administrative. Vous devez être inscrit et connecté pour voir ces articles.
            </div>
            <div class="tab-pane fade" id="list-posts" role="tabpanel" aria-labelledby="list-posts-list">
                Nos articles ont été écrits par nos soins, et sélectionnés pour vous ! Venez les découvrir !
            </div>
          </div>
        </div>
      </div>
    
@endsection