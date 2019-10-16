<?php
require 'db.php';
$sql = 'SELECT * FROM people';
$statement = $connection->prepare($sql);
$statement->execute();
$people = $statement->fetchAll(PDO::FETCH_OBJ);
 ?>
<?php require 'header.php'; ?>
<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>All </h2>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <tr>
          <th>Ime</th>
          <th>Prezime</th>
          <th>Adresa</th>
          <th>PostanskiBR</th>
          <th>Grad</th>
        </tr>
        <?php foreach($people as $person): ?>
          <tr>
            <td><?= $person->Ime; ?></td>
            <td><?= $person->Prezime; ?></td>
            <td><?= $person->Adresa; ?></td>
            <td><?= $person->PostanskiBR; ?></td>
            <td><?= $person->Grad; ?></td>
            <td>
              <a href="edit.php?id=<?= $person->id ?>" class="btn btn-info">Edit</a>
              <a onclick="return confirm('Are you sure you want to delete this entry?')" href="delete.php?id=<?= $person->id ?>" class='btn btn-danger'>Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</div>
<?php require 'footer.php'; ?>
