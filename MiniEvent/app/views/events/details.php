<?php if (!$event) { echo "<p>Événement non trouvé</p>"; exit; } ?>

<article class="event-detail">
  <h2><?= htmlspecialchars($event['title']) ?></h2>
  <?php if (!empty($event['image'])): ?>
    <img src="<?= htmlspecialchars($event['image']) ?>" alt="<?= htmlspecialchars($event['title']) ?>" style="max-width:300px" />
  <?php endif; ?>
  <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
  <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
  <p><strong>Lieu:</strong> <?= htmlspecialchars($event['location']) ?></p>
  <p><strong>Places:</strong> <?= htmlspecialchars($event['seats']) ?></p>

  <a href="/?route=reserve&id=<?= $event['id'] ?>">Réserver</a>
</article>