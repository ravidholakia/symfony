<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Messenger\Transport\Receiver;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\TransportException;

/**
 * @author Samuel Roze <samuel.roze@gmail.com>
 * @author Ryan Weaver <ryan@symfonycasts.com>
 *
 * @experimental in 4.2
 */
interface ReceiverInterface
{
    /**
     * Receive some messages to the given handler.
     *
     * While this method could return an unlimited number of messages,
     * the intention is that it returns only one, or a "small number"
     * of messages each time. This gives the user more flexibility:
     * they can finish processing the one (or "small number") of messages
     * from this receiver and move on to check other receivers for messages.
     * If a this method returns too many messages, it could cause a
     * blocking effect where handling the messages received from one
     * call to get() takes a long time, blocking other receivers from
     * being called.
     *
     * If a received message cannot be decoded, the message should not
     * be retried again (e.g. if there's a queue, it should be removed)
     * and a MessageDecodingFailedException should be thrown.
     *
     * @throws TransportException If there is an issue communicating with the transport
     *
     * @return Envelope[]
     */
    public function get(): iterable;

    /**
     * Acknowledge that the passed message was handled.
     *
     * @throws TransportException If there is an issue communicating with the transport
     */
    public function ack(Envelope $envelope): void;

    /**
     * Called when handling the message failed and it should not be retried.
     *
     * @throws TransportException If there is an issue communicating with the transport
     */
    public function reject(Envelope $envelope): void;
}