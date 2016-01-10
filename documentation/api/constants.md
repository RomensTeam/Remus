[Документация Remus](https://github.com/RomensTeam/Remus/blob/documentation/documentation/index.md)
================

[API](https://github.com/RomensTeam/Remus/blob/documentation/documentation/index.md#iii-api) > Работа с библиотеками
----

|        Константа       |                         Значение по умолчанию                        | Изменение | Описание |
|:----------------------:|:--------------------------------------------------------------------:|:---------:|:--------:|
|        TEST_MODE       |                                 FALSE                                |Разрешено| Флаг режима тестирования.|
|           URL          |                    http:// $_SERVER['HTTP_HOST'] /                   |Разрешено| Адрес сайта|
|           WWW          |                                 TRUE                                 | Разрешено| Оставлять ли доступ к сайту через www.example.com|
|       LOAD_MODEL       |                                 TRUE                                 | Не рекомендуется|Флаг загрузки модели|
|        NOT_INDEX       |                                 TRUE                                 | Разрешено|Флаг доступа к index.php|
|     BASE_CONFIG_PHP    |                                 FALSE                                | Разрешено|          |
|          BASE          |                                 MySQL                                | Разрешено|          |
|       BASE_DRIVER      |                                 MySQL                                | Разрешено|          |
|       BASE_NUMBER      |                                   1                                  | Разрешено|          |
|        COMPRESS        |                                 FALSE                                | Разрешено|          |
|         CHARSET        |                                 UTF-8                                | Разрешено|          |
|        BASE_HOST       |                               localhost                              | Разрешено|          |
|        BASE_PATH       |                         r-app/base/mybase.php                        | Разрешено|          |
|       BASE_LOGIN       |                                 root                                 | Разрешено|          |
|        BASE_PASS       |                                (empty)                               | Разрешено|          |
|       BASE_PREFIX      |                                (empty)                               | Разрешено|          |
|        BASE_PORT       |                                 3306                                 | Разрешено|          |
|        BASE_BASE       |                                mybase                                | Разрешено|          |
|         ROUTER         |                               DYNAMIC2                               | Разрешено|          |
|    NOT_ROUTING_FILE    |                                404.php                               | Разрешено|          |
|     APP_LANG_METHOD    |                               JSON_FILE                              | Разрешено|          |
|     APP_LANG_FORMAT    |                                 JSON                                 | Разрешено|          |
|     APP_LANG_PREFIX    |                                (empty)                               | Разрешено|          |
|    APP_LANG_PATTERN    |                                (empty)                               | Разрешено|          |
|      APP_LANG_EXT      |                                 json                                 | Разрешено|          |
|      APP_VIEW_HTML     |                                 View                                 | Разрешено|          |
|        APP_MODEL       |                                 Model                                | Разрешено|          |
|      LAYOUT_FOLDER     |                                 page                                 | Разрешено|          |
|       THEME_FILE       |                              theme.json                              | Разрешено|          |
|   SUPPORT_DEVELOPERS   |                                 TRUE                                 | Не рекомендуется|          |
|    VIEW_TAG_PATTERN    |                         /{\[([A-Z0-9_]+)\]\}/                        | Не рекомендуется|          |
| VIEW_BLOCK_TAG_PATTERN |                      /{\[BLOCK_([A-Z0-9_]+)\]\}/                     | Не рекомендуется|          |
|   FOREACH_TAG_PATTERN  | /\{\[FOREACH\(([A-Z0-9_]+)\)\:START\]\}([^\:]+)\{\[FOREACH\:END\]\}/ | Не рекомендуется|          |
|    FILL_TAG_PATTERN    |                   /\{\[(.*)\]\|\[([A-Z0-9_]+)\]\}/                   | Не рекомендуется|          |
| FILL_ALTER_TAG_PATTERN |                                  ???                                 | Разрешено|          |
|   VIEW_BLOCK_TAG_NAME  |                                BLOCK_                                | Не рекомендуется|          |
|  VIEW_BLOCK_TAG_FOLDER |                                 block                                | Разрешено|          |
|      VIEW_EXP_FILE     |                                  tpl                                 | Разрешено|          |
|     VIEW_TAG_START     |                                  {[                                  |Не рекомендуется|          |
|      VIEW_TAG_END      |                                  ]}                                  |Не рекомендуется|          |
|          LANG          |                                  en                                  |Разрешено|          |
|          URLS          |                                (mixed)                               |Генерирует фреймворк|          |
|          HTTPS         |                               (boolean)                              |Генерирует фреймворк|          |
|          AJAX          |                               (boolean)                              |Генерирует фреймворк|          |
