# php-laravel-mattermost-post
post mattermost by bot account api as laravel plugin


## Installing 
```shell
composer config repositories.'php-laravel-mattermost-post' \
         vcs https://github.com/takuya/php-laravel-mattermost-post.git  
composer require takuya/php-laravel-mattermost-post:master
composer install 

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