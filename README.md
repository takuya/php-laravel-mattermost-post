# php-laravel-mattermost-post
post mattermost by bot account api as laravel plugin


## Installing 
```shell
cd your-laravel-project
composer config repositories.'php-laravel-mattermost-post' \
         vcs https://github.com/takuya/php-laravel-mattermost-post.git  
composer require takuya/php-laravel-mattermost-post:master
composer install 

```

## Using

```shell
php artisan make:notification SampleNotify
php artisan make:command MattermostNotifySample
```
### app/Notifications/SampleNotify.php
```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Takuya\PhpLaravelMattermostPost\Channels\MattermostApiChannel;
use Takuya\PhpLaravelMattermostPost\Messages\MattermostMessage;

class SampleNotify extends Notification {
  use Queueable;
  
  public function via ( $notifiable ) {
    return [MattermostApiChannel::class];
  }
  
  public function toMattermost ( $notifiable ) {
    $msg = new MattermostMessage();
    $msg->content( "@takuya Sample notify" );
    return $msg;
  }
}
```
### app/Console/Commands/MattermostNotifySample.php
```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\SampleNotify;
use Takuya\PhpLaravelMattermostPost\MattermostTeamChannel;

class MattermostNotifySample extends Command {
  protected $signature = 'mm:notify';
  
  public function handle () {
    $chn_id = config( 'mattermost.channel' );
    $chat_room = new MattermostTeamChannel( $chn_id );
    $chat_room->notify( new SampleNotify() );
    return 0;
  }
}
```
### .env
```php
MATTERMOST_BOT_ID=ujkaXXXXXXXXXXXXX
MATTERMOST_BOT_TOKEN=oxjnXXXXXXXX
MATTERMOST_URL=https://mm.exmample.com/
MATTERMOST_CHANNEL_ID=dkt9gqXXXXXXXXXXX
```
### config/mattermost.php
```php
<?php
return [
  'channel' => env( 'MATTERMOST_CHANNEL_ID' ),
  'token' => env( 'MATTERMOST_BOT_TOKEN' ),
  'bot_id' => env( 'MATTERMOST_BOT_ID' ),
  'host' => env( 'MATTERMOST_URL' ),
];
```
### run 
```
php artisan mm:notify
```

## Testing
```shell
## clone 
git clone https://github.com/takuya/php-laravel-mattermost-post.git
cd php-laravel-mattermost-post
composer install
## prepare 
export MATTERMOST_BOT_TOKEN=XXXXXoxjno3dXXXX
export MATTERMOST_URL=https://mm.exmaple.com/
export MATTERMOST_CHANNEL_ID=XXXXdkt9gXXXX
## post 
vendor/bin/phpunit --filter testPostMattermostChannel_FormattedText
```