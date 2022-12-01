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

        header
        {
            width: 100%;
            height: 900px;
        }

        header h1
        {
            text-align: center;
            color: #4e42d4;
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
            font-size: 1.3rem;
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

    <header>
        <h1>Cahier Des Charges</h1>
    </header>

    <div>
        <h1>Presentation du projet</h1>
        <ul>
            <li> <strong> Nom du projet</strong>: <?= $post["nom"]; ?> </li>
            <li> <strong> Description</strong>: <?= $post["description"] ?> </li>
            <li> <strong> Objectif à atteindre</strong>: <?= empty($post["objectifs"])?"vide":$post["objectifs"]; ?> </li>
        </ul>
    </div>

    <div>
        <h1>Info sur l'hébergement du site </h1>
        <ul>
            <li><strong>Address du site web</strong>: <?= empty($post["nom_domaine"])?"vide":$post["objectifs"];  ?>  </li>
            <li><strong>Le site site sera Hebergé chez</strong>: <?= empty($post["hebergeur_name"])?"vide":$post["objectifs"]; ?>  </li>
        </ul>
    </div>

    <div>
        <h1>les caractéristiques du site web </h1>
        <ul>
            <li><strong>Type de site</strong>: <?= $post["site_type"]; ?>     </li>
            <li><strong>Technologie à utilisé pour realiser le site web</strong>: <?= $post["techno"]; ?> </li>
            <li><strong>Les contenus du site (textes) seront fournis par</strong>: <?= $post["site_contenue"]; ?>  </li>
            <li><strong>Optimisation des images</strong>: <?= $post["image_optimisation"]; ?>  </li>
            <li><strong>le site sera principalement en</strong>: <?= $post["langue"][0]; ?>  </li>
            <li><strong>Exemple d'url à utilisé pour le site</strong>: <?= empty($post["url_info"])?"Vide":$post["url_info"]; ?>    </li>
            <li>Nombre totale de page que doit contenir le site</strong>: <?= $post["nombre_page"]; ?>  </li>
            <li><strong>la list des fonctionnalités desiré sur le site web</strong>:
                <?php foreach ($post["fonctionnalite"] as $value): ?>
                    <mark><?=$value; ?> </mark>
                <?php endforeach ?>
            </li>
        </ul>
    </div>

    <div>
        <h1>Le design </h1>
        <ul>
           <li><strong>Concernant le logo du Site web</strong>: <?= $post["site_logo"];  ?> </li>
           <li><strong>Concernant la police d'ecriture du Site web</strong>: <?= $post["site_police"];  ?> </li>
           <li><strong>Concernant la couleur du Site web</strong>: <?= $post["site_couleur"];  ?> </li>
           <li><strong>Le design global</strong>: <?= $post["site_design"];  ?> </li>
        </ul>
    </div>

    <div>
        <h1>la visibilité du site web  </h1>
        <ul>
           <li><strong>La list des principeaux sites concurrents</strong>: <?= $post["concurrent_list"]; ?>  </li>
           <li><strong>Mots clés à utilisé pour le referencement</strong>: <?= $post["mot_cle"]; ?> </li>
           <li><strong>Gestion des publicité sur le site</strong>: <?= $post["site_ads"]; ?> </li>
           <li><strong>Visibilité sur les reseaux sociaux</strong>: <?= $post["site_reseau_sociaux"]; ?> </li>
           <li><strong>Seo</strong>: <?= $post["site_seo"]; ?></li>
           <li><strong>Concernant le suivi analytique</strong>: <?= $post["site_suivie"]; ?></li>
        </ul>
    </div>

    <div>
        <h1>Les contraintes </h1>
        <ul>
           <li><strong>Date de livraison</strong>:  <?= empty($post["date_livraison"])?"Vide":$post["date_livraison"]; ?> </li>
           <li><strong>Budget</strong>: <?= $post["budget"] ?><?= $post["devise"][0] ?> </li>
           <li><strong>Information sur la maintenance du site web</strong>: <?= $post["site_maintenance"]; ?>  </li>
        </ul>
    </div>
 	
    <div>
        <h1>Note supplementaire</h1>
        <p> <?= empty($post["infoPlus"])?"vide":$post["infoPlus"]; ?> </p>
    </div>

    <div id="copyRight" >
        <p>Generateur de cahier des charges  &copy; 2022 </p>
    </div>

 </body>
 </html>