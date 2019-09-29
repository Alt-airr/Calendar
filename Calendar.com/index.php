<?php

//Подключение к БД (файл bdd.php)
require_once('php/bdd.php');
$sql = "SELECT id, title, date, members, description FROM events ";
$req = $bdd->prepare($sql);
$req->execute();
$events = $req->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendar</title>

    <!--  Стили -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href='css/fullcalendar.css' rel='stylesheet'/>
    <link href="css/style.css" rel="stylesheet">

    <!-- Скрипты  -->
    <script src="js/jquery.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="js/jquery.highlight.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

</head>
<body>
<div class="calendar-wrapper">
    <div class="header">
        <div class="header-wrapper">
<!--     Быстрое добавление событий-->
            <div class="quick-btns">
                <button class="quick-btn" type="button" id="quick-add_btn" value="Click">Добавить</button>
                <button class="quick-btn" type="button">Обновить</button>
            </div>
            <div id="quick-add_area" class="menu">
                <form class="" method="POST" action="php/quickAddEvent.php">
                    <input class="inpt" type="text" value="" name="info" id="quick-add_input"
                           placeholder="Введите событие, дату, участников...">
                    <button class="quick-add_create" type="submit">Создать</button>
                </form>
            </div>

<!--     Поиск по событиям-->
            <form class="form-inline">
                <i class="fa fa-search dat"></i>
                <input class="inpt" id="search_text" name="search_text" type="text" placeholder="Событие, дата или участник"
                       aria-label="Search">
                <br>
                <div id="result"></div>
            </form>

        </div>
    </div>

    <!-- Календарь -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div id="calendar" class="col-centered">
                </div>
            </div>
        </div>

        <!-- Модальное окно добавления -->
        <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form-horizontal" method="POST" action="php/addEvent.php">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="text" name="title" class="form-control" id="title"
                                           placeholder="Событие">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="text" name="date" class="form-control" id="date" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="text" name="members" class="form-control" id="members"
                                           placeholder="Имена участников">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="text" name="description" class="form-control" id="description"
                                           placeholder="Описание">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="done-btn">Готово</button>
                            <button type="button" data-dismiss="modal">Удалить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Модальное окно редактирования -->
        <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form-horizontal" method="POST" action="php/editEvent.php">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="text" name="date" class="form-control" id="date">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="text" name="members" class="form-control" id="members"
                                           placeholder="Участники">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="text" name="description" class="form-control" id="description"
                                           placeholder="Описание">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" class="form-control del-btn" id="id">
                            <button type="submit" class="done-btn">Готово</button>
                            <button type="submit" name="delete">Удалить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Скрипты -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src='js/moment.min.js'></script>
<script src='js/fullcalendar.min.js'></script>
<script src="js/lang-all.js"></script>
<script>

    $(document).ready(function () {

        // Подключение календаря

        $('#calendar').fullCalendar({
            header: {
                left: 'prev, title, next today',
                // center: 'title',
                right: ''
            },
            defaultDate: '2019-09-19',
            editable: true,
            eventLimit: true,
            selectable: true,
            selectHelper: true,
            lang: 'ru',
            themeSystem: 'bootstrap',
            select: function (date) {

                $('#ModalAdd #date').val(moment(date).format('YYYY-MM-DD'));
                $('#ModalAdd').modal('show');
            },
            eventRender: function (event, element, view) {

                //установка значений полей в соотвествии с БД, вызов модального окна

                element.bind('dblclick', function () {
                    $('#ModalEdit #id').val(event.id);
                    $('#ModalEdit #title').val(event.title);
                    $('#ModalEdit #date').val(event.date);
                    $('#ModalEdit #members').val(event.members);
                    $('#ModalEdit #description').val(event.description);
                    $('#ModalEdit').modal('show');
                });

                $(".fc-rows table tbody tr .fc-widget-content div").addClass('fc-resized-row');
                $(".fc-content table tbody tr .fc-widget-content div").addClass('fc-resized-row');
                $(".fc-body .fc-resource-area .fc-cell-content").css('padding', '0px');
            },

            // Получени событий календарь с БД
            events: [
                <?php foreach($events as $event):

                $date = explode(" ", $event['date']);

                if ($date[1] == '00:00:00') {
                    $date = $date[0];
                } else {
                    $date = $event['date'];
                }
                ?>
                {
                    id: '<?php echo $event['id']; ?>',
                    title: '<?php echo $event['title']; ?>',
                    date: '<?php echo $date; ?>',
                    members: '<?php echo $event['members']; ?>',
                    description: '<?php echo $event['description']; ?>',
                },
                <?php endforeach; ?>
            ]
        });

        // Функция редактирования события (файл php/editEventDate.php)
        function edit(event) {
            date = event.date.format('YYYY-MM-DD');
            id = event.id;

            Event = [];
            Event[0] = id;
            Event[1] = date;
            Event[2] = date;

            $.ajax({
                url: 'php/editEventDate.php',
                type: "POST",
                data: {Event: Event},
                success: function (rep) {
                    if (rep == 'OK') {
                        alert('Saved');
                    } else {
                        alert('Could not be saved. try again.');
                    }
                }
            });
        }

        // Вызов формы быстрого добавления событий
        $('#quick-add_btn').click(function () {
            $("#quick-add_area").fadeToggle("0", "");
        });
    });

        // Функция поиска по БД
    $('#search_text').focus(function(){

        $('#result').fadeIn();
        load_data();
        function load_data(query)
        {
            $.ajax({
                url:"php/fetch.php",
                method:"post",
                data:{query:query},
                success:function(data)
                {
                    $('#result').html(data);
                }
            });
        }

        $('#search_text').keyup(function(){
            let search = $(this).val();
            if(search != '')
            {
                load_data(search);
            }
        });
    });

    $('#search_text').blur(function(){
        $('#result').fadeOut();
    })

</script>
</body>
</html>
