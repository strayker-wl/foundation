# Lumen Foundation Extensions

## Package contain

* classes:
  * **AbstractService** for service-layer pattern (user with repositories)
  * **AbstractRepository** for repository pattern
  * **ApiException** for present exception data for api
  * **Presenter** for presenter pattern
  * **FormRequest** for lumen
* Traits
  * **UsesUuid** trait for models with uuid primary key
  * **DefaultScopes** trait for get default scopes in models
  * **DefaultSlugValue** trait for generate slug from title or name
  * **RecursiveConfigMerge** trait for providers

## install
* install via composer
* register new providers

```php
$app->register(\Strayker\LumenFoundation\Providers\RequestServiceProvider::class); 
$app->register(\Strayker\LumenFoundation\Providers\LoggingServiceProvider::class); 
```

## how to use

### validation

1. create new request class:

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

2. inject request class into controller methods:

```php
class NewsController extends \App\Http\Controllers\Controller
{
    public function getNews(GetNewsRequest $request)
    {
        $validated = $request->validated(); // get result data as array after validation resolved
        // logic
    }
}
```

### presenters

1. create new presenter class

```php
namespace App\Http\Presenters;

use Strayker\LumenFoundation\Http\Presenters\AbstractPresenter;

class NewsListPresenter extends AbstractPresenter
{
    protected function resolve() : void{
        // prepare your resulted data for response
        //
        // for example, you can unset some keys from model
        // if you don't want display this keys in response,
        // or you can transform your result data for front-end api
    }
}
```

2. create new class instance and return in as result in controller method

```php
use App\Http\Presenters\NewsListPresenter;

class NewsController extends \App\Http\Controllers\Controller
{
    public function getNews(GetNewsRequest $request)
    {
        // logic
        return new NewsListPresenter($result);
    }
}
```
