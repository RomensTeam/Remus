<?
// Этот модуль включает в себя Многоязычность приложения
$lang = $romens->app_lang($_GET['lang']);

echo '<h1>'.$lang['HELLO'].'</h1>';
echo '<pre>';
echo print_r($_SERVER);echo '<br>';
echo '</pre>';
?>
