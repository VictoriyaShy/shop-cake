<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🧁 Империя вкуса 🧁 Торты-Пироженные-Печенье-Выпечка 🧁 Доставка Калининград и область 🧁</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body >
    <div class="sec">



<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $address = $_POST['address']; // Новое поле адреса
    $phone = $_POST['phone']; // Новое поле телефона
    $comment = $_POST['comment']; // Новое поле комментария

    $name = $_POST['name']; // Новое поле Наименование
    $city = $_POST['city']; // Новое поле город из списка


    $name = htmlspecialchars($name); //функция преобразует все символы, которые пользователь попытается добавить в форму:
$phone = htmlspecialchars($phone);
$comment=htmlspecialchars($comment);
$address=htmlspecialchars($address);

$name = urldecode($name); //функция декодирует url, если пользователь попытается его добавить в форму.
$phone = urldecode($phone);
$comment = urldecode($comment);
$address=urldecode($address);

$name = trim($name); //функцией мы удалим пробелы с начала и конца строки, если таковые имеются
$phone = trim($phone);
$comment = trim($comment);
$address=trim($address);
  

    $cartContent = json_decode($_POST['cartContent'], true);
    
    // Формируем сообщение для покупателя
    $customer_message = "Спасибо за ваш заказ!\n\n Для ОТМЕНЫ позвоните по номеру +79212626304 или напишите нам weblucky@webluck.store \n\nВаш заказ:\n\n";
    $totalPrice = 0;
    foreach ($cartContent as $item) {
        $customer_message .= "- " . ucfirst($item['product']) . " (количество: " . $item['quantity'] . ") - ₽" . $item['price'] * $item['quantity'] . "\n";
        $totalPrice += $item['price'] * $item['quantity'];
    }
        $customer_message .= "\nИтоговая сумма заказа: ₽ " . $totalPrice;
      $customer_message .= "\nКомментарий к заказу: $comment"; // Добавление комментария   
     $customer_message .= "\n\nНаименование Заказчика: $name"; // Добавление 
         $customer_message .= "\nУказанный город/район доставки: $city"; // Добавление к
         $customer_message .= "\nВаш адрес доставки: $address"; // Добавление адреса
    $customer_message .= "\nВаш номер телефона: $phone"; // Добавление телефона

     

    // Отправляем сообщение на экран покупателя
   // echo $customer_message;

    // Отправляем подтверждение заказа покупателю
    $to = $email;
    $subject = "Подтверждение заказа";
    $headers = "From: weblucky@webluck.store"; // Замените на ваш электронный адрес
    mail($to, $subject, $customer_message, $headers);

    // Отправляем копию заказа поставщику
    $to_supplier = "kvy.39@ya.ru"; // Замените на адрес поставщика
    $subject_supplier = "Новый заказ";
    $message_supplier = "Заказ от: $email\n\nТовары:\n";
    foreach ($cartContent as $item) {
        $message_supplier .= "- " . ucfirst($item['product']) . " (количество: " . $item['quantity'] . ") - ₽" . $item['price'] * $item['quantity'] . "\n";
    }
    $message_supplier .= "\nИтоговая сумма заказа (руб.): " . $totalPrice;
        $message_supplier .= "\n\nНаименование Заказчика: $name"; // Добавление комментария
    $message_supplier .= "\nУказанный город/район доставки: $city"; // Добавление комментария
    $message_supplier .= "\nАдрес доставки: $address"; // Добавление адреса
    $message_supplier .= "\nНомер телефона: $phone"; // Добавление телефона
    $message_supplier .= "\nКомментарий к заказу: $comment"; // Добавление комментария


    

    $headers_supplier = "From: $email";
    mail($to_supplier, $subject_supplier, $message_supplier, $headers_supplier);

    echo "<h2>Ваш заказ отправлен в работу!</h2> 
    <p>Вам так же отпралена копия заказа на указанный эл.адрес $email. </p>
    <p>Итоговая сумма заказа (руб.): $totalPrice </P>
    <p>Комментарий к заказу: $comment</p>
    <p>Указанный город/район доставки: $city</P>
    <p>Адрес доставки: $address</P>
    <p>Ваш номер телефона: $phone</P>

<br>
    
    <h2>Для ОТМЕНЫ позвоните по номеру  <a href='tel:+79212626304'> +79212626304 </a> или напишите нам <a href='email:weblucky@webluck.store'> weblucky@webluck.store </a></h2>
    <h3><a href='index.html'>Вернуться на сайт</a></h3><br> 
    <h4><a href='https://webluck.ru/'> Хочу такой же On-line магазин 🍀 !!! </a> </h4>
    ";
}
?>



</div>

</body>
</html>