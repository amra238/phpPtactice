<?php
$name = $age = $email = '';
$errors = [
    'name' => '',
    'age' => '',
    'email' => ''
];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $age = $_POST['age'] ?? '';
    $email = $_POST['email'] ?? '';

    if ($name === '') {
        $errors['name'] = 'Имя обязательно для заполнения';
    }

    if ($age === '') {
        $errors['age'] = 'Возраст обязателен для заполнения';
    } elseif (!is_int((int)$age) || $age < 1 || $age > 120) {
        $errors['age'] = 'Возраст должен быть целым числом от 1 до 120';
    }

    if ($email === '') {
        $errors['email'] = 'Email обязателен для заполнения';
    } elseif (strpos($email, '@') === false) {
        $errors['email'] = 'Email должен содержать символ @';
    }

    if (empty($errors['name']) && empty($errors['age']) && empty($errors['email'])) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма регистрации</title>
</head>

<body>

    <?php if ($success): ?>
        <div">
            Добро пожаловать, <?= htmlspecialchars($name) ?>! Ваш возраст: <?= htmlspecialchars($age) ?>, email: <?= htmlspecialchars($email) ?>
            </div>
        <?php else: ?>
            <form method="POST" action="">
                <div>
                    <label for="name">Имя:</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>">
                    <?php if ($errors['name']): ?>
                        <div style="color: red"><?= $errors['name'] ?></div>
                    <?php endif; ?>
                </div>

                <div>
                    <label for=" age">Возраст:</label>
                    <input type="text" id="age" name="age" value="<?= htmlspecialchars($age) ?>">
                    <?php if ($errors['age']): ?>
                        <div style="color: red"><?= $errors['age'] ?></div>
                    <?php endif; ?>
                </div>

                <div>
                    <label for=" email">Email:</label>
                    <input type="text" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
                    <?php if ($errors['email']): ?>
                        <div style="color: red"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit">Отправить</button>
            </form>
        <?php endif; ?>

</body>

</html>