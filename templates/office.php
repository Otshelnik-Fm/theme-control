<?php
/*  Шаблон дополнения Theme Control https://codeseller.ru/products/theme-control/
  Версия шаблона v2.0
  Если вам нужно внести изменения в данный шаблон - скопируйте его в папку /wp-content/wp-recall/templates/
  - сделайте там в нем нужные вам изменения и он будет подключаться оттуда
  Подробно работа с шаблонами описана тут: https://codeseller.ru/?p=11632
 */
?>
<?php global $user_LK; ?>

<div class="tcl_top_header"><?php do_action( 'rcl_area_top' ); ?></div>
<div id="lk-conteyner" class="tcl_head">
    <div class="tcl_top">
        <div class="tcl_left">
            <div class="tcl_user">
                <?php tcl_author_menu( $user_LK ); ?>
                <?php tcl_username( $user_LK ); ?>
            </div>

            <div class="tcl_data"><?php tcl_user_action(); ?><?php tcl_user_info(); ?></div>
        </div>

        <div class="tcl_right">
            <span id="avatar-upload-progress"></span>
            <div id="tcl_cbox" class="tcl_bttn tcl_bttn_cnt">
                <?php do_action( 'rcl_area_counters' ); ?>
            </div>
        </div>
    </div>

    <div id="tcl_b_box" class="tcl_b_area"><?php do_action( 'tcl_before_actions' ); ?></div>
    <div id="tcl_a_box" class="tcl_a_area"><?php do_action( 'rcl_area_actions' ); ?></div>
    <div id="tcl_abox" class="tcl_bttn tcl_bttn_act"><?php do_action( 'tcl_after_actions' ); ?></div>
</div>
<div id="tcl_inm"><?php do_action( 'rcl_area_menu' ); ?></div>
<div id="rcl-tabs">
    <?php do_action( 'rcl_area_tabs' ); ?>
</div>

