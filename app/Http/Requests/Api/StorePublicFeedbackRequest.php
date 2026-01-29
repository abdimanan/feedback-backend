<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePublicFeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'overall_satisfaction' => ['nullable', 'integer', 'min:1', 'max:5'],
            'timeliness_delivery' => ['nullable', 'integer', 'min:1', 'max:5'],
            'communication_coordination' => ['nullable', 'integer', 'min:1', 'max:5'],
            'quality_final_outputs' => ['nullable', 'integer', 'min:1', 'max:5'],
            'professionalism_team' => ['nullable', 'integer', 'min:1', 'max:5'],
            'understanding_requirements' => ['nullable', 'integer', 'min:1', 'max:5'],
            'nps_score' => ['nullable', 'integer', 'min:0', 'max:10'],
            'deliverables_met_expectations' => ['nullable', Rule::in(['yes', 'no'])],
            'issues_resolved_quickly' => ['nullable', Rule::in(['yes', 'no', 'na'])],
            'comment' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'overall_satisfaction.integer' => 'Overall satisfaction must be a number.',
            'overall_satisfaction.min' => 'Overall satisfaction must be between 1 and 5.',
            'overall_satisfaction.max' => 'Overall satisfaction must be between 1 and 5.',
            'timeliness_delivery.integer' => 'Timeliness & delivery rating must be a number.',
            'timeliness_delivery.min' => 'Timeliness & delivery rating must be between 1 and 5.',
            'timeliness_delivery.max' => 'Timeliness & delivery rating must be between 1 and 5.',
            'communication_coordination.integer' => 'Communication & coordination rating must be a number.',
            'communication_coordination.min' => 'Communication & coordination rating must be between 1 and 5.',
            'communication_coordination.max' => 'Communication & coordination rating must be between 1 and 5.',
            'quality_final_outputs.integer' => 'Quality of final outputs rating must be a number.',
            'quality_final_outputs.min' => 'Quality of final outputs rating must be between 1 and 5.',
            'quality_final_outputs.max' => 'Quality of final outputs rating must be between 1 and 5.',
            'professionalism_team.integer' => 'Professionalism of team rating must be a number.',
            'professionalism_team.min' => 'Professionalism of team rating must be between 1 and 5.',
            'professionalism_team.max' => 'Professionalism of team rating must be between 1 and 5.',
            'understanding_requirements.integer' => 'Understanding requirements rating must be a number.',
            'understanding_requirements.min' => 'Understanding requirements rating must be between 1 and 5.',
            'understanding_requirements.max' => 'Understanding requirements rating must be between 1 and 5.',
            'nps_score.integer' => 'NPS score must be a number.',
            'nps_score.min' => 'NPS score must be between 0 and 10.',
            'nps_score.max' => 'NPS score must be between 0 and 10.',
            'deliverables_met_expectations.in' => 'Deliverables met expectations must be either yes or no.',
            'issues_resolved_quickly.in' => 'Issues resolved quickly must be either yes, no, or na.',
        ];
    }
}
