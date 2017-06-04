<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;

class VarnishManager
{

    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAllByUser(User $user)
    {
        $userId = $user->getUserId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM varnishes WHERE user_id = :user');
        $query->bindParam(':user', $userId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Varnish::class);
    }

    public function getWebsites(Varnish $varnish)
    {
        $varnishId = $varnish->getVarnishId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare(
            'SELECT * FROM websites 
                      WHERE website_id IN (SELECT website_id FROM websites_varnishes WHERE varnish_id = :varnish)'
        );
        $query->bindParam(':varnish', $varnishId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Website::class);
    }

    public function getByWebsite(Website $website)
    {
        $websiteId = $website->getWebsiteId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare(
            'SELECT * FROM varnishes 
                       WHERE varnish_id IN (SELECT varnish_id FROM websites_varnishes WHERE website_id = :website)'
        );
        $query->bindParam(':website', $websiteId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Varnish::class);
    }

    public function create(User $user, $ip)
    {
        $userId = $user->getUserId();
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('INSERT INTO varnishes (IP, user_id) VALUES (:IP, :user)');
        $statement->bindParam(':IP', $ip, \PDO::PARAM_STR);
        $statement->bindParam(':user', $userId, \PDO::PARAM_INT);
        $statement->execute();
        return $this->database->lastInsertId();
    }

    public function link($varnishId, $websiteId)
    {
        $statement = $this->database->prepare(
            'INSERT INTO websites_varnishes (website_id, varnish_id) VALUES (:website, :varnish)'
        );
        $statement->bindParam(':varnish', $varnishId, \PDO::PARAM_INT);
        $statement->bindParam(':website', $websiteId, \PDO::PARAM_INT);
        return $statement->execute();
    }

    public function unlink($varnishId, $websiteId)
    {
        $statement = $this->database->prepare(
            'DELETE FROM websites_varnishes WHERE (website_id = :website AND varnish_id = :varnish)'
        );
        $statement->bindParam(':varnish', $varnishId, \PDO::PARAM_INT);
        $statement->bindParam(':website', $websiteId, \PDO::PARAM_INT);
        return $statement->execute();
    }

}