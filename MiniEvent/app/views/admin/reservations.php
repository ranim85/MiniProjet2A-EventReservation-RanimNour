<h2>Réservations pour l'événement</h2>
<table border="1" cellpadding="6">
  <thead><tr><th>ID</th><th>Nom</th><th>Email</th><th>Téléphone</th><th>Date</th></tr></thead>
  <tbody>
    <?php foreach ($reservations as $r): ?>
      <tr>
        <td><?= $r['id'] ?></td>
        <td><?= htmlspecialchars($r['name']) ?></td>
        <td><?= htmlspecialchars($r['email']) ?></td>
        <td><?= htmlspecialchars($r['phone']) ?></td>
        <td><?= $r['created_at'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
