<?php

namespace Takuya\PhpLaravelMattermostPost\Channels;

use Illuminate\Notifications\Notification;
use Takuya\PhpLaravelMattermostPost\Messages\MattermostMessage;
use Takuya\PhpLaravelMattermostPost\MattermostBotPostClient;
use Takuya\PhpLaravelMattermostPost\MattermostTeamChannel;

class MattermostApiChannel {
  public function send ( $notifiable, Notification $notification ) {
    $formatter = 'toMattermost';
    
    if ( !method_exists( $notification, $formatter ) ) {
      throw new \RuntimeException( '"toMattermost()" not found in $notifiable' );
    }
    
    /** @var MattermostMessage $msg */
    $msg = $notification->{$formatter}( $notifiable );
    // channel_id を引数から取り出す。
    if ( get_class( $notifiable ) == MattermostTeamChannel::class ) {
      $msg->to( $notifiable->getChannelId() );
    } else if ( property_exists( $notifiable, 'routes' ) ) {
      $channel = array_values( $notifiable->routes )[0];
      $msg->to( $channel );
    }
    $json = json_encode( (array)$msg );
    //
    $cli = new MattermostBotPostClient();
    $cli->send( $json );
  }
}