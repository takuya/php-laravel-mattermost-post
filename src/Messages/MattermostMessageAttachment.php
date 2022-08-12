<?php


namespace Takuya\PhpLaravelMattermostPost\Messages;

class MattermostMessageAttachment {
  public function __construct (
    public $author_icon = null,
    public $author_link = null,
    public $author_name = null,
    public $color = null,
    public $fallback = null,
    public $fields = null,
    public $image_url = null,
    public $pretext = null,
    public $text = null,
    public $title = null,
    public $title_link = null,
  ) {
  }
  
  public function author_icon ( string $value ) {
    $this->author_icon = $value;
    return $this;
  }
  
  public function author_link ( string $value ) {
    $this->author_link = $value;
    return $this;
  }
  
  public function author_name ( string $value ) {
    $this->author_name = $value;
    return $this;
  }
  
  public function color ( string $value ) {
    $this->color = $value;
    return $this;
  }
  
  public function fallback ( string $value ) {
    $this->fallback = $value;
    return $this;
  }
  
  /**
   * @param array $value
   * @return $this
   */
  public function fields ( MattermostMessageAttachmentField|array $value ) {
    $this->fields[] = (array)$value;
    return $this;
  }
  
  public function image_url ( string $value ) {
    $this->image_url = $value;
    return $this;
  }
  
  public function pretext ( string $value ) {
    $this->pretext = $value;
    return $this;
  }
  
  public function text ( string $value ) {
    $this->text = $value;
    return $this;
  }
  
  public function title ( string $value ) {
    $this->title = $value;
    return $this;
  }
  
  public function title_link ( string $value ) {
    $this->title_link = $value;
    return $this;
  }
  
  
}