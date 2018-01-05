<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'cr42072_0');

/** Имя пользователя MySQL */
define('DB_USER', 'anton');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'bIt*rAD()');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'HftI*2ZPx@z=BDC(]hGtE)Y$8i*;El4gJ&*Qii?1}Pj7b5,{C1?%RM/5pCk|0$.s');
define('SECURE_AUTH_KEY',  'l3^et@I}-K5$$YH^r37c8FH))L#r>O2oz:QSH*8e4j0>^D.ql$w(t=,*K}!ZL~W.');
define('LOGGED_IN_KEY',    '~T&usr73w`hoYaxL1X{~!|S:IBakqB;Fn3rUIOM8d//x#@7M;x|%xNt2f,<0US>Q');
define('NONCE_KEY',        'e?2y4lQ~P[Z:kD>A?rq@7tYd7*Hs/TXN`rThD#Le,=h$k78J`S>a>4eaVf0EKKWI');
define('AUTH_SALT',        '!,Q}.MBYi{Cs/WRItl2~ZOd}}|m|j`i z$1t^4{S[A}[f;slYx*47U2duLgC.Z,_');
define('SECURE_AUTH_SALT', 'E5^B/ O{hdSz0goUMzBsT_R`)X?w,E /i{`i2uaWGDV3P$`8L-@S^l>AkF.kyJFx');
define('LOGGED_IN_SALT',   '!?.K>t-K.3AMuJu7%kDZ#6N5na)%Olxcr[k-JW_W*A@e0PBy;u^65qS!R-^cY 6y');
define('NONCE_SALT',       '*jZ%!}jV?bs hfMZ#yeTBZ](0KOkZ<cAtPX3n!3g%;zGGHt$?M=|#C F^@NSfbp2');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
