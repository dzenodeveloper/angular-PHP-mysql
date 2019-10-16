<?php
require 'db.php';
$id = $_GET['id'];
$sql = 'SELECT * FROM people WHERE username=:username';
$statement = $connection->prepare($sql);
$statement->execute([':id' => $id ]);
$person = $statement->fetch(PDO::FETCH_OBJ);
if (isset ($_POST['Ime'])  && isset($_POST['Prezime']) && isset($_POST['PostanskiBR'])&& isset($_POST['Grad']) && isset($_POST['Password']) && isset($_POST['Password'])) {
  $Ime = $_POST['$Ime'];
  $Prezime = $_POST['$Prezime'];
  $PostasnkiBR = $_POST['$PostasnkiBR'];
  $Grad = $_POST['$Grad'];
  $Password = $_POST['$Password'];
  $Password = $_POST['$Password'];
  $sql = 'UPDATE people SET Ime=:Ime, Prezime=:Prezime,PostanskiBR=:PostanskiBR,Grad=:Grad,Password=:Password,assword=:Password, WHERE username=:username';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':Ime' => $Ime, ':Prezime' => $Prezime, ':PostanskiBR' => $PostasnkiBR,':Grad' => $Grad':Password' => $Password':Password' => $Password':username' => $username])) {
    header("Location: /");
  }



}


 ?>
<?php require 'header.php'; ?>
<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Update person</h2>
    </div>
    <div class="card-body">
      <?php if(!empty($message)): ?>
        <div class="alert alert-success">
          <?= $message; ?>
        </div>
      <?php endif; ?>
      <form method="post">
        <div class="form-group">
          <label for="Ime">Ime</label>
          <input value="<?= $person->Ime; ?>" type="text" name="Ime" id="Ime" class="form-control">
        </div>
        <div class="form-group">
          <label for="Prezime">Prezime</label>
          <input type="text" value="<?= $person->Prezime; ?>" name="Prezime" id="Prezime" class="form-control">
        </div>
        <div class="form-group">
          <label for="PostanskiBR">PostanskiBR</label>
          <input type="text" value="<?= $person->PostanskiBR; ?>" name="PostanskiBR" id="PostanskiBR" class="form-control">
        </div>
        <div class="form-group">
          <label for="Grad">Grad</label>
          <input type="text" value="<?= $person->Grad; ?>" name="Grad" id="Grad" class="form-control">
        </div>
        <div class="form-group">
          <label for="Password">Password</label>
          <input type="password" value="<?= $person->Password; ?>" name="Password" id="Password" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Password</label>
            <input type="password" value="<?= $person->Password; ?>" name="Password" id="Password" class="form-control">
          </div>
          <div class="form-group">

          <button type="submit" class="btn btn-info">Update person</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php require 'footer.php'; ?>
