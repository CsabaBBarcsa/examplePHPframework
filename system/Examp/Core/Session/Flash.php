<?php

namespace Examp\Core\Session;

use Examp\Contracts\Session;
use Examp\Core\Session\Session as BuiltInSession;
/**
 * Description of Flash
 */
class Flash implements Session
{
    const FLASHSTORAGE = 'flashes';

    /**
     * @var Session
     */
    protected $session;

    public function __construct(BuiltInSession $session)
    {
        $this->session = $session;
    }

    public function has(string $key)
    {
        if (!$this->checkFlashStorage()) {
            $this->session->add(self::FLASHSTORAGE, []);
        }
        return array_key_exists($key, $this->getFlashStorage() );
    }

    public function add(string $key, $value)
    {
        if ( !$this->has($key) )
        {
            $flash = $this->session->get(self::FLASHSTORAGE);
            $flash[$key] = $value;
            $this->session->add(self::FLASHSTORAGE, $flash);
        }

    }

    public function get(string $key)
    {
        if ( $this->has($key) )
        {
            $flash = $this->session->get(self::FLASHSTORAGE);
            return $flash[$key];
        }
    }

    public function getAll()
    {
        if ( $this->session->has(self::FLASHSTORAGE) )
        {
            return $this->session->get(self::FLASHSTORAGE);
        }
    }

    public function remove(string $key)
    {
        $flash = $this->session->get(self::FLASHSTORAGE);
        unset($flash[$key]);
    }

    public function clearAll()
    {
        $this->session->remove(self::FLASHSTORAGE);
        $this->session->add(self::FLASHSTORAGE, []);
    }

    protected function checkFlashStorage()
    {
        return $this->session->has(self::FLASHSTORAGE);
    }

    protected function getFlashStorage()
    {
        return $this->session->get(self::FLASHSTORAGE);
    }

}
