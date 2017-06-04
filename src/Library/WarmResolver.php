<?php

namespace Snowdog\DevTest\Library;

use Snowdog\DevTest\Model\VarnishManager;
use Snowdog\DevTest\Model\WebsiteManager;

class WarmResolver implements \Old_Legacy_CacheWarmer_Resolver_Interface
{
    private $varnishManager;

    private $websiteManager;

    public function __construct(VarnishManager $varnishManager, WebsiteManager $websiteManager)
    {
        $this->varnishManager = $varnishManager;
        $this->websiteManager = $websiteManager;
    }

    public function getIp($hostname)
    {
        $ips = gethostbyname($hostname);

        $website = $this->websiteManager->getByHostname($hostname);
        $varnishes = $this->varnishManager->getByWebsite($website);
        foreach ($varnishes as $varnish) {
            $ips .= ' , ' . $varnish->getIP();
        }
        return (string) $ips;
    }
}