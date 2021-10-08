# HDRezka backend API

Backend API с парсером для сайта hdrezka.ag

## Лицензия

Данное программное обеспечение распространяется под лицензией [MIT license](https://opensource.org/licenses/MIT).


## Развертывание проекта

1. Установка git submodules<br>
    `git submodule update --init --recursive`
2. Скопировать файл с переменными среды<br>
    `cp .env.example .env`
3. Перейти в директорию laradock и скопировать файл с переменными среды<br>
    `cd laradock && cp .env.example .env`
4. В .env файле выставить значения
    ```
    DATA_PATH_HOST=../.laradock/data        # по желанию указать путь к директории с данными для контейнеров docker
    COMPOSE_PROJECT_NAME=hdrezka            # будет использоваться в качестве префикса для docker контейнеров проекта
    PHP_VERSION=8.0
    MYSQL_VERSION=latest
    ```
5. Выполнить сборку и развертывание контейнеров nginx, mysql<br>
    `docker-compose up -d nginx mysql`
6. Перейти в контейнер<br>
    `docker-compose exec -u laradock workspace bash`
7. Установить зависимости composer<br>
    `composer install`
После успешного выполнения всех шагов при переходе в браузере [http://localhost/](http://localhost/) выведет приветствие lumen фреймворка.

## API документация
#### Version: 1.0.0

**Contact information:**  
arthur.ragimov@gmail.com  

### /search

#### POST
##### Summary

Запрос на поиск

##### Description

Выполняет запрос поиска на сайт hdrezka, парсит страницу поиска и отдаёт json ответ с результатами поиска

##### Parameters

| Name | Located in | Description | Required | Schema |
| ---- | ---------- | ----------- | -------- | ---- |
| body | body |  | Yes | object |

##### Responses

| Code | Description | Schema |
| ---- | ----------- | ------ |
| 200 | OK | [SearchRequest](#searchrequest) |
| 422 | Unprocessable Entity | [UnprocessableEntity](#unprocessableentity) |

### /search/{searchRequestId}

#### GET
##### Summary

Получение данных запроса поиска по его ID

##### Description

Возвращает данные запроса поиска на hdrezka

##### Parameters

| Name | Located in | Description | Required | Schema |
| ---- | ---------- | ----------- | -------- | ---- |
| searchRequestId | path | ID запроса поиска | Yes | long |

##### Responses

| Code | Description | Schema |
| ---- | ----------- | ------ |
| 200 | successful operation | [SearchRequest](#searchrequest) |
| 404 | Not Found |  |

### /page

#### POST
##### Summary

Запрос на получение видео со страницы фильма

##### Description

Выполняет парсинг страницы с фильмом и возвращает результат в json

##### Parameters

| Name | Located in | Description | Required | Schema |
| ---- | ---------- | ----------- | -------- | ---- |
| body | body |  | Yes | object |

##### Responses

| Code | Description | Schema |
| ---- | ----------- | ------ |
| 200 | OK | [PageRequest](#pagerequest) |
| 422 | Unprocessable Entity | [UnprocessableEntity](#unprocessableentity) |

### /page/{pageRequestId}

#### GET
##### Summary

Получение данных запроса страница по её ID

##### Description

Возвращает данные запроса страницы на hdrezka

##### Parameters

| Name | Located in | Description | Required | Schema |
| ---- | ---------- | ----------- | -------- | ---- |
| pageRequestId | path | ID запроса страницы | Yes | long |

##### Responses

| Code | Description | Schema |
| ---- | ----------- | ------ |
| 200 | successful operation | [PageRequest](#pagerequest) |
| 404 | Not Found |  |

### Models

#### UnprocessableEntity

| Name | Type | Description | Required |
| ---- | ---- | ----------- | -------- |
| UnprocessableEntity | array |  |  |

#### SearchRequest

| Name | Type | Description | Required |
| ---- | ---- | ----------- | -------- |
| id | long |  | No |
| query | string |  | No |
| payload | [SearchRequestPayload](#searchrequestpayload) |  | No |
| status | string | Статус запроса на поиск<br>_Enum:_ `"created"`, `"processing"`, `"done"`, `"error"` | No |
| created_at | string |_Example:_ `"2021-10-03T22:00:07.000000Z"` | No |
| updated_at | string |_Example:_ `"2021-10-03T22:00:07.000000Z"` | No |

#### SearchRequestItem

| Name | Type | Description | Required |
| ---- | ---- | ----------- | -------- |
| url | string | Ссылка на фильм на сайте hdrezka<br>_Example:_ `"https://rezka.ag/films/fantasy/41834-snova-privet-1987.html"` | No |
| name | string | Название фильма<br>_Example:_ `"Снова привет"` | No |
| type | string | Тип ресурса (на данный момент поддерживается только "films")<br>_Enum:_ `"films"`<br>_Example:_ `"films"` | No |
| image | string | Ссылка на изображение постера<br>_Example:_ `"https://static.hdrezka.ac/i/2021/9/19/r664889dc807fud75o25d.jpg"` | No |
| addition | string | Дополнительная информация по фильму<br>_Example:_ `"1987, США, Фэнтези"` | No |

#### SearchRequestPayload

| Name | Type | Description | Required |
| ---- | ---- | ----------- | -------- |
| SearchRequestPayload | array |  |  |

#### PageRequest

| Name | Type | Description | Required |
| ---- | ---- | ----------- | -------- |
| search_request_id | long | ID запроса на поиск | No |
| url | string | Ссылка на фильм<br>_Example:_ `"https://rezka.ag/films/fantasy/41834-snova-privet-1987.html"` | No |
| type | string | Тип ресурса (на данный момент поддерживается только "films")<br>_Enum:_ `"films"`<br>_Example:_ `"films"` | No |
| payload | [PageRequestPayload](#pagerequestpayload) |  | No |
| status | string | Статус запроса на парсинг страницы с фильмом | No |

#### PageRequestPayload

| Name | Type | Description | Required |
| ---- | ---- | ----------- | -------- |
| PageRequestPayload | array |  |  |

#### PageRequestItem

| Name | Type | Description | Required |
| ---- | ---- | ----------- | -------- |
| resolution | string | Разрешение видео<br>_Example:_ `"360p"` | No |
| url | string | Прямая ссылка на видео<br>_Example:_ `"https://stream.voidboost.cc/3/7/6/9/8/8/ebbad219ee853a9ef1e68cdf9df87381:2021100517:2e179457-952a-4834-a712-0fcaa5358126/bie1b.mp4"` | No |