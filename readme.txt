== Установка/Обновление ==

<h2 style="text-align:center;color:#26901b;font-weight:bold;">Установка:</h2>

1. В админке вашего сайта перейдите на страницу "WP-Recall" -> "Шаблоны" и в самом верху нажмите на кнопку "Обзор", выберите .zip архив дополнения на вашем пк и нажмите кнопку "Установить".
2. В списке загруженных шаблонов, на этой странице, найдите это дополнение, наведите на него курсор мыши и нажмите кнопку "Подключить".


<h2 style="text-align:center;color:#26901b;font-weight:bold;">Обновление:</h2>
Дополнение поддерживает <a href="https://codeseller.ru/avtomaticheskie-obnovleniya-dopolnenij-plagina-wp-recall/" target="_blank">автоматическое обновление</a> - два раза в день отправляются вашим сервером запросы на обновление.
Если в течении суток вы не видите обновления (а на странице дополнения вы видите что версия вышла новая), советую ознакомиться с этой <a href="https://codeseller.ru/post-group/rabota-wordpress-krona-cron-prinuditelnoe-vypolnenie-kron-zadach-dlya-wp-recall/" target="_blank">статьёй</a>




== FAQ ==

<h3 style="color:#26901b;font-weight:bold;">Есть настройки?</h3>
-Да.
Переходим в админке: WP-Recall -> Настройки -> Настройки Theme Control
опция для включения кастомайзера.
опция для включения показа аватарки

<hr style="border:1px solid #ddd;margin:18px;">



<h3 style="color:#26901b;font-weight:bold;">Есть области виджетов?</h3>
- Да. Личный кабинет регистрирует 2 области виджетов - над ЛК и под ним.
Переходите в админке: Внешний вид -> Виджеты
RCL: Сайдбар над личным кабинетом
и
RCL: Сайдбар под личным кабинетом

Можно разместить там любой виджет или произвольный текст

<hr style="border:1px solid #ddd;margin:18px;">



<h3 style="color:#26901b;font-weight:bold;">В описании: "поддержка горизонтального и вертикального вывода кнопок меню" - где это найти?</h3>

Тема поддерживает как горизонтальные кнопки (над ЛК), так и вертикальные кнопки (слева)
Переходим в админке: WP-Recall -> Настройки -> Общие настройки
Находим "Размещение кнопок вывода вкладок" и выставляем нужное расположение кнопок ЛК.
<a href="https://yadi.sk/i/NJeL7ExqjtKeOA" target="_blank">Скриншот</a>

<hr style="border:1px solid #ddd;margin:18px;">



<h3 style="color:#26901b;font-weight:bold;">Включил кастомайзер. Где его найти чтоб настроить цвета?</h3>
Переходите в админке: Внешний вид -> Настроить -> Настройки Theme Control
Справа переходите в ЛК и производите настройку цветовой палитры кабинета.

<hr style="border:1px solid #ddd;margin:18px;">



<h3 style="color:#26901b;font-weight:bold;">Мне не нужен всплывающий блок автора. Но нужна информация о пользователе на виду. Есть варианты?</h3>
Да - ниже в вопросе как раз один из вариантов - премиум дополнение <a href="https://codeseller.ru/products/user-info-tab/" target="_blank">User Info Tab</a>

Есть и второй вариант - дополнение <a href="https://codeseller.ru/products/display-profile-field/" target="_blank">Display Profile Field</a>
- с его помощью можно вывести данные полей профиля вверху ЛК под именем пользователя.

А кнопку вызова всплывающего блока автора можете отключить через настройки.

<hr style="border:1px solid #ddd;margin:18px;">



<h3 style="color:#26901b;font-weight:bold;">Внешний вид не тот, что на видео</h3>
- Установив дополнение <a href="https://codeseller.ru/products/user-info-tab/" target="_blank">User Info Tab</a> - вы увидите всё как на видео.

<hr style="border:1px solid #ddd;margin:18px;">



<h3 style="color:#26901b;font-weight:bold;">Какие дополнения нужно установить, чтобы было как на видео?</h3>
- Это дополнение: <a href="https://codeseller.ru/products/user-info-tab/" target="_blank">User Info Tab</a> - и перейдите на страницу этого дополнения - во вкладке FAQ я отвечу на данный вопрос.

<hr style="border:1px solid #ddd;margin:18px;">



<h3 style="color:#26901b;font-weight:bold;">Нажимаю на имя - страница перезагружается, что нужно сделать чтобы был ajax переход?</h3>
- Этот функционал включен в дополнение <a href="https://codeseller.ru/products/user-info-tab/" target="_blank">User Info Tab</a>

<hr style="border:1px solid #ddd;margin:18px;">



<h3 style="color:#26901b;font-weight:bold;">Есть демо?</h3>
- Да: <a href="http://theme-control.otshelnik-fm.ru/" target="_blank">здесь</a>

<hr style="border:1px solid #ddd;margin:18px;">



<h3 style="color:#26901b;font-weight:bold;">Как добавить новую ссылку в меню автора?</h3>

Для добавления туда своего пункта меню можно воспользоваться фильтром 
```
apply_filters( 'tcl_user_items', $data, $user_lk );
```
где 
$data       строка
$user_lk    id владельца кабинета

Используйте этот сниппет:

```
add_filter( 'tcl_user_items', 'my_author_menu_item_add_publication', 60 );
function my_author_menu_item_add_publication( $data ) {
    $datas['my_uniq_id'] = [
        'url'   => '/add-new-post-url', // урл назначения
        'icon'  => 'fa-pencil',         // иконка https://fontawesome.com/v4.7.0/icons/
        'label' => 'Новая запись',      // текст ссылки
    ];

    $data .= tcl_author_menu_add_item( $datas );

    return $data;
}
```

где <code>$datas['my_uniq_id']</code> ваш уникальный id элемента (будет id для элемента)
Помимо ключей массива 'url', 'icon', 'label' можно передать и 'class' - передаст дополнительный класс элементу

<a href="https://yadi.sk/i/tZ-N9cgocNUYVg" target="_blank">результат</a>


приоритет фильтра 60 - говорит нам что пункт нужно добавить в самый конец списка.
Текущие приоритеты у существующих пунктов следующие:
"Загрузить аватарку" 12
"Редактировать профиль" 24
"В админку" 36
"Выход" 48

Также для добавления пунктов внутри фильтра не обязательно использовать функцию <code>tcl_author_menu_add_item()</code> 
- она лишь стандартизирует вёрстку. Если вам нужно передать туда свой html - посмотрите как это сделано в inc/author-menu.php дополнения в функции 
<code>tcl_author_menu_item_ava()</code> 

<hr style="border:1px solid #ddd;margin:18px;">



<h3 style="color:#26901b;font-weight:bold;">"Редактировать профиль" есть в меню автора. Как мне его убрать из вкладок?</h3>

Этот функционал заложен в ядре WP-Recall в менеджере вкладок.

В админке переходим: WP-Recall -> Менеджер вкладок 
и там выставляем нужной вкладке (Профиль) опцию "Скрытая вкладка - Да". Она исчезнет из списка вкладок, но будет доступна по ссылке из меню автора.
<a href="https://yadi.sk/i/0Fef2wkjPCXMKQ" target="_blank">Скриншот</a>

<hr style="border:1px solid #ddd;margin:18px;">





== Changelog ==
= 2020-03-24 =
v2.0.1
* Пропавшие переводы - вернул ))


= 2020-03-24 =
v2.0.0
* В настройках дополнения появилась возможность включить показ аватарки в ЛК

* Добавлена опция в настройки "Показываем статус в ЛК" - выведет в одну строку статус пользователя. 
Если не умещается - по наведению на строку сможете прочитать весь текст.

* В настройках дополнения появилась возможность отключить кнопку вызова всплывающего блока "Подробная информация". 
Полезно например если у вас стоит дополнение <a href="https://codeseller.ru/products/display-profile-field/" target="_blank">Display Profile Field</a>

* В настройках появилась возможность выбрать вид кнопок из представленных вариантов. 

* Возможность задать радиус скругления кнопкам.

* Переосмыслена вёрстка. Если изменяли шаблон office.php - стоит сравнить и актуализировать.

* Изменена вёрстка по стандарту 6px

* Поведение всплывающих меню приведены к единому стандарту (меню автора и меню вызова вкладок)

* В "меню автора" (всплывающее меню рядом с именем хозяина ЛК) - пункты меню переведены на фильтры с приоритетеами. 
Для добавления туда своего пункта меню можно воспользоваться фильтром: 
```
apply_filters( 'tcl_user_items', $data, $user_lk );
```
Пример использования смотрите в вкладке FAQ

* Добавлена поддержка локализаций и дополнение поддерживает русский язык и английский

* хук <code>tc_pre_username</code> переименован в <code>tcl_pre_username</code>




= 2019-10-07 =
v1.4.0
* поддержка дополнения <a href="https://codeseller.ru/products/friends-cabinet-access/" target="_blank">Friends Cabinet Access</a>
- не закрывался блок "Подробная информация"
* исправлены php уведомления уровня notice


= 2018-11-15 =
v1.3.0
* поддержка WP-Recall 16.16
* минимизация скриптов и стилей


= 2017-11-25 =
v1.2.1
* Исправлено "моргание" контента вкладки при ajax-загрузке таба в фаерфоксе  


= 2017-11-14 =
v1.2
* Добавлен хук <code>tcl_pre_username</code> - позволяет в шапке перед именем выводить что-то.
Я у себя немного кастомизировал и вывел там аватарку юзера - повесил на этот хук <code>echo get_avatar($user_LK, 40);</code>


= 2017-09-04 =
v1.1.1
* Небольшие изменения


= 2017-03-06 =
v1.1
* Работа с 16-й версией WP-Recall


= 2017-03-06 =
v1.0
* Release




== Поддержка и контакты ==

* Поддержка осуществляется в рамках текущего функционала дополнения
* При возникновении проблемы, создайте соотвествующую тему на <a href="https://codeseller.ru/forum/product-14506/" target="_blank">форуме поддержки</a> товара
* Если вам нужна доработка под ваши нужды - вы можете обратиться ко мне в <a href="https://codeseller.ru/author/otshelnik-fm/?tab=chat" target="_blank">ЛС</a> с техзаданием на платную доработку.

Все мои работы опубликованы <a href="https://otshelnik-fm.ru/?p=2562&utm_source=free-addons&utm_medium=addon-description&utm_campaign=theme-control&utm_content=codeseller.ru&utm_term=all-my-addons" target="_blank">на моём сайте</a> и в каталоге магазина <a href="https://codeseller.ru/author/otshelnik-fm/?tab=publics&subtab=type-products" target="_blank">CodeSeller.ru</a>
