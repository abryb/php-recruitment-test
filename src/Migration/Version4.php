<?php
/**
 * Created by PhpStorm.
 * User: bazej
 * Date: 03.06.17
 * Time: 22:45
 */

namespace Snowdog\DevTest\Migration;

use Snowdog\DevTest\Core\Database;
use Snowdog\DevTest\Model\PageManager;
use Snowdog\DevTest\Model\UserManager;
use Snowdog\DevTest\Model\WebsiteManager;

class Version4
{
    /**
     * @var Database|\PDO
     */
    private $database;
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var WebsiteManager
     */
    private $websiteManager;
    /**
     * @var PageManager
     */
    private $pageManager;

    public function __construct(
        Database $database,
        UserManager $userManager,
        WebsiteManager $websiteManager,
        PageManager $pageManager
    ) {
        $this->database = $database;
        $this->userManager = $userManager;
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
    }

    public function __invoke()
    {
        $this->createVarnishTable();
        $this->createWebsitesVarnishesTable();
    }

    private function createVarnishTable()
    {
        $createQuery = <<<SQL
CREATE TABLE `varnishes` (
  `varnish_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `IP` varchar(15) NOT NULL UNIQUE,
  `user_id`int(11) unsigned NOT NULL,
  PRIMARY KEY (`varnish_id`),
  CONSTRAINT `varnish_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->database->exec($createQuery);
    }

    private function createWebsitesVarnishesTable()
    {
        $createQuery = <<<SQL
CREATE TABLE `websites_varnishes` (
  `website_id` int (11) unsigned NOT NULL,
  `varnish_id` int (11) unsigned NOT NULL,
  CONSTRAINT `website_varnish_website_fk` FOREIGN KEY (`website_id`) REFERENCES `websites` (`website_id`),
  CONSTRAINT `website_varnish_varnish_fk` FOREIGN KEY (`varnish_id`) REFERENCES `varnishes` (`varnish_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `websites_varnishes` ADD UNIQUE `unique_index`(`website_id`, `varnish_id`);
SQL;
        $this->database->exec($createQuery);

    }
}