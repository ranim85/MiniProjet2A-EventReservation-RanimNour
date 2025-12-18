<h2>Liste des événements</h2>

<?php if (empty($events)): ?>
  <p>Aucun événement pour le moment.</p>
<?php else: ?>
  <div class="events">
    <?php foreach ($events as $e): ?>
      <article class="event-card">
        <h3><?= htmlspecialchars($e['title']) ?></h3>
        <p><?= nl2br(htmlspecialchars(substr($e['description'],0,200))) ?>...</p>
        <p><strong>Date:</strong> <?= htmlspecialchars($e['date']) ?></p>
        <p><strong>Lieu:</strong> <?= htmlspecialchars($e['location']) ?></p>
        <a href="/?route=event_details&id=<?= $e['id'] ?>">Détails / Réserver</a>
      </article>
    <?php endforeach; ?>
  </div>
<?php endif; ?>