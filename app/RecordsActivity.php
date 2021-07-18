<?php

namespace App;

use App\Models\Activity;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        if (auth()->check()) {
            foreach (static::getActivitieToRecord() as $event) {
                static::$event(function ($model) use ($event) {
                    $model->recordActivity($event);
                });
            }

            static::deleting(function ($model) {
                $model->activity()->delete();
            });
        }
    }

    protected static function getActivitieToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityName($event),
        ]);
    }

    protected function getActivityName($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$type}";
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
