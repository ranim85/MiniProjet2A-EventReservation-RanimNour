<?php if (!$event) { echo "<p>Événement non trouvé</p>"; exit; } ?>

<h2>Réservation — <?= htmlspecialchars($event['title']) ?></h2>

<form method="post" action="/?route=reserve&id=<?= $event['id'] ?>">
  <label>Nom<br><input type="text" name="name" required></label><br>
  <label>Email<br><input type="email" name="email" required></label><br>
  <label>Téléphone<br><input type="text" name="phone"></label><br>
  <button type="submit">Confirmer la réservation</button>
</form>