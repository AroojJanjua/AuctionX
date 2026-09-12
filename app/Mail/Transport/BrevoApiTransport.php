<?php

namespace App\Mail\Transport;

use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\MessageConverter;

/**
 * Sends mail via Brevo's HTTPS API (https://api.brevo.com/v3/smtp/email)
 * instead of SMTP. Render's free tier blocks all outbound SMTP ports
 * (25, 465, 587) as an anti-spam measure, so any SMTP-based mailer
 * (Brevo, Mailtrap, etc.) hangs and eventually times out with a 504.
 * Plain HTTPS (port 443) is not blocked, so this transport avoids the
 * problem entirely.
 */
class BrevoApiTransport extends AbstractTransport
{
    public function __construct(private string $apiKey)
    {
        parent::__construct();
    }

    public function __toString(): string
    {
        return 'brevo+api://api.brevo.com';
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());
        $envelope = $message->getEnvelope();

        $payload = [
            'sender' => $this->addressToArray($envelope->getSender()),
            'to' => array_map([$this, 'addressToArray'], $envelope->getRecipients()),
            'subject' => (string) $email->getSubject(),
        ];

        if ($html = $email->getHtmlBody()) {
            $payload['htmlContent'] = $html;
        }

        if ($text = $email->getTextBody()) {
            $payload['textContent'] = $text;
        }

        $response = Http::withHeaders([
            'api-key' => $this->apiKey,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', $payload);

        if ($response->failed()) {
            throw new TransportException(
                'Brevo API mail send failed: '.$response->status().' '.$response->body()
            );
        }
    }

    private function addressToArray($address): array
    {
        return array_filter([
            'email' => $address->getAddress(),
            'name' => $address->getName() ?: null,
        ]);
    }
}
