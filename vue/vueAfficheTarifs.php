<?php
  //var_dump($lesTarifs);
?>
  <form method="post" action="index.php?action=tarifs">
      <div>
          <label for="idPeriode">Choix d'une periode :</label>
          <select name="idPeriode">
          <option value="">--sélectionner une periode--</option>
        <?php
        foreach ($lesPeriodes as $unePeriode) {
          $selected = "";
          if ((isset($_POST['idPeriode'])) && ($_POST['idPeriode']==$unePeriode['idPeriode'])) {
            $selected = "selected";
          }
          echo '<option value="'.$unePeriode['idPeriode'].'" '.$selected.'>'.$unePeriode['libellePeriode'].'</option>';
        }
        ?>
        </select>
      </div>
    <input type="submit" value="Afficher les tarifs" title="Afficher les tarifs" />
  </form>

<br>

  <h1><?= $titre ?></h1>
    	<table id="myTable" class="table table-bordered table-striped">
		<thead>
			<th>Catégorie</th>
			<th>Type de billet</th>
			<th>tarif</th>
			<th>Période</th>
		</thead>
		<tbody>
			<?php
				foreach ($lesTarifs as $unTarif){
				?>
					<tr>
						<td><?= $unTarif['categorie'] ?></td>
						<td><?= $unTarif['type'] ?></td>
						<td><?= $unTarif['tarif'] ?></td>
						<td><?= $unTarif['periode'] ?></td>
					</tr>
				<?php
				}
			?>
		</tbody>
	</table>

