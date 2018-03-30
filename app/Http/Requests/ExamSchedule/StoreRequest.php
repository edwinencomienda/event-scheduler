<?php

namespace App\Http\Requests\ExamSchedule;

use App\ExamSchedule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i',
            'proctor_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $schedule = ExamSchedule::whereDate('date', $this->date)
            ->where('subject_id', $this->subject_id)
            ->where('room_id', $this->room_id)
            ->where('time_start', $this->time_start)
            ->where('time_end', $this->time_end)
            ->first();
            if ($schedule) {
                $validator->errors()->add('schedule', 'This is schdule is not available.');
            }
        });
    }

}
