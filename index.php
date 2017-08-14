<?php
//подключили класс
require_once (__DIR__ . '/model/order.php');

//создали объект класса
$order = new order;

//обработка post запросов
if(!empty($_POST)){
    //на добавление записи
    if(isset($_POST['add']) && !empty($_POST['name']) && !empty($_POST['category']) && !empty($_POST['price'])){
        $order->add($_POST['name'], $_POST['category'], $_POST['price']);
    }

    //на редактирование записи
    if(isset($_POST['edit']) && !empty($_POST['id']) && !empty($_POST['name']) && !empty($_POST['category']) && !empty($_POST['price'])){
        $order->edit($_POST['id'], $_POST['name'], $_POST['category'], $_POST['price']);
    }

    //на удаление записи
    if(isset($_POST['del']) && !empty($_POST['id'])){
        echo $order->del($_POST['id']);
        exit;
    }

    //на изменение записи
    if(!empty($_POST['values'])){
        echo $order->change($_POST['values']);
        exit;
    }
    //отправляем на домашнюю
    header('Location: http://'.$_SERVER['HTTP_HOST']);
}
//показываем страницу
echo $order->show_page();