<?php
require_once 'functions.php';

//Подключение к базе данных
$db = connect_db();

if (!empty($_GET['isbn']) || !empty($_GET['name']) || !empty($_GET['author'])) {
		$sql = "SELECT * FROM books WHERE isbn LIKE ? AND name LIKE ? AND author LIKE ?";
		$query = $db->prepare($sql);
		$query->execute(["%{$_GET['isbn']}%", "%{$_GET['name']}%","%{$_GET['author']}%"]);
} else {
		$sql = "SELECT * FROM books";
        $query = $db->prepare($sql);
        $query->execute();
}

//проверка на ошибки
if($query->errorCode() != PDO::ERR_NONE){
		$info = $query->errorInfo();
		echo implode('<br>', $info);
		exit();
}

$books = $query->fetchAll();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="GET">
        <input placeholder="Название" name="name" value="<?= $_GET? $_GET['name'] : "" ?>">
        <input placeholder="Автор" name="author" value="<?= $_GET? $_GET['author']: "" ?>">
        <input placeholder="ISBN" name="isbn" value="<?= $_GET? $_GET['isbn']: "" ?>">
        <input type="submit">
    </form>
    <table>
        <thead>
            <tr>
                <th>Название</th>
                <th>Автор</th>
                <th>Год выпуска</th>
                <th>Жанр</th>
                <th>ISBN</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($books as $one) { ?>
            <tr>
                <td><?= $one['name'] ?></td>
                <td><?= $one['author'] ?></td>
                <td><?= $one['year'] ?></td>
                <td><?= $one['genre'] ?></td>
                <td><?= $one['isbn'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
        </table>
</body>
</html>
