<?php
$user = 'u67278';
$pass = '7210431';

try {
    $db = new PDO('mysql:host=localhost', $user, $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $db->exec("CREATE DATABASE IF NOT EXISTS u67278");

    $db->exec("USE u67278");

    $db->exec("CREATE TABLE IF NOT EXISTS application (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(255) NOT NULL,
        phone VARCHAR(15) NOT NULL,
        email VARCHAR(255) NOT NULL,
        dob DATE NOT NULL,
        gender ENUM('male', 'female') NOT NULL,
        bio TEXT NOT NULL,
        contract_agreed TINYINT(1) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS programming_language (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    )");

    $stmt = $db->query("SELECT COUNT(*) FROM programming_language");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        $db->exec("INSERT INTO programming_language (name) VALUES 
            ('Pascal'),
            ('C'),
            ('C++'),
            ('JavaScript'),
            ('PHP'),
            ('Python'),
            ('Java'),
            ('Haskel'),
            ('Clojure'),
            ('Prolog'),
            ('Scala')
        ");
    }

    $db->exec("CREATE TABLE IF NOT EXISTS application_programming_language (
        application_id INT(11),
        language_id INT(11),
        FOREIGN KEY (application_id) REFERENCES application(id),
        FOREIGN KEY (language_id) REFERENCES programming_language(id),
        PRIMARY KEY (application_id, language_id)
    )");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $errors = FALSE;

        if (empty($_POST['fullname']) || !preg_match('/^[a-zA-Zа-яА-ЯЁё\s]+$/u', $_POST['fullname'])) {
            header('Location: index.php?errors=Введите корректное ФИО');
            $errors = TRUE;
            exit(); 
        }

        if (empty($_POST['phone']) || !preg_match('/^[0-9+\s]+$/', $_POST['phone'])) {
            header('Location: index.php?errors=Введите корректный номер телефона.');    
            $errors = TRUE;
            exit(); 
        }

        if (empty($_POST['gender']) || ($_POST['gender'] != 'male' && $_POST['gender'] != 'female')) {
            header('Location: index.php?errors=Выберите корректный пол');    
            $errors = TRUE;
            exit(); 
        }

        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            header('Location: index.php?errors=Заполните корректный e-mail.');    
            $errors = TRUE;
            exit(); 
        }

        if (empty($_POST['dob'])) {
            header('Location: index.php?errors=Заполните дату рождения.');    
            $errors = TRUE;
            exit(); 
        }

        if (empty($_POST['favLanguage'])) {
            header('Location: index.php?errors=Выберите хотя бы один язык программирования.');    
            $errors = TRUE;
            exit(); 
        }

        if (empty($_POST['bio'])) {
            header('Location: index.php?errors=Заполните биографию');    
            $errors = TRUE;
            exit(); 
        }

        if (empty($_POST['contract'])) {
            header('Location: index.php?errors=Необходимо согласиться с контрактом');    
            $errors = TRUE;
        }

        if ($errors) {
            exit();
        }

        $stmt = $db->prepare("INSERT INTO application (fullname, phone, email, dob, gender, bio, contract_agreed) VALUES (:fullname, :phone, :email, :dob, :gender, :bio, :contract_agreed)");
        $stmt->bindParam(':fullname', $_POST['fullname']);
        $stmt->bindParam(':phone', $_POST['phone']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':dob', $_POST['dob']);
        $stmt->bindParam(':gender', $_POST['gender']);
        $stmt->bindParam(':bio', $_POST['bio']);
        $contract_agreed = isset($_POST['contract']) ? 1 : 0;
        $stmt->bindParam(':contract_agreed', $contract_agreed);
        $stmt->execute();

        $applicationId = $db->lastInsertId();

        foreach ($_POST['favLanguage'] as $languageId) {
            $stmt = $db->prepare("INSERT INTO application_programming_language (application_id, language_id) VALUES (:application_id, :language_id)");
            $stmt->bindParam(':application_id', $applicationId);
            $stmt->bindParam(':language_id', $languageId);
            $stmt->execute();
        }
        header('Location: index.php?save=1');
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
