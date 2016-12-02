# sportbox

Sportbox client-server parser

Requirements: PHP5+, Memcached, Jquery, Bootstrap 

http://rabota.cc/sportbox/Client.html - клиент 
http://rabota.cc/sportbox/r.php - сервер 
http://rabota.cc/sportbox/r.php?debug=1 (с флагом кэшированя для отладки)

- Сейчас кэш на сервере 20 секунд (задается в конфиге)
- Релоад на клиенте 10 секунд 
- Кросс-девайсность обеспечивается Twitter Bootstrap (при желании велосипеда или отказа от библиотеки, можно запились на media queries)
- AJAX Jquery (аналогично, если отказаться от Jquery, можно делать няпряму через xhttprequest)
 
Как развивать дальше / или для оптимизации и скейлинга:

- Парсинг отвязать от клиентского запроса в принципе (запускать к примеру по крону), чтобы когда будет много онлайнеров, при обновлении кэша не было затыка, и в кэше всегда были данные 
- Сейчас хранится сериализованное значение JSON в денормализованной форме (иного для задачи не нужно, тем более Memcached быстр) 
- Но если, допустим, захочется хранить историю в MySQL с выгрузками по дате/времени, можно дописать хранение в SQL и какие-то отчеты (например как в динамике завоевывались медали)
- Если в пик нагрузки, все упрется в базу (например при апдейте), можно сделать readonly-реплику, а если уж совсем много онлайнеров то и ее перевести на тип таблиц который хранятся в оперативной памяти  
- Можно ускорить на стороне сервера выполнение самого PHP, если начать использовать opcache например, чтобы каждый раз не компилировался исходник
- Дописать работу с заголоками, чтобы отдавался не text/html, а JSON тип (экономия)
- Включить gzip, при необходимости (сейчас включен) 
- Сейчас apache vhost, mod-php что не очень оптимально на больших нагрузках 
- Nginx даст возможность скейлить сервера приложений и балансировать нагрузку, и потенциал кэширования и защиты от DDOS
- Можно заюзать FCGI-менеджер для PHP (php-fpm) при необходимости
- В iptables отрезать все левые запросы к серверу (оставить только TCP/IP на 80 порту)
- Прописать robots.txt чтобы не хотили поисковые боты
- Сделать проверку по токену или заголовка, чтобы вообще не допускались чужие сапросы к серверу

Архитектурно возможно (для одного маленького класса это не актуально, особенно если вспомнить SOLID или YAGNI):

- Дописать систему с конфигами, оформить в класс 
- Сделать автолоадинг
- Вынести отдельно класс для обработчика ошибок 
- Аналогично для логов и дебага
- Выделить отдельно в класс даунлоадер (сейчас это просто file_get_contents) можно например со сменой на системный curl 
- Систему кэширования тоже можно вынести в отдельный класс (с возможностью выбора типа хранилища)
- Написать тесты для контроля работы парсера (коректность, недоступность)
- Реализовать Mock-объекты для тестов клиента
- Сделать уведомления о фейле тестов и контроль валидности, триггером привязать, если fail, то данные брать только из кэша (последние валидные), тем самым исключив ситуацию отдачи некорректных данных клиенту
- Можно реализовать контроль целостности передачи (просто например через md5 hash)
- Включить ssl, но это будет чуть затратнее для CPU