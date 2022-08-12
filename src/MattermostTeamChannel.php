<?php

namespace Takuya\PhpLaravelMattermostPost;

use Illuminate\Notifications\Notifiable;

class MattermostTeamChannel {
  use Notifiable;
  
  /** @var string */
  protected $channel_id;
  
  /**
   * constructor for Notifiable Team/Channel by id.
   * @param $channel_id
   */
  public function __construct ( $channel_id ) {
    $this->channel_id = $channel_id;
  }
  
  /**
   * @return string
   */
  public function getChannelId (): string {
    return $this->channel_id;
  }
  
}