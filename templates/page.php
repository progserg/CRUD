<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Заказы</title>
    <link rel="stylesheet" href="/templates/assets/css/style.css" type="text/css">
</head>
<body>
<div class="container">
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Название</th>
            <th>Категория</th>
            <th>Стоимость</th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td class="span" colspan="6"></td>
        </tr>
        </thead>
        <tbody>
        {data}
        </tbody>
    </table>

    <div class="edit">
        <form action="/" method="post" class="form-edit">
            <input type="hidden" name="edit">
            <label>ID заказа</label>
            <input type="text" readonly="readonly" name="id" value="">
            <label>Название</label>
            <input type="text" name="name">
            <label>Категория</label>
            <input type="text" name="category">
            <label>Стоимость</label>
            <input type="text" name="price">
            <div class="btns clearfix">
                <input type="submit" class="js-cancel left" value="Отмена">
                <input type="submit" class="js-save right" value="Сохранить">
            </div>
        </form>
    </div>
</div>
<form action="/" method="POST" class="add">
    <input type="hidden" name="add">
    <input type="text" name="name" placeholder="LG">
    <input type="text" name="category" placeholder="ноутбуки">
    <input type="text" name="price" placeholder="100.50">
    <input type="submit" value="Добавить заказ">
</form>
<script src="/templates/assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="/templates/assets/js/script.js" type="text/javascript"></script>
</body>
</html>