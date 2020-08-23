<?php
  //var_dump($secteurs);
?>
  <h1><?= $titre ?></h1>
  <table class="table">
        <thead>
          <tr>
            <th scope="col">Secteur</th>
            <th scope="col">Code Liaison</th>
            <th scope="col">Distance en milles marin</th>
            <th scope="col">Port de départ</th>
            <th scope="col">Port d’arrivée</th>
          </tr>
        </thead>
        <tbody>
      
    <?php
    foreach ($secteurs as $secteur){
      $i = 1; // itérateur pour différentier la première ligne
      $nbLiaisons = count($secteur['liaisons']);
    ?> 
          <?php
          foreach ($secteur['liaisons'] as $liaison){
            if ($i==1){
            ?>
              <tr>
                <th scope="row" rowspan="<?= $nbLiaisons ?>"><?= $secteur['nom'] ?></td>
            <?php } else { ?>
              <tr>
            <?php } ?>

                <td><?= $liaison['code']?></td>
                <td><?= $liaison['distance']?></td>
                <td><?= $liaison['portDepart']?></td>
                <td><?= $liaison['portArrivee']?></td>
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
