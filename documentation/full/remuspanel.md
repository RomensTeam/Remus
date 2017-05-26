[Документация Remus](https://github.com/RomensTeam/Remus/blob/documentation/documentation/index.md)
================

[Углубленое изучение](https://github.com/RomensTeam/Remus/tree/documentation/documentation/full) > RemusPanel
----
 
В **Remus** включен интересный инструмент разработчика - **RemusPanel**  

Данный инструмент даёт информацию полезную для тестрирования приложения.
Выводит много информации о состоянии приложения.


**Константы**

    // RemusPanel - boolean
    // FALSE (default) - не подключает RemusPanel
    // TRUE - включает RemusPanel
	define('REMUSPANEL', FALSE);
	

----------
**Использование**

    if(REMUSPANEL){
        RemusPanel::log($message, $type = 'default');
    }
	
В параметре `$message` вы можете разместить своё сообщение, которое после будет в логе RemusPanel.
В параметре `$type` указывается тип сообщения, которые могут быть:

* `success` - зеленый цвет
* `info` - синий цвет
* `warning` - желтый цвет

> Также `$message` поддерживает обработку Exception

----------

**Предупреждение**

> При использовании **RemusPanel** подключает Bootstrap.
