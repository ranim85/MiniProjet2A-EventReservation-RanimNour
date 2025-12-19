<?php
$editing = !empty($event);
?>
<h2><?= $editing ? 'Éditer' : 'Créer' ?> un événement</h2>

<form method="post" action="">
  <label>Titre<br><input type="text" name="title" value="<?= $editing ? htmlspecialchars($event['title']) : '' ?>" required></label><br>
  <label>Description<br><textarea name="description" required><?= $editing ? htmlspecialchars($event['description']) : '' ?></textarea></label><br>
  <label>Date (YYYY-MM-DD HH:MM:SS)<br><input type="text" name="date" value="<?= $editing ? htmlspecialchars($event['date']) : '' ?>"></label><br>
  <label>Lieu<br><input type="text" name="location" value="<?= $editing ? htmlspecialchars($event['location']) : '' ?>"></label><br>
  <label>Places<br><input type="number" name="seats" value="<?= $editing ? htmlspecialchars($event['seats']) : 0 ?>"></label><br>
  <label>Image URL<br><input type="text" name="image" value="<?= $editing ? htmlspecialchars($event['image']) : '' ?>"></label><br>
  <button type="submit"><?= $editing ? 'Mettre à jour' : 'Créer' ?></button>
</form>
