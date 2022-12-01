<?php 

use App\Form;
use App\Validation;
use App\connectionClass\Verify;
use App\helperClass\Helper;
use App\sqlClass\Crud;
use App\sqlClass\InitPdo;


/*les varibles */
$script="../js/formulaire";
$title="formulaire";
$style="../style/css/formulaire";

$new_validation=new Validation($_POST);
$new_crud=new Crud();
$new_verify=new Verify();
$pdo=InitPdo::newPdo("generateurDB");
$new_helper=new Helper($router);
$save=false;
$errorMessage=null;




/*redirection si id n'est pas correct  */
if(isset($_GET["direct"]) && isset($_GET["user"]))
  {  

  	$id=(int)$_GET["user"]??1;
  	$new_verify->startSession();
		$user_id=(int)$_SESSION['auth']['id'];
		$new_helper->verifyUser($id,$user_id,"indirectformulaire");
		$save=true;	
 }


/*Gession des errrur*/
[$inputErrorTab,$errorTab]=$new_validation->verifyRules(
	  		[
		  		  "required"=>["nom","nombre_page"],
		  		 "lengthMin"=>[["pseudo",5]],
		  		 "integer"=>[['nombre_page'],["budget"]],
		  		 "min"=>[["nombre_page",1],["budget",1]],
		  		 "dateFormat"=>[["date_livraison","Y-m-d"]],
		  		 "radioVerify"=>["site_type","techno","site_contenue","image_optimisation","site_logo","site_couleur","site_police","site_design","site_reseau_sociaux","site_ads","site_suivie","site_seo","site_maintenance"],
		  		 "checkBoxVerify"=>["fonctionnalite"]

	  	    ]);



try {

	if(!empty($_POST))
	{

			if(empty($inputErrorTab) && empty($errorTab))
			{
					if (!$save) 
					{

						$new_helper->pdf("htmlPdf/htmlPdf.php",$_POST);
						die();

					}

				

					if ($save) 
					{




		           $insertCahierId=$new_crud->insert("user_cahier","user_info_id")
				                         ->values(":user_id")
				                         ->executeReq(null,["user_id"=>$id]);
	               
				          if(is_int((int)$pdo->lastInsertId()))
				          {
				          	$lastId=(int)$pdo->lastInsertId();

         /*insertion des elements dans les tables*/


				          		$pdo->beginTransaction();


				          	$insertProjetInfo=$new_crud->insert("projet_description","nom,description,objectif,user_cahier_id")
				                         ->values(":nom,:description,:objectif,:user_cahier_id")
				                         ->executeReq(null,["nom"=>$_POST["nom"],"description"=>$_POST["description"],"objectif"=>$_POST["objectifs"],"user_cahier_id"=>$lastId]);

				$insertHebergementInfo=$new_crud->insert("hebergement_info","nom_de_domaine,hebergeur_name,user_cahier_id")
										                         ->values(":nom_de_domaine,:hebergeur_name,:user_cahier_id")
										                         ->executeReq(null,["nom_de_domaine"=>$_POST["nom_domaine"],"hebergeur_name"=>$_POST["hebergeur_name"],"user_cahier_id"=>$lastId]);

	


$new_crud->insert("site_info","site_type,technologie,nombre_page,langue,site_contenue,url_info,user_cahier_id,image_optimisation,fonctionnalite")
		        ->values(":site_type,:technologie,:nombre_page,:langue,:site_contenue,:url_info,:user_cahier_id,:image_optimisation,:fonctionnalite")
										                         ->executeReq(null,[

										                         							"site_type"=>$_POST["site_type"],
										                         							"technologie"=>$_POST["techno"],
										                         							"nombre_page"=>(int)$_POST["nombre_page"],
										                         							"langue"=>$_POST["langue"][0],
										                         							"site_contenue"=>$_POST["site_contenue"],
										                         							"url_info"=>$_POST["url_info"],
										                         							"user_cahier_id"=>$lastId,
										                         							"image_optimisation"=>$_POST["image_optimisation"],
										                         							"fonctionnalite"=>implode(",",$_POST['fonctionnalite'])
										                         							]);

 $insertDesignInfo=$new_crud->insert("design","design_type,logo_info,police,couleur,user_cahier_id")
										         ->values(":design_type,:logo_info,:police,:couleur,:user_cahier_id")
										         ->executeReq(null,[
										                         	        "design_type"=>$_POST["site_design"],
										                         	        "logo_info"=>$_POST['site_logo'],
										                         	        "police"=>$_POST["site_police"],
										                         	        "couleur"=>$_POST['site_couleur'],
										                         	        "user_cahier_id"=>$lastId
										                         	      ]);	

        $new_crud->insert("visibilite","current_list,pub_status,reseaux_sociaux_info,mots_cle,seo,suivie_analytique,user_cahier_id")
				                         ->values(":current_list,:pub_status,:reseaux_sociaux_info,:mots_cle,:seo,:suivie_analytique,:user_cahier_id")
										                         ->executeReq(null,[
										                         	        "current_list"=>$_POST["concurrent_list"],
										                         	        "pub_status"=>$_POST['site_ads'],
										                         	        "reseaux_sociaux_info"=>$_POST["site_reseau_sociaux"],
										                         	        "mots_cle"=>$_POST['mot_cle'],
										                         	        "seo"=>$_POST['site_seo'],
										                         	        "suivie_analytique"=>$_POST['site_suivie'],
										                         	        "user_cahier_id"=>$lastId
										                         	      ]);


$new_crud->insert("containte","budget,devise,livraison_date,maintenance,info_plus,user_cahier_id")
				 ->values(":budget,:devise,:livraison_date,:maintenance,:info_plus,:user_cahier_id")
										                         ->executeReq(null,[
										                         	        "budget"=>(int)$_POST["budget"],
										                         	        "devise"=>$_POST['devise'][0],
										                         	        "livraison_date"=>$_POST["date_livraison"],
										                         	        "maintenance"=>$_POST['site_maintenance'],
										                         	        "info_plus"=>$_POST['infoPlus'],
										                         	        "user_cahier_id"=>$lastId
										                         	      ]);

										 $pdo->commit();
										 /*redirection de l'utilisateur connecté */
										 header("location:{$router->generate("generateur",["id"=>$user_id])}");

				          }


					}
				
				

			}else
			{
				$errorMessage="Veillez corrigé vos erreurs ";
			}

	}


	
} catch (PDOException $e) {
	echo $e->getMessage();
}


$new_form=new Form($inputErrorTab,true);

 ?>



<form action="" method="POST">
	 <div class="error" >
	 	 <?php if (!empty($errorMessage)): ?>
 	    <h2><?= $errorMessage; ?></h2>
     <?php endif ?>
	 </div>
	 <div  id="navigation" >
  	<section id="navigationContainner" >
	 			<button id="previous" class="nav" >&larr; Precedent </button>
	 			<button id="next" class="nav" >Suivant &rarr;</button>
	 			<div  id="option" >
	 				<?php if (!$save): ?>
	 					<button type="submit">Generé le pdf</button>
	 				<?php endif ?>
	 				
	 				<?php if ($save): ?>
	 					<button type="submit" >Enregistré</button>
	 				<?php endif ?>
	 			</div>

    </section>
  </div>
	<div class="containner" >
	 <div class="div_responsive" >
		<div class="parent" >
			<section class="div_title" >
		     <h1>1. Définition du projet</h1>
	      </section>
	       <!-- inp premet de generé des inputes/textearea -->
	       <section class="formContainner" >
						 <?= $new_form->inp(["type"=>"text",
				 		                    "champName"=>"nom",
				 		                    "label"=>"Le nom de votre projet",
				 		                     "value"=>"ex:alpha"]) ?>
				 		 <?= $new_form->inp(["type"=>"text",
				                            "champName"=>"description",
				                            "label"=>"Description du projet",
				                            "value"=>"ex:site ecommerce..."]) ?>
				        <?= $new_form->inp(["type"=>"text",
                            "champName"=>"objectifs",
                            "label"=>"Objectifs du projet",
                            "value"=>"ex:vente des produits pharmacetique "]) ?>

            </section>               	
          </div>
          <div class="parent" >
						  <section class="div_title">
					       <h1>2. Hébergement et nom(s) de domaine</h1>
				       </section>

				       <section class="formContainner">
									 <?= $new_form->inp(["type"=>"text",
							 		                    "champName"=>"nom_domaine",
							 		                    "label"=>"Nom de domaine",
							 		                     "value"=>"www.essai.bj"]) ?>
							 		 <?= $new_form->inp(["type"=>"text",
				                            "champName"=>"hebergeur_name",
				                            "label"=>"Hébergement envisagé ou déjà souscrit",
				                            "value"=>"ovh,LWS,Kinsta"]) ?>

				               <section class="div_title">
						               <h1>3. Information sur le site web</h1>
					             </section>

					              <section>
									       	<p>Type de site web :</p>
									       	<!-- radio permet de geré des inpute de type radio -->
											       	<?= $new_form->radio([
											       		"name"=>"site_type",
											       		"valueList"=>["Site vitrine","Site portfolio","Site e-commerce","Site catalogue","Blog","Site Gouvernemental","Autre"]

											       	])?>
									       </section>

			            </section>                	
          </div>
    </div>

    <div class="div_responsive" >
          <div class="parent" >
							  <section class="div_title">
						          <h1>3.1. Information sur le site web</h1>
					       </section>
					       <section class="formContainner" >
									      
									       <section>
											       	<p>Technologie à utiliser :</p>
											       	<?= $new_form->radio([
											       		"name"=>"techno",
											       		"valueList"=>["WordPress","Drupal","Joomla","Django","Prestashop","Symfony","Laravel","Wix","Developpement maison"]

											       	])?>

									       </section>
									       <section>
										       	<p>Les contenus du site (textes) seront fournis par :</p>
										       	<?= $new_form->radio([
										       		"name"=>"site_contenue",
										       		"valueList"=>[" le prestataire","nos soins"]

										       	])?>
										       
										       	<p>Avez-vous besoin d'aide pour optimiser vos images ?</p>
										       	<?= $new_form->radio([
										       		"name"=>"image_optimisation",
										       		"valueList"=>["le prestataire se charge d'optimiser les images","nous fournissons des images déjà optimisées"]

										       	])?>
									       	
									       </section>

                  </section>        	
          </div>
            <div class="parent" >
							  <section class="div_title">
						          <h1>3.2. Information sur le site web</h1>
					       </section>
					       <section class="formContainner">
					       	        <section>
									       	<p>La langue principale du site </p>
									       	<?= $new_form->select([
							                            "champName"=>"langue",
							                            "optList"=>["français","anglais","arabe","espagnole"],
							                            "currentOptList"=>isset($_POST['langue'])&&!empty($_POST['langue'])?$_POST['langue']:[],
							                            "multipleSelect"=>false
							                            ]) ?>
									       </section>

									       <section>
									       	   <?= $new_form->inp(["type"=>"text",
							 		                    "champName"=>"url_info",
							 		                    "label"=>"Donnez des exemples (url) de sites que vous appréciez :",
							 		                     "value"=>"A séparer par des virgules"]) ?>
									       </section>

									       <section>
									       	    <?= $new_form->inp(["type"=>"number",
							 		                    "champName"=>"nombre_page",
							 		                    "label"=>"Nombre totale de page",
							 		                     "value"=>"Nombre de page total"]) ?>
									       </section>
					       </section>
					    </div>
		</div>

		   <div class="div_responsive" >
           <div class="parent" >
							  <section class="div_title">
						          <h1>3.3. Information sur le site web</h1>
					       </section>
					       <section class="formContainner" >

									       <section>
									       	<p>Fonctionnalités désirées</p>

									       	<!-- permet de generé le select -->
									       	<?= $new_form->select([
							                            "champName"=>"fonctionnalite",
							                            "optList"=>["site multilingue","formulaire simple","forum","livre d'or","flux instagram","Newsletter","Avis clients","temoignage","formulaire de don","partie réservé au membre"],
							                            "currentOptList"=>isset($_POST['fonnctionnalite'])&&!empty($_POST['fonnctionnalite'])?$_POST['fonnctionnalite']:[],
							                            "error"=>isset($errorTab["fonctionnalite"])?$errorTab["fonctionnalite"]:null

							                            ]) ?>
									       </section>

									       <section class="div_title">
					                 <h1>4. Le design</h1>
				                 </section>

				                   <section>
										       	<p>Le logo du site</p>
										       		<?= $new_form->radio([
										       		"name"=>"site_logo",
										       		"valueList"=>["nous désirons une création sur mesure","nous en possédons un mais nous souhaitons l'améliorer","nous vous fournirons les fichiers","nous ne souhaitons pas le faire appaître sur le site"]

									       	                   ])?>
						               </section>


						             <section>
										       	<p>police</p>
										       		<?= $new_form->radio([
													       		"name"=>"site_police",
													       		"valueList"=>["nous souhaitons des suggestions","nous les avons choisies"]
													       	     ])?>
							       	
						             </section>

					       </section>
					  </div>


           <div class="parent" >

		          	<section class="div_title">
					           <h1>4.1. Le design</h1>
				       </section>
				       <section class="formContainner" >
				       	    
						       <section>
								       	<p>couleur</p>
								       	<?= $new_form->radio([
								       		"name"=>"site_couleur",
								       		"valueList"=>["nous souhaitons des suggestions","nous souhaitons utiliser nos propres couleurs"]

								       	     ])?>
						        </section>
						       <section>
						       	<p>Le design global</p>
						       	<?= $new_form->radio([
						       		"name"=>"site_design",
						       		"valueList"=>["nous désirons la création d'un design sur mesure","nous souhaitons choisir un design parmi des modèles existants","nous souhaitons adapter le design parmi des modèles existants"]

						       	     ])?>
						       </section>

						        <section class="div_title" >
			     			        <h1>5. La visibilité</h1>
		                </section>

		                <section>
						       	   <?= $new_form->inp(["type"=>"text",
				 		                    "champName"=>"concurrent_list",
				 		                    "label"=>"Quels sont les principaux sites concurrents ?",
			 		                     "value"=>"Lister l'URL des sites de vos principaux à separé par des virgules"]) ?>
				            </section>

				       </section>

          </div>
   </div>

   	<div class="div_responsive" >
          <div class="parent" >

          	<section class="div_title" >
			     			<h1>5.1. La visibilité</h1>
		       </section>

		       	<section class="formContainner" >
				        
				       <section>
				       	   <?= $new_form->inp(["type"=>"text",
		 		                    "champName"=>"mot_cle",
		 		                    "label"=>"Quels sont les mots clés principaux sur lesquels vous désirez être référencé ?",
		 		                     "value"=>"list des mots clé"]) ?>
				       </section>

				        <section>
				       	<p>Annonces publicitaires Google Ads</p>
				       	<?= $new_form->radio([
				       		"name"=>"site_ads",
				       		"valueList"=>[" nous souhaitons être accompagnés dans la création d'annonces publicitaires Google Ads","nous souhaiterions déléguer la gestion d'annonces publicitaires Google Ads","nous n'envisageons pas d'utiliser les services de Google Ads"]

				       	     ])?>
				       	
				       
				       </section>

				       <section>
							       	<p>Avez-vous besoin d'aide pour la création de vos réseaux sociaux ?</p>
							       	<?= $new_form->radio([
							       		"name"=>"site_reseau_sociaux",
							       		"valueList"=>["nous avons besoin que le prestataire s'occupe de la création des comptes de réseaux sociaux ","nous nous occupons de tout"]

							       	     ])?>
				       	
				        </section>

				       
          </section>
         </div>

          <div class="parent" >

	          	<section class="div_title" >
				     			<h1>5.2. La visibilité</h1>
			       </section>

			       	<section class="formContainner" >
			       			

				       <section>
				       	<p>Concernant le référencement naturel (SEO)</p>
				       	<?= $new_form->radio([
				       		"name"=>"site_seo",
				       		"valueList"=>["nous avons besoin d'une stratégie SEO de départ","nous souhaitons nous charger de l'optimisation SEO"]

				       	     ])?>
				       	
				       
				       </section>

				       <section>
				       	<p>Concernant le suivi analytique</p>
				       	<?= $new_form->radio([
				       		"name"=>"site_suivie",
				       		"valueList"=>[" nous souhaitons pouvoir suivre le trafic du site de manière basique","nous souhaitons pouvoir suivre le trafic du site de manière approfondie","nous n'avons pas besoin de suivre le trafic du site"]

				       	     ])?>
				       	
				       </section>


			       	</section>
		       </div>
  </div>

  	<div class="div_responsive" >
          <div class="parent" >
          	<section class="div_title" >
			          <h1>6. Les contraintes</h1>
		       </section>
		       <section class="formContainner" >

		       	    <section>

				       	<?= $new_form->inp(["type"=>"date",
		 		                    "champName"=>"date_livraison",
		 		                    "label"=>"À quelle date souhaitez-vous la livraison du site ?",
		 		                     "value"=>""]) ?>
				       	
				       </section>

				       <section id="budget_devise" >
				       	<?= $new_form->inp(["type"=>"number",
		 		                    "champName"=>"budget",
		 		                    "label"=>"Quel est votre budget ?",
		 		                     "value"=>""]) ?>
		 		          <?= $new_form->select([
		                            "champName"=>"devise",
		                            "optList"=>["fcfa","euro","dollar"],
		                            "currentOptList"=>isset($_POST['devise'])&&!empty($_POST['devise'])?$_POST['devise']:[],
		                            "multipleSelect"=>false
		                            ]) ?>
				       </section>

				       <section>

				       		<p>Qui doit maintenir le site (sauvegarde, mises à jour, sécurité, etc.) ? </p>
				       		<?= $new_form->radio([
				       		"name"=>"site_maintenance",
				       		"valueList"=>["Le prestataire s'occupera de la maintenance du site durant une période définie","Nous prenons en charge la maintenance du site"]

				       	     ])?>
				       		
				       </section>

				   </section>
		   </div>

		   <div class="parent" >
          	<section class="div_title" >
			          <h1>7. Autres information</h1>
		       </section>
		       <section class="formContainner essai" >
		       	    <section>

				       	   <?= $new_form->inp(["type"=>"textarea",
		 		                    "champName"=>"infoPlus",
		 		                    "label"=>"Info supplémentaire",
		 		                     "value"=>"entré des info supplémentaire dont vous avez besoin"]) ?>
				       	
				       </section>

		       </section>
		   </div>

		</div>

  </div>
 

</form>


