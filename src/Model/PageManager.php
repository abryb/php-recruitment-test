<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;

class PageManager
{

    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAllByWebsite(Website $website)
    {
        $websiteId = $website->getWebsiteId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM pages WHERE website_id = :website');
        $query->bindParam(':website', $websiteId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Page::class);
    }

    public function getAllByUser(User $user)
    {
        $userId = $user->getUserId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare(
            'SELECT * FROM pages 
                      WHERE website_id IN (SELECT website_id FROM websites WHERE user_id = :userId)
                      ORDER BY last_visit DESC');
        $query->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Page::class);
    }


    public function create(Website $website, $url)
    {
        $websiteId = $website->getWebsiteId();
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('INSERT INTO pages (url, website_id) VALUES (:url, :website)');
        $statement->bindParam(':url', $url, \PDO::PARAM_STR);
        $statement->bindParam(':website', $websiteId, \PDO::PARAM_INT);
        $statement->execute();
        return $this->database->lastInsertId();
    }

    public function updateLastVisit(Page $page, \DateTime $dateTime)
    {
        $timestamp = $dateTime->format('Y-m-d H:i:s');
        $pageId = $page->getPageId();
        $statement = $this->database->prepare('UPDATE pages SET last_visit = :visit WHERE page_id = :id');
        $statement->bindParam(':visit', $timestamp, \PDO::PARAM_STR);
        $statement->bindParam(':id', $pageId, \PDO::PARAM_INT);
        return $statement->execute();
    }
}