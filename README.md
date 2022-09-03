# Laravel/Lumen Foundation Extensions

## Установка

1. установить с помощью композера
2. зарегистрировать провайдеры

Если необходимо кастомное логирование и обработка эксепшенов, необходимо зарегистрировать следующий провайдер самым
первым в списке.

```php
$app->register(\Strayker\LumenFoundation\Providers\LoggingServiceProvider::class);
```

Валидация, аналогичная FormRequest в ларавель для люмена:

```php
$app->register(\Strayker\LumenFoundation\Providers\RequestServiceProvider::class);  
```

Макросы для Arr

```php
$app->register(\Strayker\LumenFoundation\Providers\ArrMacroServiceProvider::class);  
```

3. Установить значения env

При использовании логгера из пакета используются следующие env:

* DEFAULT_LOG_FORMAT - формат логов, по умолчанию используется Strayker\Foundation\Loggers\Formatters\LineFormatter::
  FORMAT
* DEFAULT_LOG_TIME_FORMAT - формат даты логов, по умолчанию используется
  Strayker\Foundation\Loggers\Formatters\LineFormatter::DATE_FORMAT
* LOG_LEVEL - уровень логирования
* LOG_CHANNEL - канал логирования

В пакет заложена поддержка `stack`, `single` и `monolog-stdout` "из коробки"

4. Подключить кастомный роутер (при необходимости, только для lumen приложений)

В файле `bootstrap/app.php` заменить вызов приложения

```php
$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);
```

на

```php
$app = new Strayker\Foundation\App\LumenApplication(
    dirname(__DIR__)
);
```

## Использование

### Касты

Расширающие касты для моделей, реализующие работу с некоторыми типами PostgreSQL.

* PgArray - реализует работу с типом столбца array
* PgEnumArray - реализует работу со столбцами "array of enums"

Пример использования:

```php
use Strayker\Foundation\Casts\PgArray;
use Strayker\Foundation\Casts\PgEnumArray;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $casts = [
        'tags' => PgArray::class,
        'categories' => PgEnumArray::class,
    ];
}
```

### Эксепшены

При использовании кастомного логгера из пакета, все данные, переданные в $context эксепшена будут отображены в логе.

Все эксепшены, унаследованные от `Strayker\Foundation\Exceptions\Exception` автоматически обрабатываются хендлером
laravel.
Эксепшены, унаследованные от `Strayker\Foundation\Exceptions\ApiException` так же вернут корректный json в респонсе,
содержащий информацию об ошибке.
При выбросе эксепшена доступно больше опций, передаваемых в конструктор класса.

Есть готовые простые эксепшены, часто используемые в проектах. Они располагаются в Strayker\Foundation\Exceptions\Basic.

Пример использования:

1. Создать класс эксепшена

```php
namespace App\Exceptions;

use App\Contracts\Exceptions\BidDeclineCreate;
use Strayker\Foundation\Exceptions\ApiException;

class ConfigError extends ApiException implements BidDeclineCreate
{
    protected const DEFAULT_EXCEPTION_REASON = 'Ошибка конфигурации';
    protected const DEFAULT_EXCEPTION_NAME = 'config_error';
    protected const DEFAULT_EXCEPTION_CODE = 500;
}
```

2. Выбросить созданный эксепшен в требуемом месте

```php
if (empty(config('my-var'))) {
    throw new ConfigError(['request' => $request, 'some-debug-vars' => $value]);
}
```

### Фабрики

На данный момент доступна только одна фабрика - `Strayker\Foundation\Factories\AbstractModelFactory`.
Это имплементация фабрики моделей laravel с возможностью использования контракта модели вместо класса.
Используется для создания юнит-тестов.

### Валидация

1. Создать класс запроса:

```php
namespace App\Http\Requests;

use Strayker\LumenFoundation\Http\Requests\AbstractFormRequest;

class GetNewsRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'id' => "required|uuid",
        ];
    }
}
```

2. В методе контроллера типом параметра указать созданный класс:

```php
class NewsController extends \App\Http\Controllers\Controller
{
    public function getNews(GetNewsRequest $request)
    {
        $validated = $request->validated(); // Получить данные запроса после выполнения валидации

        // бизнес логика
    }
}
```

### Презентеры

Реализация паттерна presenter. Является альтернативой используемых в laravel классов Resource.

1. Создать класс презентера

```php
namespace App\Http\Presenters;

use Strayker\LumenFoundation\Http\Presenters\AbstractPresenter;

class NewsListPresenter extends AbstractPresenter
{
    protected function resolve() : void
    {
        // Здесь должна быть реализована логика заполнения $this->data на
        // основе $this->resource.
        //
        // Содержимое $this->data будет отправлено в респонсе.
        //
        // Например, передав в презентер модель, здесь можно убрать некоторые
        // ключи модели, которые не должны фигурировать в респонсе.
        // Так же здесь можно преобразовать любые данные в вид, который требуется
        // вернуть.
    }
}
```

3. Создать инстанс класса и вернуть его в контроллере

```php
use App\Http\Requests\GetNewsRequest;
use App\Http\Presenters\NewsListPresenter;

class NewsController extends \App\Http\Controllers\Controller
{
    public function getNews(GetNewsRequest $request): NewsListPresenter
    {
        // бизнес логика

        return new NewsListPresenter($result);
    }
}
```

### Правила валидации

На данный момент в пакет заложено только одно правило валидации - `Strayker\Foundation\Http\Rules\IsDouble`.
Позволяет проверить, что переданный параметр является числом с плавающей точкой либо целым числом.

### Модели

`Strayker\Foundation\Models\AbstractEloquentModel` - расширение стандартной модели.
По умолчанию включен трейт DateSerializer для корректного преобразования часового пояса в датах,
а так же запрещен lazy-load связей.

`Strayker\Foundation\Models\AbstractModel` - корневаяабстракция модели для реализации кастомных моделей в проекте (
например, DTO)

### Репозитории

Реализация патрерна repository для laravel.

Инкапсулирует все запросы в базу данных или в другие системы хранения информации.

Пример использования:

1) Создать репозиторий

```php
namespace App\Repositories;

use App\Contracts\Models\NewsContract;
use App\Contracts\Repositories\NewsRepositoryContract;
use Strayker\Foundation\Repositories\AbstractRepository;

class NewsRepository extends AbstractRepository implements NewsRepositoryContract
{
    public function getByAuthorId(string $authorId): ?NewsContract
    {
        return $this->model
            ->where('author_id', $authorId)
            ->first();
    }
}
```

2) Зарегистрировать класс в сервис провайдере

```php
namespace App\Providers;

use App\Contracts\Models as ModelContracts;
use App\Contracts\Repositories as RepositoryContracts;
use App\Contracts\Services as ServiceContracts;
use App\Models;
use App\Repositories;
use App\Services;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            RepositoryContracts\NewsRepositoryContract::class,
            fn() => $this->app->make(
                Repositories\NewsRepository::class,
                ['model' => $this->app->make(ModelContracts\NewsContract::class)]
            )
        );
    }
}
```

3) Использовать в требуемом месте

```php
$model = app(NewsRepositoryContract::class)->getByAuthorId($id);
```

### Сервисы

Реализация паттерна service layer.

Инкапсулирует всю бизнес логику приложения.

Пример использования:

1) Создать класс сервиса

```php
namespace App\Services\Forms;

use App\Contracts\Services\NewsServiceContract;

class NewsService extends AbstractService implements NewsServiceContract
{
    public function getById(string $id): NewsContract
    {
        // Произвольная бизнес логика.
        // Например, проверка прав доступа, кеширование результатов и т.п.
    }
}
```

2) Зарегистрировать класс в сервис провайдере

```php
namespace App\Providers;

use App\Contracts\Models as ModelContracts;
use App\Contracts\Repositories as RepositoryContracts;
use App\Contracts\Services as ServiceContracts;
use App\Models;
use App\Repositories;
use App\Services;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ServiceContracts\NewsServiceContract::class,
            fn() => $this->app->make(Services\NewsService::class)
        );
    }
}
```

3) Использовать в требуемом месте

```php
use App\Http\Requests\GetNewsRequest;
use App\Http\Presenters\NewsPresenter;
use App\Contracts\Services\NewsServiceContract;

class NewsController extends \App\Http\Controllers\Controller
{
    public function getNewsById(
        GetNewsRequest $request,
        NewsServiceContract $service
    ): NewsListPresenter {
        [
            'id' => $id,
        ] = $request->validated();
    
        return new NewsPresenter(
            $service->getById($id)
        );
    }
}
```

### Трейты

Все трейты-хелперы располагаются в неймспейсе Strayker\Foundation\Traits;
Во всех трейтах есть phpdoc описывающий поведение и назначение методов.

* BootTraits - позволяет инициализировать другие трейты, если в них есть метод boot<TraitName>
* DateSerializer - позволяет сохранять часовой пояс при сериализации/преобразовании в массив модели
* DependencyInjector - экспериментальный трейт для уменьшения кода при бинде зависимостей в сервис провайдере
* GenerateDefaultSlugValue - генерация символьного кода модели
* HasDefaultScopes - набор универсальных скоупов для моделей
* ParametersReplacer - позволяет заменять плейсхолдеры в тексте на значения из массива
* ProvidesFactory - трейт для уменьшения кода при использовании фабрик в юнит-тестах
* RecursiveConfigMerge - позволяет мержить конфигурации рекурсивно при регистрации пакетов
* UniqueTokenFormer - позволяет сформировать уникальный токен на основе переданной строки или uuid или расшифровать uuid
  из токена
    * может быть использован для формирования токена на основе uuid модели
* UsesUuid - трейт для использования в модели uuid как первичного ключа
