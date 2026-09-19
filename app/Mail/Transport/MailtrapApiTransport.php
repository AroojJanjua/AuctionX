<?php

namespace App\Mail\Transport;

use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\MessageConverter;

class MailtrapApiTransport extends AbstractTransport
{
    protected const API_URL='https://send.api.mailtrap.io/api/send';

    public function __construct(private readonly string $apiToken){
        parent::__construct();
    }

    protected function doSend(SentMessage $message): void{
        $email=MessageConverter::toEmail($message->getOriginalMessage());

        $payload=[
            'from' => $this->formatAddress($email->getFrom()[0]),
            'to' => array_map(fn ($a) => $this->formatAddress($a), $email->getTo()),
            'subject' => (string) $email->getSubject(),
        ];

        if($cc = $email->getCc()){
            $payload['cc'] = array_map(fn ($a) => $this->formatAddress($a), $cc);
        }

        if($bcc = $email->getBcc()){
            $payload['bcc'] = array_map(fn ($a) => $this->formatAddress($a), $bcc);
        }

        if($replyTo = $email->getReplyTo()){
            $payload['reply_to'] = $this->formatAddress($replyTo[0]);
        }

        if($html = $email->getHtmlBody()){
            $payload['html'] = $html;
        }

        if($text = $email->getTextBody()){
            $payload['text'] = $text;
        }

        $response=Http::withToken($this->apiToken)
            ->acceptJson()
            ->post(self::API_URL, $payload);

        if($response->failed()){
            throw new TransportException(
                'Mailtrap API mail send failed: '.$response->status().' '.$response->body()
            );
        }
    }

    private function formatAddress($address):array{
        $formatted=['email' => $address->getAddress()];

        if($name = $address->getName()){
            $formatted['name'] = $name;
        }

        return $formatted;
    }

    public function __toString(): string{
        return 'mailtrap+api://send.api.mailtrap.io';
    }
}