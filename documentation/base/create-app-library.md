[Документация Remus](https://github.com/RomensTeam/Remus/blob/documentation/documentation/index.md)
================

[База](https://github.com/RomensTeam/Remus/blob/documentation/documentation/index.md#i-%D0%91%D0%B0%D0%B7%D0%B0) > Работа с библиотеками
----

Работа с библиотеками в Remus является не сложной задачей.
Если вы знакомы с [PSR-0](https://github.com/dotzero/fig-standards/blob/master/accepted/ru/PSR-0.md "PSR-0") то проблем у вас с этой задачей не возникнет.

## С помощью автозагрузчика ##

Самый простой способ - использование автозагрузчика.

Поместите свои библиотеки в **DIR_LIB** (по умолчанию: `Remus/r-app/lib/`).

И автозагрузчик совместимый со стандартом [PSR-0](https://github.com/dotzero/fig-standards/blob/master/accepted/ru/PSR-0.md "PSR-0") загрузит необходимый класс.