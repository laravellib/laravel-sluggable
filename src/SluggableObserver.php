<?php

namespace codicastudio\sluggable;

use codicastudio\sluggable\Services\SlugService;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SluggableObserver.
 */
class SluggableObserver
{
    /**
     * @var \codicastudio\sluggable\Services\SlugService
     */
    private $slugService;

    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    private $events;

    /**
     * SluggableObserver constructor.
     *
     * @param \codicastudio\sluggable\Services\SlugService $slugService
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function __construct(SlugService $slugService, Dispatcher $events)
    {
        $this->slugService = $slugService;
        $this->events = $events;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool|null
     */
    public function saving(Model $model)
    {
        return $this->generateSlug($model, 'saving');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $event
     * @return bool|void
     */
    protected function generateSlug(Model $model, string $event)
    {
        // If the "slugging" event returns false, abort
        if ($this->fireSluggingEvent($model, $event) === false) {
            return;
        }
        $wasSlugged = $this->slugService->slug($model);

        $this->fireSluggedEvent($model, $wasSlugged);
    }

    /**
     * Fire the namespaced validating event.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $event
     * @return mixed
     */
    protected function fireSluggingEvent(Model $model, string $event)
    {
        return $this->events->until('eloquent.slugging: '.get_class($model), array($model, $event));
    }

    /**
     * Fire the namespaced post-validation event.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $status
     */
    protected function fireSluggedEvent(Model $model, string $status)
    {
        $this->events->dispatch('eloquent.slugged: '.get_class($model), array($model, $status));
    }
}
