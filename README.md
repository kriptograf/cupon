# cupon
Сайт купонов и скидок + каталог компаний + упрощенная доска объявлений

##Установка
- Распаковать в корневую директорию сайта.
- Создать базу данных
- Применить дамп базы данных kupon.sql
- Изменить настройки в файлк конфигурации


```php
'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=ВАША_БД',
            'emulatePrepare' => true,
            'username' => 'LOGIN',
            'password' => 'PASSWORD',
            ...
),
```
