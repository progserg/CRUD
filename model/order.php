<?php

class Order {

    private $dbh = '';

    public function __construct()
    {
        //достаем кофигурацию из Json файла
        $db_config = file_get_contents(__DIR__ . '/../config/config.json');
        $db_config = json_decode($db_config);
        $dsn = 'mysql:host=' . $db_config->host . ';dbname=' . $db_config->dbname;
        $username = $db_config->username;
        $password = $db_config->password;
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );

        //создаем PDO объект для работы с БД
        $this->dbh = new PDO($dsn, $username, $password, $options);
    }

    //добавление записи
    public function add($name, $category, $price)
    {
        //подготовили запрос
        $add_order = $this->dbh->prepare('INSERT INTO orders (name, category, price) VALUES (:name, :category, :price)');
        //выполнили запрос
        $add_order->execute([':name' => $name, ':category' => $category, ':price' => $price]);
    }

    //редактирование записи
    public function edit($id, $name, $category, $price)
    {
        $edit_order = $this->dbh->prepare('UPDATE orders SET name = :name, category = :category, price = :price WHERE id = :id');
        $edit_order->execute([':name' => $name, ':category' => $category, ':price' => $price, ':id' => $id]);
    }

    //удаление записи
    public function del($id)
    {
        $edit_order = $this->dbh->prepare('DELETE FROM orders WHERE id = :id');
        if($edit_order->execute([':id' => $id])){
            echo json_encode(['success' => 'success'],true);
        }else{
            echo json_encode(['success' => 'failed'],true);
        }
    }

    //изменение записи
    public function change($values)
    {
        $values = json_decode($_POST['values'], true);

        switch($values['name']){
            case 'name':
                $update_order = $this->dbh->prepare('UPDATE orders SET name = :val WHERE id = :id');
                break;
            case 'category':
                $update_order = $this->dbh->prepare('UPDATE orders SET category = :val WHERE id = :id');
                break;
            case 'price':
                $update_order = $this->dbh->prepare('UPDATE orders SET price = :val WHERE id= :id');
                break;
            default:
                header('Location: http://'.$_SERVER['HTTP_HOST']);
        }
        if($update_order->execute([':val' => $values['value'], ':id' => $values['id']])){
            echo json_encode(['success' => 'success'],true);
        }else{
            echo json_encode(['success' => 'failed'],true);
        }
    }

    //вывод страницы
    public function show_page(){
        //загрузили данные из БД
        $request = $this->dbh->query('SELECT * FROM orders ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
        $data = '';
        //сформировали часть таблицы
        foreach ($request as $item) {

            $data .= '<tr data-id="'. $item['id'] .'">';

            $data .= '<td>' . $item['id'] . '</td>';
            $data .= '<td><input type="text" name="name" value="' . $item['name'] . '"></td>';
            $data .= '<td><input type="text" name="category" value="' . $item['category'] . '"></td>';
            $data .= '<td><input type="text" name="price" value="' . $item['price'] . '"></td>';
            $data .= '<td><input type="submit" class="js-btn btn-edit" value="Редактировать"></td>';
            $data .= '<td><input type="submit" class="js-btn btn-del" value="Удалить"></td>';


            $data .= '</tr>';
        }
        //загрузили шаблон страницы
        $page = file_get_contents(__DIR__ . '/../templates/page.php');

        //заменили данные шаблона сформированной частью таблицы и вернули результат
        return $result = str_replace('{data}', $data, $page);
    }
}