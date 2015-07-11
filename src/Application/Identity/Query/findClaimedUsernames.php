<?php 

namespace RayRutjes\DomainFoundation\Example\Application\Identity\Query;

class FindClaimedUsernames
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @param \PDO   $pdo
     * @param string $tableName
     */
    public function __construct(\PDO $pdo, $tableName = 'claimed_usernames')
    {
        $this->pdo = $pdo;
        $this->tableName = $tableName;
    }

    /**
     * @return array
     */
    public function execute()
    {
        $sql = 'SELECT * FROM ' . $this->tableName;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
