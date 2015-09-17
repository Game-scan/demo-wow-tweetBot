<?php namespace GameScan\WoWActivityTweetBot;

class WoWApi
{

    protected $player = null;
    protected $api = null;
    public function __construct()
    {
        $this->api = (new \GameScan\WoW\WowApiRequest(new \GameScan\WoW\ApiConfiguration()));
        $this->api->setHost(new \GameScan\WoW\HostInformation\EuHostInformation());
        $this->player = new \GameScan\WoW\Entity\Player($this->api, "hyjal", "kandran", 'fr_FR');
    }

    public function newFeeds()
    {
        $feeds = $this->player->feed();
        $newFeeds = array();
        $i = 0;
        foreach ($feeds as $feed) {
            $timestamp =  $feed->timestamp;
            $lastTimestamp = file_exists("lastTimestamp") ? (float) file_get_contents("lastTimestamp") : 0;
            if ($timestamp > $lastTimestamp) {
                $newFeeds[] = $feed;
            }
            if ($i===0) {
                file_put_contents("lastTimestamp", $timestamp);
            }
            $i++;
        }
        return $newFeeds;
    }

    public function newFeedsMessages()
    {
        $feeds  = $this->newFeeds();
        $feedsMessages = array();
        foreach ($feeds as $feed) {
            switch ($feed->type) {
                case "LOOT" :
                    $lootName = $this->getLootName($feed->itemId);
                    if ($lootName !== null) {
                        $feedsMessages[] ="LOOT : " . $lootName  ;
                    }
                    break;
                case "ACHIEVEMENT" :
                    $feedsMessages[] ="ACHIEVEMENT : " . $feed->achievement->title  ;
                    break;
                case "BOSSKILL" :
                    $feedsMessages[] = "BOSSKILL : " .$feed->achievement->title ;
                    break;
                case "CRITERIA" :
                default :
            }
        }
        return array_filter($feedsMessages);
    }

    public function getLootName($itemId)
    {
        $itemApi = new \GameScan\WoW\Entity\Item($this->api, $itemId, "fr_FR");
        return $itemApi->name();
    }
}
