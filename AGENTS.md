# AGENTS.md

Учебный блог на Laravel 13 (посты, категории, комментарии), PHP 8.4 + SQLite. Интерфейс и сообщения валидации на русском; новые пользовательские тексты добавляйте на русском.

## Команды

- `composer setup` — первоначальная установка (`.env`, ключ, миграции, `npm install`, `npm run build`). Сиды не запускает.
- `composer dev` — запускает `php artisan dev`: `artisan serve` на http://localhost:8000, `queue:listen` и Vite.
- `php artisan test` (или `composer test`, который предварительно очищает конфиг). Один файл: `php artisan test tests/Feature/ExampleTest.php`; фильтр: `php artisan test --filter=partialName`.
- `vendor/bin/pint путь/к/Файлу.php` — кодовая база не отформатирована Pint, поэтому не запускайте Pint по всему репозиторию без просьбы. Здесь нет git-репозитория, поэтому `--dirty` недоступен.
- Если `database/database.sqlite` отсутствует (он в `.gitignore`), создайте его перед миграциями: `New-Item database/database.sqlite` в PowerShell (или `touch`), затем `php artisan migrate --seed`.
- Если изображения постов возвращают 404, выполните `php artisan storage:link`; `public/storage` — игнорируемая git-связка (junction) в Windows.

## Данные и авторизация

- База SQLite: `database/database.sqlite`. Тесты используют SQLite в памяти из `phpunit.xml`, а не этот файл.
- `php artisan migrate --seed` создаёт 250 постов, 8 категорий, комментарии и логины `admin@admin.ru` / `123` (админ) и `user@user.ru` / `123`.
- `DatabaseSeeder` сначала очищает таблицы users, posts, categories и comments — не запускайте сиды поверх данных, которые нужны.
- Маршрута регистрации нет. Вход — `/login`; GET-маршрут называется `auth.login`, POST-маршрут — `login`.

## Устройство приложения

- `routes/web.php` — единственный файл веб-маршрутов: публичные `posts.*`, авторизованные `my-posts.*` (PostPolicy), админские `admin.*` (auth + алиас `is_admin` из `bootstrap/app.php`), home и about.
- Комментарии: `POST /posts/{post}/comments` (`comments.store`, middleware `auth`) → `CommentController@store`; колонка в БД — `comments.comment`, форма — в `posts/show.blade.php`.
- Фильтры `posts.index` (spatie/laravel-query-builder): `filter[category]`, `filter[user]` — exact, можно несколько ID через запятую; `filter[title]` — поиск подстроки. Пагинация сохраняет параметры через `withQueryString()`. В Query Builder v7 `allowedFilters()` принимает фильтры вариативно, не массивом.
- Представления — Blade в `resources/views`, наследуют `layouts.main` или `layouts.admin`. Стили — статический `public/css/style.css`; ни одно Blade-представление не использует `@vite`, поэтому изменения в `resources/css/app.css` или `resources/js/app.js` сейчас не влияют на страницы.
- Изображения хранятся на диске `public` (`storage/app/public`) по путям вида `posts/xxx.jpg` и выводятся через `Storage::url($post->image)`. Сейчас загрузку сохраняет только `MyPostController`.
- `App\Http\Controllers\Controller` пуст, хотя импортирует `AuthorizesRequests`; вызывайте `Gate::authorize(...)` или подключите трейт перед использованием `$this->authorize()`.
- В `User` используются атрибуты Laravel 13 `#[Fillable]`/`#[Hidden]`; в остальных моделях — массивы `$fillable`. Следуйте локальному стилю.

## Тесты

- PHPUnit 12, не Pest. Наборы — `tests/Unit` и `tests/Feature`; `phpunit.xml` принудительно задаёт SQLite в памяти, array-хранилища кеша/сессий/почты и sync-очередь.
- Кроме стандартных примеров есть `tests/Feature/CommentTest.php` (комментарии) и `tests/Feature/PostFilterTest.php` (фильтры и сохранение параметров в пагинации). Определена только `UserFactory`; создавайте `Post`/`Category`/`Comment` через модели или добавляйте фабрики.

## Текущие пробелы

- Пункт 1 из `dz.txt` (комментарии) реализован. Остались: изображения в админке (п. 2), несколько изображений у поста через многие ко многим (п. 3), загрузка перетаскиванием (п. 4).
- В админских формах постов нет поля изображения, а `Admin\PostController` не сохраняет загрузки.
- `PostPolicy::delete()` проверяет `$user->isAdmin` (несуществующее свойство); нужно `is_admin`, иначе удалять посты смогут только админы.
