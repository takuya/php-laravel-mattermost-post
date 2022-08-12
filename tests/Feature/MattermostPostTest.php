<?php

use Tests\TestCase;
use Takuya\PhpLaravelMattermostPost\MattermostBotPostClient;
use Takuya\PhpLaravelMattermostPost\Messages\MattermostMessage;
use Takuya\PhpLaravelMattermostPost\Messages\MattermostMessageAttachment;
use Takuya\PhpLaravelMattermostPost\Messages\MattermostMessageAttachmentField;

class MattermostPostTest extends TestCase {
  
  public function testPostMattermostChannel_SimpleText(){
    //
    $msg = new MattermostMessage();
    $msg->content('@takuya Hello world.');
    $msg->to(env('MATTERMOST_CHANNEL_ID'));
    //
    $cli = new MattermostBotPostClient();
    $json = json_encode( (array)$msg );
    $ret  = $cli->send( $json );
    $this->assertArrayHasKey('id',$ret);
  }
  public function testPostMattermostChannel_FormattedText(){
    //
    $msg = new MattermostMessage();
    $attach = new MattermostMessageAttachment();
    $attach->author_name( 'PhpUnit' )
           ->author_link( 'http://example.com' )
           ->color( '#32a836' )
           ->fields(
             ( new MattermostMessageAttachmentField() )
               ->title( 'method' )
               ->short( 'true' )
               ->value( __METHOD__ )
           );
    $msg->attachment( $attach );
    $msg->content( "@takuya  ".__CLASS__ );
    $msg->to(env('MATTERMOST_CHANNEL_ID'));
    //
    $cli = new MattermostBotPostClient();
    $json = json_encode( (array)$msg );
    $ret  = $cli->send( $json );
    $this->assertArrayHasKey('id',$ret);
  }
}