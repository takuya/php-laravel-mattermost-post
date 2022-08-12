<?php

namespace Takuya\PhpLaravelMattermostPost\Messages;

class MattermostMessageAttachmentField {
  public function __construct (
    public $title = null,
    public $value = null,
    public $short = null,
  ) {
  }
  
  public function title ( string $value ) {
    $this->title = $value;
    return $this;
  }
  
  public function value ( string $value ) {
    $this->value = $value;
    return $this;
  }
  
  public function short ( bool $value ) {
    $this->short = $value;
    return $this;
  }
  
}