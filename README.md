# Documentation

This library provides a middleware object that allows developpers to query for memory usage of laravel requests. The middleware can be registered globally making it to run on each request or attached to a specific route using middleware aliases.

By default it does nothing with the logged memory information. In order to write it to disk or to application database, developpers must provided event listeners that attached to `Drewlabs\Laravel\Memory\Usage\Log` class as follow:

```php

// MyMemoryLogListener.php

class MyMemoryLogListener
{
    /**
     * Handle the event.
     */
    public function handle(\Drewlabs\Laravel\Memory\Usage\Log $log): void
    {
        // Note: returned value by each of these functions are of type AllocatedMemory{usedMemory, requestedMemory}
        $alloc1 = $log->getInitialMemoryAllocation(); // memory allocation before handling the request [memory consumed by laravel initialization classed and function ]
        $alloc2 = $log->getCurrentMemoryAllocation(); // $alloc2 = $alloc1 + memory consume by the actual request handler

        $diff = $log->getHandlersConsumedMemory(); // Compute the difference $diff = $alloc1 - $alloc 2

        // Do something with the logged information
    }
}

// Then we bind the event listener to the log event instance in our application service provider

// EventServiceProvider.php

use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseServiceProvider;

class EventServiceProvider extends BaseServiceProvider
{
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array<class-string, array<int, class-string>>
	 */
	protected $listen = [
		\Drewlabs\Laravel\Memory\Usage\Log::class => [
			\App\Listeners\MyMemoryLogListener::class
		],
	];

	/**
	 * Register application services.
	 * 
	 *
	 * @return void
	 */
	public function register()
	{
        // Call the event service provider instance
		parent::register();
    }
}
```
