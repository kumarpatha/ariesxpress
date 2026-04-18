<?php

namespace App\Http\Controllers;

use App\Mail\PublicInquiryMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PublicInquiryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $formType = $request->input('form_type', 'contact');

        $validator = Validator::make(
            $request->all(),
            $this->rules($formType),
            [],
            [
                'user_name' => 'name',
                'user_phone' => 'phone number',
                'user_email' => 'email',
                'user_city' => 'city',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please fill in all required fields correctly.',
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $payload = [
            'form_type' => $formType,
            'user_name' => trim((string) $request->string('user_name')),
            'user_phone' => trim((string) $request->string('user_phone')),
            'user_email' => trim((string) $request->string('user_email')),
            'user_city' => trim((string) $request->string('user_city')),
            'subject' => trim((string) $request->string('subject')),
            'message' => trim((string) $request->string('message')),
            'query' => trim((string) $request->string('query')),
        ];

        try {
            Mail::to(config('mail.contact_to', 'info@ariesxpress.com'))
                ->send(new PublicInquiryMail($payload));

            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your ' . ($formType === 'quote' ? 'quote request' : 'message') . ' has been sent successfully. We will contact you soon.',
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error sending your ' . ($formType === 'quote' ? 'quote request' : 'message') . '. Please try again or contact us directly at info@ariesxpress.com',
            ], 500);
        }
    }

    private function rules(string $formType): array
    {
        $rules = [
            'form_type' => ['nullable', 'in:contact,quote'],
            'user_name' => ['required', 'string', 'max:255'],
            'user_phone' => ['required', 'string', 'max:50'],
            'user_email' => ['required', 'email', 'max:255'],
            'user_city' => ['required', 'string', 'max:255'],
        ];

        if ($formType === 'quote') {
            $rules['query'] = ['required', 'string'];
        } else {
            $rules['subject'] = ['required', 'string', 'max:255'];
            $rules['message'] = ['required', 'string'];
        }

        return $rules;
    }
}