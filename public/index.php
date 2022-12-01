<?php 

use App\Router;

require "../vendor/autoload.php";

$router=new Router();

$router->map("/","./vu/home.php","home")
       ->map("/formulaire","./vu/formulaire.php","formulaire")
       ->map("/formulaire?direct=0&user=[i:id]","./vu/formulaire.php","indirectformulaire")
       ->map("/inscription","./vu/inscription.php","inscription")
       ->map("/connection","./vu/connection.php","connection")
       ->map("/deconnection","./vu/deconnection.php",'deconnection')
       ->mapGET("/generateur/user=[i:id]","./vu/cahier_list.php","generateur")
       ->map("/save/user=[i:id]","./vu/traitement.php","traitement")
       ->map("/modification/user-[i:id]/cahier-[i:cahier_id]","./vu/modification.php","modification")
       ->map("/delete/user-[i:id]/cahier-[i:cahier_id]","./vu/delete.php","delete")
       ->map("/generatePdf/user=[i:id]/cahier-[i:cahier_id]","./vu/traitement.php","pdf")
       ->match();




 ?>
