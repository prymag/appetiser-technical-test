<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as Validator;

class EventsController extends Controller
{
    protected $validator;

    protected $event_service;

    public function __construct(
        EventService $event_service,
        Validator $validator
    ) {
        $this->event_service = $event_service;
        $this->validator = $validator;
    }

    protected function createValidtion(Request $request)
    {
        $rules = [
            'event_name' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'days_selected' => 'required'
        ];

        $messages = [
            'days_selected.required' => 'Please select atleast one day'
        ];

        $customAttributes = [
            'event_name' => 'event name',
            'date_start' => 'from',
            'date_end' => 'to'
        ];
        
        return $this->validator->make($request->all(), $rules, $messages, $customAttributes);
    }

    public function save(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $validation = $this->createValidtion($request);
        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'type' => 'validation',
                'errors' => $validation->errors()->all()
            ], 422);
        }

        $info = $this->event_service->save($request->all());

        if ($info) {
            $data['success'] = true;
            $data['event_info'] = $request->all();
        }
        return response()->json($data);
    }
}
