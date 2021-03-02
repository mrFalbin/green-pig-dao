## green-pig-dao

**GreenPig** (далее **GP**) – это небольшой помощник для работы с базой данных, который может дополнить функциональность любого, используемого вами php фреймворка (в том числе и самописного =) ).

Как и любой инструмент GP заточен под решение определенных задач. Он будет вам полезен, если вы предпочитаете писать запросы к БД на чистом sql и не используете Active record и прочие подобные технологии.

Но при таком подходе встает вопрос: как генерировать where часть sql запроса при поиске пользователями информации? **GP** нацелен, в первую очередь, на удобное составление средствами php where запроса любой сложности.

Также **GP** позволяет решать следующие задачи:

Во-первых, это получение не стандартного плоского ответа из БД, а вложенного, древовидного массива. И конечно при этом удобная пагинация и сортировка: `->pagination(1, 10)->sort('id')`.

Во-вторых если в БД хранятся некие сущности, и свойства этих сущностей динамические и задаются пользователями, то, когда вам понадобится поискать сущности по их свойствам, вам придется добавлять (join’ить) одну и туже таблицу со значениями свойств (столько же раз, сколько используется свойств при поиске). **GP** поможет вам и подключить все таблицы и сгенерировать where запрос практически одной функцией, подробнее в [документации](https://falbin.ru/documentation/greenpig/query.php#whereWithJoin).

В третьих GP может работать как с БД Oracle, так и с mySql.

Также есть еще ряд возможностей, описанных в документации.

## Установка

Библиотеку можно установить через composer: `composer require falbin/green-pig-dao`

Затем необходимо написать фабрику, через которую будете пользоваться данной библиотекой.

Подробнее в [документации](https://falbin.ru/documentation/greenpig/installation.php).