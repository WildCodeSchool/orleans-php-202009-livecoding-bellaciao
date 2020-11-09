<?php

/**
 * Database connection
 *
 *
 *
 * @author adapted from Benjamin Besse
 *
 * @link   http://fr3.php.net/manual/fr/book.pdo.php classe PDO
 */

namespace App\Model;

use PDO;

/**
 *
 * This class only make a PDO object instanciation. Use it as below :
 *
 * <pre>
 *  $db = new Connection();
 *  $conn = $db->getPdoConnection();
 * </pre>
 */
class Connection
{
    /**
     * @var PDO
     *
     * @access private
     */
    private $pdoConnection;

    private $user;

    private $host;

    private $password;

    private $dbName;

    /**
     * Initialize connection
     *
     * @access public
     */
    public function __construct()
    {
        $this->user = getenv('APP_DB_USER') ? getenv('APP_DB_USER') : APP_DB_USER;
        $this->host = getenv('APP_DB_HOST') ? getenv('APP_DB_HOST') : APP_DB_HOST;
        $this->password = getenv('APP_DB_PWD') ? getenv('APP_DB_PWD') : APP_DB_PWD;
        $this->dbName = getenv('APP_DB_NAME') ? getenv('APP_DB_NAME') : APP_DB_NAME;

        try {
            $this->pdoConnection = new PDO(
                'mysql:host=' . $this->host . '; dbname=' . $this->dbName . '; charset=utf8',
                $this->user,
                $this->password
            );
            $this->pdoConnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // show errors in DEV environment
            if (ENV === 'dev') {
                $this->pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (\PDOException $e) {
            echo('<div class="error">Error !: ' . $e->getMessage() . '</div>');
        }
    }


    /**
     * @return PDO $pdo
     */
    public function getPdoConnection(): PDO
    {
        return $this->pdoConnection;
    }
}
