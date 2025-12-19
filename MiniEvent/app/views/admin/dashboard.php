<h2>Dashboard Admin</h2>
<p><a href="/?route=admin_logout">Déconnexion</a></p>

<p><a href="/?route=admin_create_event">Créer un événement</a></p>

<table border="1" cellpadding="6" cellspacing="0">
  <thead>
    <tr><th>ID</th><th>Titre</th><th>Date</th><th>Actions</th></tr>
  </thead>
  <tbody>
    <?php foreach ($events as $ev): ?>
      <tr>
        <td><?= $ev['id'] ?></td>
        <td><?= htmlspecialchars($ev['title']) ?></td>
        <td><?= htmlspecialchars($ev['date']) ?></td>
        <td>
          <a href="/?route=admin_edit_event&id=<?= $ev['id'] ?>">Éditer</a> |
          <a href="/?route=admin_delete_event&id=<?= $ev['id'] ?>" onclick="return confirm('Supprimer ?')">Supprimer</a> |
          <a href="/?route=admin_reservations&id=<?= $ev['id'] ?>">Réservations</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
