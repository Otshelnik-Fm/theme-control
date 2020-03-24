<?php

// регистрируем свой кастомайзер
add_action( 'customize_register', 'tc_button_customizer' );
function tc_button_customizer( $wp_customize ) {
    // реколл цвет
    $rcl_color = rcl_get_option( 'primary-color', '#4c8cbd' );

    list($r, $g, $b) = sscanf( $rcl_color, "#%02x%02x%02x" );

    $color = $r . ',' . $g . ',' . $b;


// добавим свою секцию в настройки
    $wp_customize->add_section( 'tc_section', array(
        'title'    => __( 'Theme Control Settings', 'theme-control' ),
        'priority' => 200
    ) );


// все опции ниже примерно однотипные (для оформления я применил инлайн стили!)
// Цвет кнопки основного меню
// tc_menu_bckgrnd - ID опции и ее имя в wp_options в массиве (на теме point-children:  theme_mods_point-children)
    $wp_customize->add_setting( 'tcl_bbck', array(
        'default'   => $rcl_color,
        'transport' => 'postMessage'                 // реалтайм обновление. Требует данные в скрипте
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tcl_bbck', array(
        'section'     => 'tc_section', // Привязка к секции
        'description' => '<strong>' . __( 'Background color of the menu button:', 'theme-control' ) . '</strong>',
        'label'       => '<span style="color: rgb(48, 161, 48); font-size: 18px; display: block; margin: 0px 0px 15px; line-height: 1; text-align: center;">' . __( 'Go to your personal account and configure the buttons', 'theme-control' ) . '</span>',
        'settings'    => 'tcl_bbck',
    ) ) );


    $wp_customize->add_setting( 'tcl_bbrd', array( // зададим бордер
        'default'   => $rcl_color,
        'transport' => 'postMessage'
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tcl_bbrd', array(
        'section'  => 'tc_section',
        'label'    => __( 'Border color:', 'theme-control' ),
        'settings' => 'tcl_bbrd',
    ) ) );


    $wp_customize->add_setting( 'tcl_bclr', array( // зададим цвет шрифта
        'default'   => '#fff',
        'transport' => 'postMessage'
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tcl_bclr', array(
        'section'  => 'tc_section',
        'label'    => __( 'The text color of the buttons:', 'theme-control' ),
        'settings' => 'tcl_bclr',
    ) ) );


// состояния кнопок
    $wp_customize->add_setting( 'tcl_babck', array( // Цвет нажатой кнопки (активной) и ховер
        'default'   => 'rgba(' . $color . ', 0.4)',
        'transport' => 'postMessage'
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tcl_babck', array(
        'section'  => 'tc_section',
        'label'    => '<hr style="border: 1px dashed #ccc;">' . __( 'Background color of the active menu button and hover button:', 'theme-control' ),
        'settings' => 'tcl_babck',
    ) ) );


    $wp_customize->add_setting( 'tcl_babrd', array( // зададим бордер
        'default'   => 'transparent',
        'transport' => 'postMessage'
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tcl_babrd', array(
        'section'  => 'tc_section',
        'label'    => __( 'Border color:', 'theme-control' ),
        'settings' => 'tcl_babrd',
    ) ) );
}

// добавляем свой стиль к стартовому блоку настроек (секции)
add_action( 'customize_controls_print_footer_scripts', 'tc_add_customizer_style' );
function tc_add_customizer_style() {
    $out = '<style>';
    $out .= '#customize-controls #accordion-section-tc_section  h3 {background: #deedc7;}';
    $out .= '</style>';
    echo $out;
}

// подключаю скрипт в админке - реалтайм предпросмотра изменений справа
add_action( 'customize_preview_init', 'tc_customizer_live_preview' );
function tc_customizer_live_preview() {
    wp_enqueue_script(
        'tc-customizer', rcl_addon_url( '', __FILE__ ) . 'assets/js/customizer.js', array( 'jquery', 'customize-preview' ), '1.0.0', true
    );
}

// инлайн стили из кастомайзера
add_filter( 'rcl_inline_styles', 'tc_inline_cstmzr_style', 10, 2 );
function tc_inline_cstmzr_style( $styles, $rgb ) {
    if ( is_customize_preview() )
        return $styles;

    if ( rcl_get_option( 'tcl_bttn', 'lite' ) != 'cstmz' )
        return $styles;

    list($r, $g, $b) = $rgb;
    $color = $r . ',' . $g . ',' . $b;

    $rcl_color = rcl_get_option( 'primary-color', '#4c8cbd' );

    $styles .= '
:root{
--tclBck:' . get_theme_mod( 'tcl_bbck', $rcl_color ) . ';
--tclBrd:' . get_theme_mod( 'tcl_bbrd', $rcl_color ) . ';
--tclClr:' . get_theme_mod( 'tcl_bclr', '#fff' ) . ';

--tclBckA:' . get_theme_mod( 'tcl_babck', 'rgba(' . $color . ', 0.4)' ) . ';
--tclBrdA:' . get_theme_mod( 'tcl_babrd', 'transparent' ) . ';
}
';

// сброс опций в дефолт
//    remove_theme_mod( 'tcl_bbck' );
//    remove_theme_mod( 'tcl_bbrd' );
//    remove_theme_mod( 'tcl_bclr' );
//
//    remove_theme_mod( 'tcl_babck' );
//    remove_theme_mod( 'tcl_babrd' );

    return $styles;
}

/* add global js - as Rcl.tclBck  */
add_filter( 'rcl_init_js_variables', 'tcl_customize_js_colors', 10 );
function tcl_customize_js_colors( $data ) {
    if ( ! is_customize_preview() )
        return $data;

    $rcl_color = rcl_get_option( 'primary-color', '#4c8cbd' );

    list($r, $g, $b) = sscanf( $rcl_color, "#%02x%02x%02x" );
    $color = $r . ',' . $g . ',' . $b;


    $data['tclBck'] = get_theme_mod( 'tcl_bbck', $rcl_color );
    $data['tclBrd'] = get_theme_mod( 'tcl_bbrd', $rcl_color );
    $data['tclClr'] = get_theme_mod( 'tcl_bclr', '#fff' );

    $data['tclBckA'] = get_theme_mod( 'tcl_babck', 'rgba(' . $color . ', 0.4)' );
    $data['tclBrdA'] = get_theme_mod( 'tcl_babrd', 'transparent' );


    return $data;
}
