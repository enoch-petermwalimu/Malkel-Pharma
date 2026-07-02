<?php

namespace App\Modules\WhatsApp\Services;

class WhatsAppService
{
    private string $apiToken;
    private string $phoneNumberId;
    private string $apiBase = 'https://graph.facebook.com/v18.0';

    public function __construct()
    {
        $this->apiToken = env('WHATSAPP_API_TOKEN', '');
        $this->phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID', '');
    }

    /**
     * Send a PDF document via WhatsApp.
     *
     * @param string $recipientPhone Phone number in international format (e.g., 5511999999999)
     * @param string $pdfUrl Publicly accessible URL of the PDF
     * @param string $caption Optional caption
     * @return array Response from Meta API
     */
    public function sendPdf(string $recipientPhone, string $pdfUrl, string $caption = ''): array
    {
        $url = $this->apiBase . '/' . $this->phoneNumberId . '/messages';

        $data = [
            'messaging_product' => 'whatsapp',
            'to' => $recipientPhone,
            'type' => 'document',
            'document' => [
                'link' => $pdfUrl,
                'caption' => $caption,
            ],
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->apiToken,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = json_decode($response, true);

        return [
            'success' => $httpCode >= 200 && $httpCode < 300,
            'http_code' => $httpCode,
            'response' => $decoded,
        ];
    }
}
