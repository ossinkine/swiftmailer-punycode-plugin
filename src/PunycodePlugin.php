<?php

namespace Ossinkine\Swift\Plugin;

use Swift_Events_SendEvent as SendEvent;
use Swift_Events_SendListener as SendListener;
use TrueBV\Punycode;

/**
 * Converts domain in email addresses to punycode
 *
 * @author Gocha Ossinkine <ossinkine@ya.ru>
 */
class PunycodePlugin implements SendListener
{
    private $punycode;

    public function beforeSendPerformed(SendEvent $event)
    {
        $encodedEmails = [];
        $emails = $event->getMessage()->getTo();
        foreach ($emails as $email => $value) {
            $encodedEmail = $this->encodeEmail($email);
            $encodedEmails[$encodedEmail] = $value;
        }

        $event->getMessage()->setTo($encodedEmails);
    }

    public function sendPerformed(SendEvent $event)
    {
    }

    private function encodeEmail(string $email): string
    {
        list($name, $domain) = explode('@', $email);

        return sprintf('%s@%s', $name, $this->getPunycode()->encode($domain));
    }

    private function getPunycode(): Punycode
    {
        if (null === $this->punycode) {
            $this->punycode = new Punycode();
        }

        return $this->punycode;
    }
}
