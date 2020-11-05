<?php

namespace App\Services;

use App\Models\EventDay;
use App\Models\Event;
use Illuminate\Database\DatabaseManager;

class EventService
{
    protected $db;

    protected $event;

    protected $event_days;

    public function __construct(
        DatabaseManager $db,
        Event $event,
        EventDay $event_days
    ) {
        $this->db = $db;
        $this->event = $event;
        $this->event_days = $event_days;
    }

    public function save($data)
    {
        $this->db->beginTransaction();
        try {
            $event = $this->saveEvent($data);
            $this->saveDays($event, $data['days_selected']);
            $this->db->commit();
            return $event;
        } catch (\Exception $e) {
            $this->db->rollback();
            throw $e;
        }
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
