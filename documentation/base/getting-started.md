[Документация Remus](https://github.com/RomensTeam/Remus/blob/documentation/documentation/index.md)
================

[База](https://github.com/RomensTeam/Remus/blob/documentation/documentation/index.md#i-%D0%91%D0%B0%D0%B7%D0%B0) > Быстрый старт
----

После установки вы можете приступить к работе с фреймворком. Зайдите на главную страницу. Перед вами должно выскочить окошко показывающее "**Время работы скрипта**"! Если нет угрожающих сообщений, то установка прошла правильно!

### Давайте приступим к работе! ###


Перейдите в `r-app/page/` и откройте файл `index.php`. Это исполняемый файл вашей главной страницы сайта.

Измените строчку 
	
	/* I AM READY */

на
	
	$array['heading'] = "I use Remus!";

Обновите страницу. Теперь вместо "Hello, World!" там надпись "I use Remus!".

