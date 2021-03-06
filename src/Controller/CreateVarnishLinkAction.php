<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\VarnishManager;
use Snowdog\DevTest\Model\WebsiteManager;

class CreateVarnishLinkAction
{
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var VarnishManager
     */
    private $varnishManager;

    public function __construct(UserManager $userManager, VarnishManager $varnishManager)
    {
        $this->userManager = $userManager;
        $this->varnishManager = $varnishManager;
    }

    public function execute()
    {
        $varnishId = isset($_POST['varnish']) ? $_POST['varnish'] : null;
        $websiteId = isset($_POST['website']) ? $_POST['website'] : null;

        $result = false;
        if (!empty($varnishId) && !empty($websiteId)) {
            if (isset($_SESSION['login'])) {
                $result = $this->varnishManager->link($varnishId, $websiteId);
            }
        }
        echo json_encode($result);
    }
}