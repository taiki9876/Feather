<?php

namespace Core\Framework;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            try {
                $dsn = sprintf(
                    "%s:host=%s;port=%s;dbname=%s;charset=utf8mb4",
                    Config::get('database.connection'),
                    Config::get('database.host'),
                    Config::get('database.port'),
                    Config::get('database.database')
                );

                self::$connection = new PDO(
                    $dsn,
                    Config::get('database.username'),
                    Config::get('database.password'),
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                throw new \Exception("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$connection;
    }

    public static function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
} 