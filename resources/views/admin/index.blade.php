@extends('admin.template')
    {{-- on importe le template admin (path à partir du dossier 'views') --}}

@section('h1', "Page d'administration")
    {{-- syntaxe recommandée par Laravel --}}

@section('mycontent')

    <h3 class="container my-5 text-primary">
        Bienvenu sur la page d'administration !
    </h3>

    <div class="container row">
        <div class="col-4">
          <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Accueil</a>
            <a class="list-group-item list-group-item-action" id="list-categories-list" data-toggle="list" href="#list-categories" role="tab" aria-controls="categories">Catégories</a>
            <a class="list-group-item list-group-item-action" id="list-posts-list" data-toggle="list" href="#list-posts" role="tab" aria-controls="posts">Articles</a>
            <a class="list-group-item list-group-item-action" id="list-tags-list" data-toggle="list" href="#list-tags" role="tab" aria-controls="tags">Tags</a>
            <a class="list-group-item list-group-item-action" id="list-trash-list" data-toggle="list" href="#list-trash" role="tab" aria-controls="trash">Corbeille</a>
          </div>
        </div>
        <div class="col-8">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                Voici le portail d'accueil. Utilisez la barre de navigation sur le côté pour vous rendre dans les différentes sections. Rappelez-vous que seul un admin peut et doit accéder à cette partie du website ! Ne partagez jamais votre nom d'utilisateur ou mot de passe !
            </div>
            <div class="tab-pane fade" id="list-categories" role="tabpanel" aria-labelledby="list-categories-list">
                Chaque article possède une et une seule catégorie. Cela permet de recenser l'article et aiguiller les utilisateurs afin de rendre disponible un contenu adapté aux besoins et envies de chacun. Veuillez attribuer soigneusement une catégorie à tous vous articles.
            </div>
            <div class="tab-pane fade" id="list-posts" role="tabpanel" aria-labelledby="list-posts-list">
                Les articles sont le corps principal du blog. Rappelez-vous que tous les utilisateurs pourront voir les articles publiés. La suppression d'un article depuis la section 'Article' de la barre de navigation envoie l'article ciblé dans la section 'Corbeille' tout en prenant soin de le dé-publier au préalable.
            </div>
            <div class="tab-pane fade" id="list-tags" role="tabpanel" aria-labelledby="list-tags-list">
                Chaque article peut se voir assigner un ou plusiers tags. Ces derniers permettent de mieux identifier les sujets principaux d'un article. Dans cette section, vous pourrez créer vos propres tags et gérer ceux qui existent déjà.
            </div>
            <div class="tab-pane fade" id="list-trash" role="tabpanel" aria-labelledby="list-trash-list">
                Un article déplacé dans la corbeille ne peut plus être publié tant qu'il n'aura pas été restauré au préalable. Vous pouvez toujours visualiser son aperçu, mais vous ne pourrez pas le modifier non plus s'il n'est pas restauré. 
                ATTENTION : la suppression depuis cette section est définitive !
            </div>
          </div>
        </div>
      </div>

@endsection