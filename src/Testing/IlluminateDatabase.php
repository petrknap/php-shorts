<?php

declare(strict_types=1);

namespace PetrKnap\Shorts\Testing;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Connection;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\PostgresConnection;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Database\SqlServerConnection;
use InvalidArgumentException;
use PDO;
use PetrKnap\Shorts\HasRequirements;

final class IlluminateDatabase
{
    use HasRequirements;

    /**
     * @see Manager::addConnection() default value of $name
     */
    public const CONNECTION_DEFAULT_NAME = 'default';

    private function __construct()
    {
    }

    /**
     * @param Connection|PDO|array<string, Connection|PDO> $connections well-known {@see Connection}s or/and {@see PDO}s keyed by names
     *
     * @return Manager
     *
     * @see Manager::setAsGlobal() if you want to use {@see Manager} globally
     * @see Manager::bootEloquent() if you want to use {@see Model}s
     */
    public static function createCapsuleManager(object|array $connections): object
    {
        self::checkRequirements(
            classes: [
                Connection::class,
                Manager::class,
                PDO::class,
            ],
        );

        if (!is_array($connections)) {
            $connections = [self::CONNECTION_DEFAULT_NAME => $connections];
        }

        $manager = new Manager();
        foreach ($connections as $name => $connection) {
            $manager->addConnection([], $name);
            $manager->getDatabaseManager()
                ->extend($name, static fn(): Connection => $connection instanceof Connection
                    ? $connection
                    : self::createConnection($connection, $name));
        }

        return $manager;
    }

    /**
     * @param PDO $pdo
     *
     * @return Connection
     *
     * @see ConnectionFactory::createConnection()
     */
    private static function createConnection(object $pdo, string $name): object
    {
        self::checkRequirements(
            classes: [
                MySqlConnection::class,
                PDO::class,
                PostgresConnection::class,
                SQLiteConnection::class,
                SqlServerConnection::class,
            ],
        );

        $config = ['name' => $name];
        /** @var string $driver */
        $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        return match ($driver) {
            'mysql' => new MySqlConnection($pdo, config: $config),
            'pgsql' => new PostgresConnection($pdo, config: $config),
            'sqlite' => new SQLiteConnection($pdo, config: $config),
            'sqlsrv' => new SqlServerConnection($pdo, config: $config),
            default => throw new InvalidArgumentException("Unsupported driver [{$driver}]."),
        };
    }
}
