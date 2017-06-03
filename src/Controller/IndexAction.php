<?php

namespace Snowdog\DevTest\Controller;

use Snowdog\DevTest\Model\PageManager;
use Snowdog\DevTest\Model\User;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\WebsiteManager;

class IndexAction
{

    /**
     * @var WebsiteManager
     */
    private $websiteManager;

    /**
     * @var PageManager
     */
    private $pageManager;

    /**
     * @var User
     */
    private $user;

    /**
     * @var array
     */
    private $pages;

    public function __construct(UserManager $userManager, WebsiteManager $websiteManager, PageManager $pageManager)
    {
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
        if (isset($_SESSION['login'])) {
            $this->user = $userManager->getByLogin($_SESSION['login']);
            $this->pages = $this->getPages();
        }
    }

    protected function getWebsites()
    {
        if($this->user) {
            return $this->websiteManager->getAllByUser($this->user);
        } 
        return [];
    }

    protected function getPages()
    {
        if($this->user) {
            return $this->pageManager->getAllByUser($this->user);
        }
        return [];
    }

    protected function getLastVisited()
    {
        if($this->pages != []) {
            $page = reset($this->pages);
            $website = $this->websiteManager->getById($page->getWebsiteId());
            return $website->getHostname() . '/' . $page->getUrl();
        }
        return null;
    }

    protected function getRecentVisited()
    {
        if($this->pages != []) {
            $page = end($this->pages);
            $website = $this->websiteManager->getById($page->getWebsiteId());
            return $website->getHostname() . '/' . $page->getUrl();
        }
        return null;
    }

    public function execute()
    {
        require __DIR__ . '/../view/index.phtml';
    }
}