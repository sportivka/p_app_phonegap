/* Инициализация приложения*/
$(document).on("mobileinit", function () {
    $("#header").css({
        'position': 'absolute',
        'top': '0px'
    }); /*Подгоняем хидер*/
    FastClick.attach(document.body); /*Включаем Fast Click*/
});

/*Страница Подгружена*/
$(document).on("pageshow", function () {
    var header = $('[data-role=header]').outerHeight(); /*Размер хидера*/
    var panel = $('.ui-controlgroup-controls').height(); /*Размер меню*/
    var panelheight = panel - header; /*Новый размер меню*/
    $('.ui-panel').css({
        'top': header,
        'min-height': panelheight
    });
});

function exitFromApp() { /*Выход из приложения*/
    navigator.app.exitApp();
}
/*После загрузки страницы act-page*/

    /*При клике на Считать код*/
    $(document).on('click', "#recognize_btn", function () {
        /*Инициализируем плагин cordova*/
        var scanner = cordova.require("cordova/plugin/BarcodeScanner");
        /*После успешного сканирования баркода...*/
        scanner.scan(function (result) {
            // if (result.format == "QR_CODE") {
            $('input#act_code_input').val(result.text);
            // }
            /*Если ошибка, то вывести алерт*/
        }, function (error) {
            alert("Ошибка в сканировании! " + error);
        });
    });



/*После загрузки страницы point-page*/
$(document).on('pagebeforeshow', '#point-page', function () {
    /*При нажатии на любой из пунктов списка*/
    $(document).on('click', "li[point]", function () {
        /*Считываем токен из хранилища*/
        var token = window.localStorage.getItem("token");
        /*Формируем запрос на сервер */
        $.ajax({
            type: 'GET',
            url: 'http://api.p-bonus.ga/index.php',
            data: 'act=load_point_info&point_id=' + $(this).attr('point') + '&token=' + token,
            dataType: 'json',
            /*При ошибке вывести сообщение*/
            error: function () {
                alert('error');
            },
            /*При успешном получении запроса, формируем содержимое страницы*/
            success: function (data) {
                /*При ошибке (невалидность токена) перевести на страницу авторизации*/
                if (data.state == "error") {
                    $.mobile.changePage("#auth-page")
                }
                /*Формируем содержимое*/
                var str_info =
                    '<div class="ui-grid-a">' +
                    '<div class="ui-block-a">' +
                    '<h2>' + data.company + '</h2> </br>' +
                    '<strong>Описание:</strong></br>' +
                    '<p>' + data.desc + '</p>' +
                    '<a href="#map">На карте</a></br>' +
                    '<strong>Часы работы</strong></br>' +
                    '<p>' + data.hours + '</p>' +
                    '<a href="#phone">' + data.contacts + '</a></br>' +
                    '<a href="#phone">' + data.sait + '</a></br>' +
                    '</div>' +
                    '<div class="ui-block-b">' +
                    '<img height="100" width="100" src="http://p-bonus.ga/img/company/' + data.img + '" class="ui-li-thumb"></br>' +
                    '</div>' +
                    '</div>';
                /*Меняем страницу*/
                $.mobile.changePage("#moreinfo-page");
                /*Очищаем старое содержимое*/
                $('div#moreinfo_form').empty();
                /*Добавляем содержимое страницы*/
                $('div#moreinfo_form').append(str_info);
                return false;
            }
        });
    });
});

/*После загрузки страницы auth-page*/
$(document).on('pagebeforeshow', '#auth-page', function () {
    /*Очищаем токен*/
    window.localStorage.removeItem("token");
    /*При нажатии кнопки Вход*/
    $(document).on('click', "a#auth_btn", function () {
        /*Проверяем поля на длину*/
        if ($("input#login_input").val().length <= 5 || $("input#pass_input").val().length <= 5) {
            alert('Заполните поля!');
        } else {
            /*При прохождении проверки отослать запрос на авторизацию*/
            $.ajax({
                type: 'GET',
                url: 'http://api.p-bonus.ga/index.php',
                data: 'act=login_app&login=' + $("input#login_input").val() + '&password=' + $("input#pass_input").val(),
                dataType: 'json',
                /*При ошибке вывести сообщение*/
                error: function () {
                    alert('error');
                },
                 /*При успешном запросе...*/
                success: function (data) {
                     /*Если запрос валидный то...*/
                    if (data.state == "success") {
                         /*Сохраняем выданный токен в локальное хранилище*/
                        window.localStorage.setItem("token", data.token);
                         /*Изменяем страницу*/
                        $.mobile.changePage("#act-page")
                    } else {
                         /*При ошибке вывести сообщение и очистить поля ввода*/
                        alert('Неправильный логин или пароль!');
                        $("input#login_input").val('');
                        $("input#pass_input").val('');
                    }
                    return false;
                }
            });

        }
    });
});

        /*При нажатии кнопки Ввести код*/
    $(document).on("click", "a#act_code_btn", function () {
        var token = window.localStorage.getItem("token");
          /*Проверяем поле на длину*/
        if ($("input#act_code_input").val().length <= 3) {
            alert('Заполните поле или нажмите "Считать код!"');
        } else {
                /*Формируем запрос на сервер */
            $.ajax({
                type: 'GET',
                url: 'http://api.p-bonus.ga/index.php',
                data: 'act=check_code&code=' + $("input#act_code_input").val() + '&token=' + token,
                dataType: 'json',
                 /*При ошибке вывести сообщение*/
                error: function () {
                    alert('error');
                },
                  /*При успешном запросе...*/
                success: function (data) {
                    if (data.state != "error") {
                            /*При успешном запросе  вывести сообщение*/
                        alert('Вам зачислено ' + data.sum + 'баллов');
                    } else {
                           /*При ошибке вывести сообщение*/
                        alert('Данный код просрочен!');
                    }
                    return false;
                }
            });

        }
    });





$(document).on("pageinit", "#info-page", function () {
    $(".btn-out").click(function () {
        $('.text-out').hide();
        $('#' + this.id + '-text.text-out').show();
        return false;
    });
});

$(document).on("pageshow", "#balance-page", function () {
    // $('ul.ui-listview').empty();
    var token = window.localStorage.getItem("token");
    $.ajax({
        url: 'http://api.p-bonus.ga/index.php',
        data: 'act=get_balance' + '&token=' + token,
        type: 'GET',
        dataType: 'json',
        error: function () {
            alert('error');
        },
        success: function (data) {
            if (data.state == "error") {
                $.mobile.changePage("#auth-page")
            } else {
                $('div#balance_form').empty();
                balance = '<strong>Ваши баллы: </strong>' + data.cur_balance + '</br>' +
                    '<strong>Введено кодов: </strong>' + data.cur_shot + '</br>';
                $('div#balance_form').append(balance);
            }
            return false;
        }
    });
});

$(document).on("pageshow", "#point-page", function () {
    function loadpointsform(point_list) {
        p_list = $.parseJSON(point_list);
        $.each(p_list, function (key) {
            point =
                '<li  data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="false" data-theme="c" point="' + p_list[key].id + '"  class="ui-btn  ui-li ui-li-has-alt ui-li-has-thumb ui-btn-up-c ui-li-static ui-body-c ui-first-child">' +
                '<div class="ui-btn-inner ui-li ui-li-has-alt">' +
                '<div class="ui-btn-text">' +
                '<a href="#" class="ui-link-inherit ui-link">' +
                '<img src="http://p-bonus.ga/img/company/' + p_list[key].img + '" class="ui-li-thumb">' +
                '<h3 class="ui-li-heading">' + p_list[key].company + '</h3>' +
                '<p class="ui-li-desc">' + p_list[key].adress + '</p>' +
                '<p class="ui-li-desc">Мах bet: ' + p_list[key].m_bet + '</p>' +
                '</a>' +
                '</div></div>' +
                '</li>';
            $('ul.ui-listview').append(point);
        });
    }
    $('ul.ui-listview').empty();

    var token = window.localStorage.getItem("token");
    var point_list = window.localStorage.getItem("point_list");
    if (point_list == null) {
        $.ajax({
            url: 'http://api.p-bonus.ga/index.php',
            data: 'act=load_point_list' + '&token=' + token,
            type: 'GET',
            // dataType: 'json',
            error: function () {
                alert('error');
            },
            success: function (data) {
                arr = $.parseJSON(data);
                if (arr.state == "error") {
                    $.mobile.changePage("#auth-page")
                } else {
                    window.localStorage.setItem("point_list", data);

                    loadpointsform(data);
                }
            }
        });
    } else {
        loadpointsform(point_list);
    }

    return false;
});