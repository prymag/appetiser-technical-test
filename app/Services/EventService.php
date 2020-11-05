<?php

namespace App\Services;

use App\Models\EventDay;
use App\Models\Event;

class EventService
{
    protected $event;

    protected $event_days;

    public function __construct(
        Event $event,
        EventDay $event_days
    ) {
        $this->event = $event;
        $this->event_days = $event_days;
    }

    public function save($data)
    {
        $event = $this->saveEvent($data);
        $this->saveDays($event, $data['days_selected']);

        return $event;
    }

    protected function saveEvent($data)
    {
        $model = $this->event->make();
        $model->event_name = $data['event_name'];
        $model->date_start = $data['date_start'];
        $model->date_end = $data['date_end'];
        $model->save();

        return $model;
    }

    /**
     * @param Event $event
     * @param array $days
     * @return void
     */
    protected function saveDays($event, $days)
    {
        $event_days = array_map(function ($day) use ($event) {
            return $this->event_days->make([
                'event_id' => $event->id,
                'event_day' => $day
            ]);
        }, $days);

        $event->days()->saveMany($event_days);
    }
}
