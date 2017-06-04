<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\VarnishManager;

class DeleteVarnishLinkAction
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
        parse_str(file_get_contents("php://input"), $del_vars);
        $varnishId = isset($del_vars['varnish']) ? $del_vars['varnish'] : null;
        $websiteId = isset($del_vars['website']) ? $del_vars['website'] : null;

        $result = false;
        if (!empty($varnishId) && !empty($websiteId)) {
            if (isset($_SESSION['login'])) {
                $result = $this->varnishManager->unlink($varnishId, $websiteId);
            }
        }
        echo json_encode($result);
    }
}