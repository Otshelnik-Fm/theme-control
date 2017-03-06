<?php


// регистрируем свой кастомайзер
function tc_button_customizer($wp_customize){

// добавим свою секцию в настройки
$wp_customize->add_section('tc_section', array(
        'title'     => 'Настройки Theme Control',
        'priority'  => 200
));


// все опции ниже примерно однотипные (для оформления я применил инлайн стили!)
// Цвет кнопки основного меню
$wp_customize->add_setting('tc_menu_bckgrnd', array(    // tc_menu_bckgrnd - ID опции и ее имя в wp_options в массиве (на теме point-children:  theme_mods_point-children)
        'default'     =>  '#fff',
        'transport'   =>  'postMessage'                 // реалтайм обновление. Требует данные в скрипте
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'tc_menu_bckgrnd', array(
        'section'     => 'tc_section',                  // Привязка к секции
        'description' => '<strong>Цвет фона кнопки меню:</strong>',
        'label'       => '<span style="color: rgb(48, 161, 48); font-size: 18px; display: block; margin: 0px 0px 15px; line-height: 1; text-align: center;">Перейдите в личный кабинет и настройте кнопки</span>',
        'settings'    => 'tc_menu_bckgrnd',
)) );


$wp_customize->add_setting('tc_menu_border', array( // зададим бордер
        'default'     =>  '#fff',
        'transport'   =>  'postMessage'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'tc_menu_border', array(
        'section'     => 'tc_section',
        'label'       => 'Цвет нижнего бордера:',
        'settings'    => 'tc_menu_border',
)) );


$wp_customize->add_setting('tc_menu_color', array( // зададим цвет шрифта
        'default'     =>  '#000',
        'transport'   =>  'postMessage'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'tc_menu_color', array(
        'section'     => 'tc_section',
        'label'       => 'Цвет текста кнопок:',
        'settings'    => 'tc_menu_color',
)) );




// состояния кнопок
$wp_customize->add_setting('tc_menu_bckgrnd_active', array( // Цвет нажатой кнопки (активной) и ховер
        'default'     =>  '#e5e5e5',
        'transport'   =>  'postMessage'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'tc_menu_bckgrnd_active', array(
        'section'     => 'tc_section',
        'label'       => '<hr style="border: 1px dashed #ccc;">Цвет фона активной кнопки меню и hover кнопки:',
        'settings'    => 'tc_menu_bckgrnd_active',
)) );


$wp_customize->add_setting('tc_menu_border_active', array( // зададим бордер
        'default'     =>  '#d2d2cf',
        'transport'   =>  'postMessage'
));
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'tc_menu_border_active', array(
        'section'     => 'tc_section',
        'label'       => 'Цвет нижнего бордера:',
        'settings'    => 'tc_menu_border_active',
)) );


}
add_action('customize_register', 'tc_button_customizer');



// добавляем свой стиль к стартовому блоку настроек (секции)
function tc_add_customizer_style() {
    $out = '<style>';
        $out .= '#customize-controls #accordion-section-tc_section  h3 {background: #deedc7;}';
    $out .= '</style>';
    echo $out;
}
add_action('customize_controls_print_footer_scripts', 'tc_add_customizer_style');




// подключаю скрипт в админке - реалтайм предпросмотра изменений справа
function tc_customizer_live_preview() {
    wp_enqueue_script(
        'tc-customizer',
        rcl_addon_url('', __FILE__) . 'inc/customizer.js',
        array( 'jquery', 'customize-preview' ),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'tc_customizer_live_preview');




// инлайн стили из кастомайзера
function tc_inline_cstmzr_style($styles){
    $styles .= '
#control_ext_menu a,
#lk-content.rcl-content .recall-button,
#lk-menu .rcl-tab-button .recall-button {
    background: '.get_theme_mod('tc_menu_bckgrnd').';
    border-bottom: 2px solid '.get_theme_mod('tc_menu_border').';
    color: '.get_theme_mod('tc_menu_color').';
}';

    $styles .= '
#lk-content.rcl-content .recall-button:hover,
#lk-content.rcl-content .recall-button.active,
#lk-content.rcl-content .recall-button.filter-active,
#control_ext_menu a:hover,
#control_ext_menu a.active,
#lk-menu .rcl-tab-button .recall-button:hover,
#lk-menu .rcl-tab-button .recall-button.active {
    background: '.get_theme_mod('tc_menu_bckgrnd_active').';
    border-bottom: 2px solid '.get_theme_mod('tc_menu_border_active').';
}';

    $styles .= '
.horizontal-menu .rcl-menu .rcl-tab-button,
#lk-content.rcl-content .recall-button {
    border-right : 1px solid '.get_theme_mod('tc_menu_border').';
}';

    $styles .= '#control_ext_menu.bounce {
    border-left : 6px solid '.get_theme_mod('tc_menu_border').';
}';


    return $styles;
}
add_filter('rcl_inline_styles','tc_inline_cstmzr_style',10);

