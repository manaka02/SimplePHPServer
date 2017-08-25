
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Send notification</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Send notification to someone</h2>
  <form action="init.php" method = "POST">
    <div class="form-group">
      <label for="email">Nom de la personne:</label>
      <input type="text" class="form-control"  placeholder="Enter username" name="username" required>
    </div>
    <div class="form-group">
      <label for="pwd">Message:</label>
        <input type="text" class="form-control" placeholder="token" name="token" required>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>

</body>
</html>
