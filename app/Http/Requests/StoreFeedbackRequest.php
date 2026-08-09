<?php

namespace App\Http\Requests;

use App\Models\Feedback;
use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $aspiration = $this->route('aspiration');

        return $aspiration && (auth()->user()->isAdmin() || $aspiration->user_id === auth()->id());
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'pesan' => ['required', 'string'],
            'parent_id' => [
                'nullable',
                'exists:feedbacks,id',
                function ($attribute, $value, $fail) {
                    $aspiration = $this->route('aspiration');
                    if ($aspiration) {
                        $parentExists = Feedback::where('id', $value)
                            ->where('aspiration_id', $aspiration->id)
                            ->exists();
                        if (! $parentExists) {
                            $fail('Feedback parent tidak valid.');
                        }
                    }
                },
            ],
        ];
    }
}
