<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form</title>

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container border rounded  mt-4 mb-4" style="max-width:500px; padding: 20px;">
    <h2>Регистрационная форма</h2>
    <form action="action.php" method="POST">
      <div class="form-group">
        <label for="fullName">ФИО:</label>
        <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Введите ФИО" >
      </div>
      <div class="form-group">
        <label for="phone">Телефон:</label>
        <input type="tel" name="phone" class="form-control" id="phone" placeholder="Введите номер телефона" >
      </div>
      <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="Введите e-mail" >
      </div>
      <div class="form-group">
        <label for="dob">Дата рождения:</label>
        <input type="date" class="form-control" name="dob" id="dob" >
      </div>
      <div class="form-group">
        <label>Пол:</label><br>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="gender" id="male" value="male" >
          <label class="form-check-label" for="male">Мужской</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="gender" id="female" value="female" >
          <label class="form-check-label" for="female">Женский</label>
        </div>
      </div>
      <div class="form-group">
        <label for="favLanguage">Любимый язык программирования:</label>
        <select class="form-control" id="favLanguage" name="favLanguage[]" multiple >
          <option value="1">Pascal</option>
          <option value="2">C</option>
          <option value="3">C++</option>
          <option value="4">JavaScript</option>
          <option value="5">PHP</option>
          <option value="6">Python</option>
          <option value="7">Java</option>
          <option value="8">Haskel</option>
          <option value="9">Clojure</option>
          <option value="10">Prolog</option>
          <option value="11">Scala</option>
        </select>
      </div>
      <div class="form-group">
        <label for="bio">Биография:</label>
        <textarea name="bio" class="form-control" id="bio" rows="4" placeholder="Введите вашу биографию" ></textarea>
      </div>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" name="contract" id="contract" >
        <label class="form-check-label" for="contract">С контрактом ознакомлен(а)</label>
      </div>
      <button type="submit" class="btn btn-primary mt-3">Сохранить</button>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['errors'])) {
        echo "<script>alert('" . $_GET['errors'] . "');</script>";
    }
    if (!empty($_GET['save'])) {
        echo "<script>alert('Спасибо, ваши данные сохранены!');</script>";
    }
}
?>

</body>
</html>
