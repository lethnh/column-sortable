<?php

namespace Thanhlv\ColumnSortable;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;


class ColumnSortableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/columnsortable.php' => config_path('columnsortable.php'),
        ], 'config');

        Blade::directive('sortablelink', function ($expression) {
            $expression = ($expression[0] === '(') ? substr($expression, 1, -1) : $expression;

            return "<?php echo \Thanhlv\ColumnSortable\SortableLink::render(array ({$expression}));?>";
        });

        request()->macro('allFilled', function (array $keys) {
            foreach ($keys as $key) {
                if (!$this->filled($key)) {
                    return false;
                }
            }
            return true;
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/columnsortable.php', 'columnsortable');
    }
}
