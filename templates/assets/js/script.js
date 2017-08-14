$(document).ready(function () {

    //обрабатываем изменение данных в ячейках
    $('input').on('change', function () {
        var id = $(this).closest('tr').attr('data-id');
        if (id != undefined && !isNaN(id)) {
            $values = {'id': id, 'value': $(this).val(), 'name': $(this).attr('name')};
            $.post('/', {'values': JSON.stringify($values)}, function (data) {
                if (data) {
                    data = JSON.parse(data);
                    if (data.success == 'success') {
                        console.log('Изменения сохранены');
                    } else {
                        console.log('Ошибка! Изменения не сохранены');
                    }
                }
            });
        }
    });

    //кнопка "отмена" на форме редактирования записи
    $('.js-cancel').on('click', function () {
        $('.edit').css('display', '');
        $('.add').css('display', '');
        return false;
    });


    //Обработка нажатий кнопок
    $('.js-btn').on('click', function () {
        var id = $(this).closest('tr').attr('data-id');
        if ($(this).is('.btn-edit')) {  //кнопка "редактировать"

            //получаем текущие значения выбранной записи
            var name = $(this).closest('tr').find('input[name="name"]').val();
            var category = $(this).closest('tr').find('input[name="category"]').val();
            var price = $(this).closest('tr').find('input[name="price"]').val();
            //записываем их в форму редактирования
            $('.edit > form > input[name="id"]').val(id);
            $('.edit > form > input[name="name"]').val(name);
            $('.edit > form > input[name="category"]').val(category);
            $('.edit > form > input[name="price"]').val(price);
            $('.add').css('display', 'none');   //скрываем форму добавления записи
            $('.edit').css('display', 'block'); //показываем форму редактирования зписи
        }
        if ($(this).is('.btn-del')) {   //кнопка "удалить"
            if (id != undefined && isNaN(id)) {    //если id  = число, передаем его в функцию выполняющую удаление
                $.post('/', {'del': 'del', 'id': id}, function (data) {
                    if (data) {
                        data = JSON.parse(data);
                        if (data.success == 'success') {
                            console.log('Запись удалена');
                            location.replace('/');
                        } else {
                            console.log('Ошибка! Удаление не выполнено');
                        }
                    }
                });
            }
        }
    });
});