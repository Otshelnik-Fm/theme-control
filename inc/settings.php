<?php

function tc_add_settings($options){

    $opt = new Rcl_Options(__FILE__);

    $options .= $opt->options('Настройки Theme Control', array(

        $opt->option_block(
            array(
                $opt->label('Включаем визуальный кастомайзер?'),
                $opt->option('select', array(
                    'name' => 'tc_cstmzr',
                    'options' => array(0 => 'Нет', 1 => 'Да')
                )),
                $opt->help('Включив данную опцию - переходите в админке "Внешний вид" - "Настроить" - "Настройки Theme Control"<br/>И приступаете к визуальной настройке кнопки.<br/><br/>Данная опция будет полезна тем, кто не умеет самостоятельно править css стили. Поэтому кастомайзер поможет вам настроить кнопки личного кабинета.'),
                $opt->notice('По умолчанию: <strong>Нет</strong><br/>'),
            )
        ),

    ));
    return $options;
}
add_filter('admin_options_wprecall','tc_add_settings');
