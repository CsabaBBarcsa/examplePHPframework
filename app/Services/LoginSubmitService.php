<?php
namespace App\Services;

use Examp\Core\Database;
use Examp\Core\Session\Session;

use PDO;

/**
 * Description of LoginSubmitService
 */
class LoginSubmitService 
{
    const LOGGIN_KEY = 'logged';

    /**
     * @desc - database connection object
     * @var Database 
     */
    private $dbconn;
    /**
     * @desc - Session object
     * @var Session
     */
    private $session;

    /**
     * @param Database $db
     * @param Session $session
     */
    public function __construct(Database $db, Session $session )
    {
        $this->dbconn = $db;
        $this->session = $session;
    }

    /**
     * @desc - Log the user if has verified record in the db
     * @param string $email
     * @param string $pass
     * @return bool
     */
    public function login(string $email, string $pass)
    {
        $sql = 'SELECT id, u_name, u_pass FROM users WHERE u_email = :email ;';

        $stm = $this->dbconn->prepare($sql);
        $stm->bindParam('email', $email, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_OBJ);

        if ($result !== false && password_verify( hash('sha3-512', $pass), $result->u_pass) )
        {
            $this->session->add( self::LOGGIN_KEY, [
                'id' => $result->id,
                'uName' => $result->u_name,
                'uEmail' => $email
            ]);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * @desc - logout the user
     */
    public function logout()
    {
        $this->session->remove(self::LOGGIN_KEY);
        $this->session->clearAll();
    }

    /**
     * @desc - Checking the user is logged in
     * @return type
     */
    public function isLoggedIn()
    {
        return $this->session->has(self::LOGGIN_KEY);
    }

}
