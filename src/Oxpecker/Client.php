<?php

namespace Oxpecker;

use Abraham\TwitterOAuth\TwitterOAuth;

class Client
{
    protected $connection;

    public function __construct($consumerKey, $consumerSecret, $accessToken = null, $accessTokenSecret = null)
    {
        $this->connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
    }

    public function getUserTimeline($count = 25, $includeReplies = true)
    {
        return $this->connection->get("statuses/user_timeline", array("count" => $count, "exclude_replies" => !$includeReplies));
    }

    public function tweet($message)
    {
        return $this->connection->post("statuses/update", array('status' => $message));
    }
}
