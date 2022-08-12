<?php

namespace Takuya\PhpLaravelMattermostPost\Messages;

class MattermostMessage {
  public function __construct (
    public $channel_id = null,
    public $message = null,
    public $props = [],
  ) {
  }
  
  public function to ( string $channel_id ) {
    return $this->channel_id( $channel_id );
  }
  
  public function channel_id ( string $channel ) {
    $this->channel_id = $channel;
    return $this;
  }
  
  public function content ( string $value ) {
    $this->message = $value;
    return $this;
  }
  
  public function attachment ( MattermostMessageAttachment|array $value ) {
    $this->props['attachments'][] = (array)$value;
    return $this;
  }
}