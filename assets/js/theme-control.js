/* global RclUploaders, Rcl */

(function($){
    var LkMenu = $('#lk-menu');
    var TypMenu = $('#rcl-office');
    var RcLay = $('#rcl-overlay');
	
// при ресайзе обновляем
function tclReset(){
    LkMenu.append($('#tcl_extm').html());
    $('#lk-menu .tcl_bmenu').remove();
    $('#tcl_extm').remove();
}

// закрытие меню
function tclClose(){
    if (RcLay.hasClass('tcl_coat')){ // проверяем что это наш оверлей
        RcLay.fadeOut(5).removeClass('tcl_coat');
    }
    $('#tcl_extm').removeClass('tcl_open');
}

// определяем какой тип кнопок у нас
var tclV = 'vertical-menu';
var tclH = 'horizontal-menu';
if (TypMenu.hasClass(tclV)){
    if (TypMenu.outerWidth(true) <= 768){ // ширина экрана
        TypMenu.removeClass(tclV).addClass(tclH);
        tclMenu();
    }
    $(window).resize(function() { // действия при ресайзе окна
        if (TypMenu.outerWidth(true) <= 768){
            TypMenu.removeClass(tclV).addClass(tclH);
            tclClose();
            tclReset();
            tclMenu();
        } else {
            TypMenu.removeClass(tclH).addClass(tclV);
            tclClose();
            tclReset();
        }
    });
} else if (TypMenu.hasClass(tclH)){
    tclMenu();
    $(window).resize(function() {
        tclClose();
        tclReset();
        tclMenu();
    });
}

// группировка кнопок
function tclMenu(){
    var mw = LkMenu.outerWidth() - 63;                              // ширина блока - отступ на кнопку
    var menuhtml = '';
    var totalWidth = 0;                                             // сумма ширины всех кнопок

    $.each(LkMenu.children('.rcl-tab-button'), function() {
        totalWidth += $(this).outerWidth(true);          // считаем ширину всех кнопок с учетом отступов
        if (mw < totalWidth) {                                      // если ширина блока кнопок меньше чем сумма ширины кнопок:
            menuhtml += $('<div>').append($(this).clone()).html();
            $(this).remove();
        }
    });

    LkMenu.prepend('<button class="tcl_bmenu tcl_shev tcl_border"><i class="rcli fa-chevron-down"></i></button>');

    $('body').append('<div id="tcl_extm" class="tcl_men tcl_slide">' + menuhtml + '</div>');

    var tcBmenu = $('#lk-menu .tcl_bmenu');
    
    menuhtml === '' ? tcBmenu.hide() : tcBmenu.show(); // если нет контента в кнопке - скрываем её
    
    // считаем, ниже, отступ - когда экран у нас шире контента. Предотвращаем прижатие окна к левому краю. Теперь меню в области кнопки
    var wLeftMenu = LkMenu.offset().left + 12;
    if (wLeftMenu > 50) { // если у нас есть отступ - сдвигаем менюшку
        $('#tcl_extm').css('left', wLeftMenu);
    }

    $(tcBmenu).on('click', function (){
        $('#tcl_extm').toggleClass('tcl_open', 1);
        RcLay.show().addClass('tcl_coat'); // добавляем наш класс оверлею. Чтоб чужой не закрывать
        var hUpMenu = LkMenu.offset().top + 47;
        $('#tcl_extm').css('top', hUpMenu);  // отступ слева до наших кнопок
    });

    RcLay.add('#tcl_extm').on('click', function () { tclClose(); });
}

})(jQuery);

// загрузка авы
rcl_add_action( 'rcl_footer', 'tclAva' );
function tclAva() {
    if ( Rcl.user_ID !== Rcl.office_ID )
        return;

    var tclUploader = RclUploaders.get( 'rcl_avatar' );
    if ( undefined === tclUploader )
        return;

    tclUploader.afterDone = function( e, data ) {
        jQuery( '#tcl_ava img, .rcb_right_menu .avatar, .uit_avatar img' ).attr( 'srcset', '' )
            .attr( 'src', data.result.src.thumbnail )
            .load()
            .animateCss( 'zoomIn' );

        rcl_do_action( 'rcl_success_upload_cover', data );
    };

    tclUploader.animateLoading = function( status ) {
        status ? rcl_preloader_show( jQuery( 'body:not(.uit_run) .tcl_right, .uit_avatar' ) ) : rcl_preloader_hide();
    };
}