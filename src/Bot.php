<?php namespace GameScan\WoWActivityTweetBot;

use Abraham\TwitterOAuth\TwitterOAuth;
use GameScan\Core\Tools\Environment;

class Bot
{


    public function __construct()
    {
        $environment = new Environment();
        $this->api_key = $environment->get("TWITTER_API_KEY");
        $this->api_secret =  $environment->get("TWITTER_API_SECRET");
        $this->access_token =  $environment->get("TWITTER_ACCESS_TOKEN");
        $this->access_token_secret =  $environment->get("TWITTER_ACCESS_TOKEN_SECRET");
    }

    public function oauth()
    {
        $con = new TwitterOAuth($this->api_key, $this->api_secret, $this->access_token, $this->access_token_secret);
        return $con;
    }
    public function tweet($text)
    {
        $con = $this->oauth();
        $status = $con->post('statuses/update', array('status' => $text));
        return $status;
    }

    public function checkUpdate()
    {
        $messages = (new WoWApi())->newFeedsMessages();
        foreach ($messages as $message) {
            $this->tweet($message);
            sleep(1);
        }
    }
}
