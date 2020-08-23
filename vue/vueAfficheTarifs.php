<?php
  //var_dump($liaisons);
  
  //var_dump($tarifs);
  //var_dump($categoriesTypes);
  
  //var_dump($categories);
  //var_dump($periodes);
  //var_dump($tarifsLiaisons);
?>
  <h1><?= $titre ?></h1>
  <?php foreach($liaisons as $liaison){
  ?>
    <h3>Liaison <?= $liaison['code'] ?> : <?= $liaison['portDepart'] ?> - <?= $liaison['portArrivee'] ?> </h3>
    <table class="table display">
          <thead>
            <tr>
              <th rowspan="2" scope="col">Catégorie</th>
              <th rowspan="2" scope="col">Type</th>
              <th colspan="<?= count($periodes) ?>" scope="col">Période</th>
            </tr>
            <tr>
              <?php 
              foreach ($periodes as $periode){
              ?>
                <th scope="col"><?= $periode['dateDeb'] ?><br/><?= $periode['dateFin'] ?></th>
              <?php
              }
              ?>
            </tr>

          </thead>
          <tbody>
        
          <?php
          foreach ($categoriesTypes as $categoriesType){
            $i = 1; // itérateur pour différentier la première ligne
            $nbTypes = count($categoriesType['types']);
          ?> 
                <?php
                foreach ($categoriesType['types'] as $type){
                  if ($i==1){
                  ?>
                    <tr>
                      <th scope="row" rowspan="<?= $nbTypes ?>"><?= $categoriesType['lettre'] ?> - <?= $categoriesType['libelle'] ?></td>
                  <?php } else { ?>
                    <tr>
                  <?php } 
                  ?>

                      <th scope="row"><?= $type['lettreCategorie'] ?><?= $type['num'] ?> - <?= $type['libelle'] ?></td>

                      <?php
                      foreach ($periodes as $periode){
                        $montant = "-";
                        if (isset($tarifs[$liaison['code']][$type['lettreCategorie']][$type['num']][$periode['dateDeb']])){
                          $montant = $tarifs[$liaison['code']][$type['lettreCategorie']][$type['num']][$periode['dateDeb']];
                        }
                      ?>
                          <td><?= $montant ?></td>
                      <?php
                      }
                      ?>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>

                <?php
                $i++;
                }
                ?>

          <?php
          }
          ?>

      </tbody>
    </table>
  <?php } ?>

