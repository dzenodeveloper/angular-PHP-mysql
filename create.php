<?php
require 'db.php';
$message = '';
if (isset ($_POST['username'])  && isset($_POST['password'])  && isset($_POST['Ime']) && isset($_POST['Prezime']) && isset($_POST['PostanskiBR']) && isset($_POST['Grad'])) {
  $username = $_POST['username'];
  $password= $_POST['password'];
  $Ime = $_POST['Ime'];
  $Prezime = $_POST['Prezime'];
  $PostasnkiBR = $_POST['PostanskiBR'];
  $Grad = $_POST['Grad'];
  $sql = 'INSERT INTO people(username, password,Ime,Prezime,PostanskiBR,Grad) VALUES(:username, :password, :Ime, :Prezime, :PostanskiBR, :Grad)';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':username' => $username, ':password' => $password':Ime' => $Ime])':Prezime' => $Prezime)':PostanskiBR' => $PostasnkiBR':Grad' => $Grad {
    $message = 'data inserted successfully';
  }



}


 ?>
<?php require 'header.php'; ?>
<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Create a person</h2>
    </div>
    <div class="card-body">
      <?php if(!empty($message)): ?>
        <div class="alert alert-success">
          <?= $message; ?>
        </div>
      <?php endif; ?>
      <form method="post">
        <div class="form-group">
          <div class="form-group">
            <label for="email">username</label>
            <input type="email" name="email" id="email" class="form-control">
          </div>
          <div class="form-group">
            <label for="email">Password</label>
            <input type="email" name="email" id="email" class="form-control">
          </div>
          <label for="name">Ime</label>
          <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
          <label for="email">Prezime</label>
          <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
          <label for="email">Adresa</label>
          <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
          <label for="email">PostanskiBR</label>
          <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
          <label for="email">Grad</label>
          <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-info">Create a person</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php require 'footer.php'; ?>
