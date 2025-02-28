<?php
/**
 * This file is part of PHPinnacle/Ridge.
 *
 * (c) PHPinnacle Team <dev@phpinnacle.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPinnacle\Ridge\Protocol;

use PHPinnacle\Ridge\Buffer;
use PHPinnacle\Ridge\Constants;

class QueuePurgeOkFrame extends MethodFrame
{
    /**
     * @var int
     */
    public $messageCount;

    public function __construct()
    {
        parent::__construct(Constants::CLASS_QUEUE, Constants::METHOD_QUEUE_PURGE_OK);
    }
    
    /**
     * @param Buffer $buffer
     *
     * @return self
     */
    public static function unpack(Buffer $buffer): self
    {
        $self = new self;
        $self->messageCount = $buffer->consumeInt32();
        
        return $self;
    }
    
    /**
     * @return Buffer
     */
    public function pack(): Buffer
    {
        $buffer = parent::pack();
        $buffer->appendInt32($this->messageCount);
        
        return $buffer;
    }
}
