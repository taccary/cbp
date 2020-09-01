<?php
  //var_dump($liaisons);
  //var_dump($LiaisonSelectionnee);
  //var_dump($traversees)
  //var_dump($places);
?>


<h1><?= $titre ?></h1>
<div class="row">
  <div class="list-group col-2" >
  <?php foreach ($secteurs as $secteur){
      $active = "";
      if (isset($secteurSelectionne)){
          if ($secteurSelectionne['id'] == $secteur['id']){
              $active = "active";
          }
      }
      
  ?>
      <a href="?action=traversees&secteur=<?=$secteur['id']?>" class="list-group-item list-group-item-action <?=$active?>">
      <?=$secteur['nom']?>
    </a>
  <?php
  }
  ?>

  </div>

  <div class="col">
    <?php
      if (!isset($_GET['secteur'])){
      ?>
        <p>Selectionnez un secteur dans le menu gauche </p>
      <?php
      } else {
      ?>
        <p>Sélectionner la liaison, et la date souhaitée </p>
  
          <form method="POST" action="?action=traversees&secteur=<?= $secteurSelectionne['id'] ?>">
            <div class="row">
              <div class="col">
                <select class="form-control" id="liaison" name="liaison">
                  <?php 
                    foreach ($liaisons as $liaison){
                      $selected ="";
                      if (isset($LiaisonSelectionnee)){
                        if ($LiaisonSelectionnee['code'] == $liaison['code']){
                            $selected = "selected";
                        }
                      } 
                      ?>
                      <option value="<?= $liaison['code']?>" <?= $selected ?>><?= $liaison['portDepart']." - ".$liaison['portArrivee'] ?></option>
                    <?php
                    }
                  ?>
                  </select>
              </div>
              <div class="col">
                <input type="date" name="date" id="date" value="<?= $dateTraversee ?>" />
              </div>
              <button type="submit" class="btn btn-primary">Afficher les traversées</button>
            </div>
          </form>

      <?php
      }
    ?>
  


      <?php
        if (isset($_POST['liaison']) && isset($_POST['date'])){
        ?>
          <?= $LiaisonSelectionnee['portDepart']." - ".$LiaisonSelectionnee['portArrivee'] ?>. <br/> 

          <p>Traversées pour le <?= $dateTraversee ?>. Sélectionner la traversée souhaitée :</p>
          <form method="POST" action="?action=reservation">
          <table class="table display">
          <thead>
            <tr>
              <th scope="col" colspan="3">Traversées</th>
              <th colspan="<?= count($categories) ?>" scope="col">Places disponibles par bateau </th>
              <th></th>
            </tr>
            <tr>
              <th scope="col">N°</th>
              <th scope="col">Heure</th>
              <th scope="col">Bateau</th>
              <?php 
              foreach ($categories as $categorie){
              ?>
                <th scope="col">nombre<br/> <?= $categorie['libelle'] ?></th>
              <?php
              }
              ?>
              <th></th>
            </tr>
          </thead>
          <tbody>
        
          <?php
          foreach ($traversees as $traversee){
          ?> 
            <tr>
              <td><?= $traversee['num'] ?></td>
              <td><?= $traversee['heure'] ?></td>
              <td><?= $traversee['nom'] ?></td>
              <?php
              foreach ($categories as $categorie){
                $placesDispo = $placesCapacite[$traversee['num']][$categorie['lettre']];
                if (isset($placesReservees[$traversee['num']][$categorie['lettre']])){
                  $placesDispo = $placesCapacite[$traversee['num']][$categorie['lettre']] - $placesReservees[$traversee['num']][$categorie['lettre']];
                }

              ?>
                <td><?= $placesDispo ?></td>
              <?php
              }
              ?>
              <td><input type="radio" id="traversee" name="traversee" value="<?= $traversee['num'] ?>"></td>
            </tr>
          <?php
          }
          ?>

          </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Réserver cette traversée</button>
        </form>

      <?php
        }
      ?>
      
  </div>

</div>