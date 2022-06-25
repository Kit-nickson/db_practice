<?php
declare(strict_types=1);

class DbDebug
{
    public function __construct(public DB $db)
    {
    }

    public function __call($name, $arguments)
    {
        try {
            return $this->db->$name(...$arguments);
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }

}