 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<title>Document</title>
    <style>
        body
        {
            padding: 1rem;
        }

        div 
        {
            margin:0.9rem ;
        }

        div h1
        {
            text-align: center;
            background: #4e42d4;
            padding: 0.8rem;
            color: #f7f9fb;
        }
        div li 
        {
            font-size: 1.4rem;
        }

        div #copyRight p
        {
            font-size: 1.2rem;
            text-align: right;
            width: 100%;
        }
    </style>
 </head>
 <body>



    <div>
        <h1>Presentation du projet</h1>
        <ul>
            <li> <strong> Nom du projet</strong>: <?= $post[0]->nom; ?> </li>
            <li> <strong> Description</strong>: <?= empty($post[0]->description)?"Vide":$post[0]->description; ?> </li>
            <li> <strong> Objectif à atteindre</strong>: <?= empty($post[0]->objectif)?"Vide":$post[0]->objectif; ?> </li>
        </ul>
    </div>

    <div>
        <h1>Info sur l'hébergement du site </h1>
        <ul>
            <li><strong>Address du site web</strong>: <?= empty($post[1]->nom_de_domaine)?"Vide":$post[1]->nom_de_domaine;  ?>  </li>
            <li><strong>Le site site sera Hebergé chez</strong>: <?= empty($post[1]->hebergeur_name)?"Vide":$post[1]->hebergeur_name; ?>  </li>
        </ul>
    </div>

    <div>
        <h1>les caractéristiques du site web </h1>
        <ul>
            <li><strong>Type de site</strong>: <?= $post[2]->site_type; ?>     </li>
            <li><strong>Technologie à utilisé pour realiser le site web</strong>: <?= $post[2]->technologie; ?> </li>
            <li><strong>Les contenus du site (textes) seront fournis par</strong>: <?= $post[2]->site_contenue; ?>  </li>
            <li><strong>Optimisation des images</strong>: <?= $post[2]->image_optimisation; ?>  </li>
            <li><strong>le site sera principalement en</strong>: <?= $post[2]->langue; ?>  </li>
            <li><strong>Exemple d'url à utilisé pour le site</strong>: <?= empty($post[2]->url_info)?"Vide":$post[2]->url_info; ?>    </li>
            <li>Nombre totale de page que doit contenir le site</strong>: <?= $post[2]->nombre_page; ?>  </li>
            <li><strong>la list des fonctionnalités desiré sur le site web</strong>: <mark><?= $post[2]->fonctionnalite; ?></mark>
            </li>
        </ul>
    </div>

    <div>
        <h1>Le design </h1>
        <ul>
           <li><strong>Concernant le logo du Site web</strong>: <?= $post[3]->logo_info;  ?> </li>
           <li><strong>Concernant la police d'ecriture du Site web</strong>: <?= $post[3]->police;  ?> </li>
           <li><strong>Concernant la couleur du Site web</strong>: <?= $post[3]->couleur;  ?> </li>
           <li><strong>Le design global</strong>: <?= $post[3]->design_type;  ?> </li>
        </ul>
    </div>

    <div>
        <h1>la visibilité du site web  </h1>
        <ul>
           <li><strong>La list des principeaux sites concurrents</strong>: <?= $post[4]->current_list; ?>  </li>
           <li><strong>Mots clés à utilisé pour le referencement</strong>: <?= $post[4]->mots_cle; ?> </li>
           <li><strong>Gestion des publicité sur le site</strong>: <?= $post[4]->pub_status; ?> </li>
           <li><strong>Visibilité sur les reseaux sociaux</strong>: <?= $post[4]->reseaux_sociaux_info; ?> </li>
           <li><strong>Seo</strong>: <?= $post[4]->seo; ?></li>
           <li><strong>Concernant le suivi analytique</strong>: <?= $post[4]->suivie_analytique; ?></li>
        </ul>
    </div>

    <div>
        <h1>Les contraintes </h1>
        <ul>
           <li><strong>Date de livraison</strong>:  <?= empty($post[5]->livraison_date)?"Vide":$post[5]->livraison_date; ?> </li>
           <li><strong>Budget</strong>: <?= $post[5]->budget ?> <?= $post[5]->devise ?> </li>
           <li><strong>Information sur la maintenance du site web</strong>: <?= $post[5]->maintenance; ?>  </li>
        </ul>
    </div>
 	
    <div>
        <h1>Note supplementaire</h1>
        <p> <?= empty($post[5]->info_plus)?"Vide":$post[5]->info_plus; ?> </p>
    </div>

    <div id="copyRight" >
        <p>Generateur de cahier des charges  &copy; 2022 </p>
    </div>

 </body>
 </html>