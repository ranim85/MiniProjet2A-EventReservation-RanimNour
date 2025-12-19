<h2>Admin Login</h2>
<?php if (!empty($error)): ?>
  <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<form method="post" action="/?route=admin_login">
  <label>Username<br><input type="text" name="username" required></label><br>
  <label>Password<br><input type="password" name="password" required></label><br>
  <button type="submit">Se connecter</button>
</form>
