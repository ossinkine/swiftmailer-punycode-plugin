<?php

namespace Ossinkine\Swift\Plugin;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Swift_Events_SendEvent as SendEvent;
use Swift_Mime_SimpleMessage as SimpleMessage;

class PunycodePluginTest extends TestCase
{
    /**
     * @var SimpleMessage|MockObject
     */
    private $message;

    /**
     * @var SendEvent|MockObject
     */
    private $event;

    /**
     * @var PunycodePlugin
     */
    private $plugin;

    public function setUp()
    {
        $this->message = $this->createMock(SimpleMessage::class);
        $this->event = $this->createMock(SendEvent::class);
        $this->plugin = new PunycodePlugin();
    }

    /**
     * @dataProvider providerEmail
     */
    public function testEmailDomainPunycodePasses(array $email, array $emailExpected)
    {
        $this->message->method('getTo')->willReturn($email);
        $this->event->method('getMessage')->willReturn($this->message);
        $this->message->expects($this->once())->method('setTo')->with($emailExpected);

        $this->plugin->beforeSendPerformed($this->event);
    }

    public function providerEmail(): array
    {
        return [
            [['foo@бар.ltd' => 'Foo'], ['foo@xn--80ab0c.ltd' => 'Foo']],
            [['foo@bar.ltd' => 'Foo'], ['foo@bar.ltd' => 'Foo']],
        ];
    }
}
