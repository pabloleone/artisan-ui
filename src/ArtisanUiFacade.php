<?php

namespace Pabloleone\ArtisanUi;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pabloleone\ArtisanUi\Skeleton\SkeletonClass
 */
class ArtisanUiFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'artisan-ui';
    }
}
