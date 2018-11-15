(function($){
    var LkMenu = $('#lk-menu');
    var typeButton = $('#rcl-office');
    var RclOverlay = $('#rcl-overlay');
	
// при ресайзе обновляем
function moveMenu(){
    LkMenu.append($('#control_ext_menu').html());
    $('#lk-menu .tc_bmenu').remove();
    $('#control_ext_menu').remove();
}

// закрытие меню
function closeExtMenu(){
    if (RclOverlay.hasClass('control_mbl_menu')){ // проверяем что это наш оверлей
        RclOverlay.fadeOut(100).removeClass('control_mbl_menu');
    }
    $('#control_ext_menu').removeClass('bounce').css({'top' : '','left' : ''});
}

// определяем какой тип кнопок у нас
if (typeButton.hasClass('vertical-menu')){
    if (typeButton.outerWidth(true) <= 768){ // ширина экрана
        typeButton.removeClass('vertical-menu').addClass('horizontal-menu');
        alignMenu();
    }
    $(window).resize(function() { // действия при ресайзе окна
        if (typeButton.outerWidth(true) <= 768){
            typeButton.removeClass('vertical-menu').addClass('horizontal-menu');
            closeExtMenu();
            moveMenu();
            alignMenu();
        } else {
            typeButton.removeClass('horizontal-menu').addClass('vertical-menu');
            closeExtMenu();
            moveMenu();
        }
    });
} else if (typeButton.hasClass('horizontal-menu')){
    alignMenu();
    $(window).resize(function() {
        closeExtMenu();
        moveMenu();
        alignMenu();
    });
}
	
// отступ сверху-слева до наших кнопок
function menuPosition(){
    var hUpMenu = LkMenu.offset().top + 2;
    $('#control_ext_menu').css({'top' : hUpMenu,'left':'0'});
    // считаем, ниже, отступ - когда экран у нас шире контента. Предотвращаем прижатие окна к левому краю. Теперь меню в области кнопки
    var wLeftMenu = LkMenu.offset().left - 10;
    if (wLeftMenu > 70) { // если у нас есть отступ - сдвигаем менюшку
        $('#control_ext_menu').css({'left' : wLeftMenu});
    }
}

// группировка кнопок
function alignMenu(){
    var mw = LkMenu.outerWidth() - 40;                              // ширина блока - отступ на кнопку (на flex блоке точность не нужна!)
    var menuhtml = '';
    var totalWidth = 0;                                             // сумма ширины всех кнопок

    $.each(LkMenu.children('.rcl-tab-button'), function() {
        totalWidth += $(this).children().outerWidth(true);          // считаем ширину всех кнопок с учетом отступов
        if (mw < totalWidth) {                                      // если ширина блока кнопок меньше чем сумма ширины кнопок:
            menuhtml += $('<div>').append($(this).clone()).html();
            $(this).remove();
        }
    });

    LkMenu.prepend('<span class="tc_bmenu"><i class="rcli fa-chevron-down"></i></span>');

    $('body').append('<div id="control_ext_menu">' + menuhtml + '</div>');

    var tcBmenu = $('#lk-menu .tc_bmenu');
    if (menuhtml == '') {                                           // если нет контента в кнопке - скрываем её
        tcBmenu.hide();
    } else {
        tcBmenu.show();
    }

    $('#lk-menu .tc_bmenu').on('click', function (){
        $('#control_ext_menu').toggleClass('bounce', 500);
        RclOverlay.fadeToggle(100).toggleClass('control_mbl_menu'); // добавляем наш класс оверлею. Чтоб чужой не закрывать
        menuPosition();
    });

    RclOverlay.on('click', function () { closeExtMenu(); });
    $('#control_ext_menu').on('click', function () { closeExtMenu(); });
}

})(jQuery);
