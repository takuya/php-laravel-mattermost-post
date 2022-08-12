<?php

namespace Takuya\PhpLaravelMattermostPost;

use Illuminate\Contracts\Container\BindingResolutionException;

class MattermostBotPostClient {
  
  protected string $endpoint;
  protected string $token;
  protected string $channel;
  protected string $content;
  
  protected string $config_key_host = 'mattermost.host';
  protected string $config_key_token = 'mattermost.token';
  
  public function __construct () {
    $this->load_config();
  }

  protected function load_config(){
    try {
      $this->config_check();
      $host = parse_url( config( $this->config_key_host ), PHP_URL_HOST );
      $this->endpoint = "https://${host}/api/v4/posts";
      $this->token = config( $this->config_key_token );
    }catch ( \Exception $e){
      $host = parse_url( getenv('MATTERMOST_URL'), PHP_URL_HOST );
      $this->endpoint = "https://${host}/api/v4/posts";
      $this->token = getenv('MATTERMOST_BOT_TOKEN');
      if (empty($this->token)){
        throw new \RuntimeException('token not supplied.');
      }
    }
  }
  protected function config_check () {
    foreach ( [$this->config_key_token, $this->config_key_host] as $item ) {
      if ( !config()->has( $item ) ) {
        $msg = "Place config/mattermost.php, config('{$item}') ";
        throw new \RuntimeException( "Config key not found. {$msg}" );
      }
    }
  }
  
  public function content ( string $message ) {
    $this->content = $message;
    
    return $this;
  }
  
  public function channel ( string $channel ) {
    $this->channel = $channel;
    
    return $this;
  }
  
  public function send ( $json = null ) {
    return $this->send_to_api( $json );
  }
  
  protected function send_to_api ( $json = null ) {
    if ( empty( $json ) ) {
      $params = $this->jsonBuilder();
    } else {
      $params = json_decode( $json , JSON_OBJECT_AS_ARRAY );//for syntax check.
      $params = array_filter($params,function($e){ return !empty($e);});
      $params = (object)$params;
    }
    try {
      $cli = new \GuzzleHttp\Client();
      $res = $cli->request(
        "POST",
        $this->endpoint,
        [
          'headers' => [
            'authorization' => 'Bearer '.env( 'MATTERMOST_BOT_TOKEN' ).'',
            'conent-type' => 'application/json',
          ],
          'body' => json_encode( $params ),
          'allow_redirects' => false,
        ] );
      $json = $res->getBody()->getContents();
      return json_decode($json,JSON_OBJECT_AS_ARRAY);
    } catch ( \Exception $e) {
      throw  $e;
    }
  }
  
  //
  protected function jsonBuilder () {
    if ( empty( $this->channel ) ) {
      throw new \RuntimeException( 'channel_id is not specified.' );
    }
    $params = [];
    $params = array_merge( $params, array_filter( [
      'channel_id' => $this->channel,
      'message' => $this->content,
      'props' => [
        'attachments' => [[
          "pretext" => "This is the attachment pretext.",
          "text" => "This is the attachment text.",
          "author_name" => "Mattermost",
          "author_link" => "https://mattermost.org/",
          "title" => "Example Attachment",
        ],
        ],
      ],
    ] ) );
    return $params;
  }
}