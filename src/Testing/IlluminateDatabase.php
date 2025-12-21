<?php

declare(strict_types=1);

namespace PetrKnap\Shorts\Testing;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
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
     * @todo add support for PDO|array<string, string|PDO>|array<string, PDO|array<string, string|PDO>> $connections, PDO instance at self::CONNECTION_PDO_KEY
     *
     * @param PDO|array<string, PDO> $connections well-known PDOs keyed by names
     *
     * @return Manager
     *
     * @see Manager::setAsGlobal() if you want to use {@see Manager} globally
     * @see Manager::bootEloquent() if you want to use {@see Model}s
     */
    public static function createCapsuleManager(PDO|array $connections): object
    {
        self::checkRequirements(
            classes: [
                Manager::class,
                Connection::class,
            ],
        );

        if ($connections instanceof PDO) {
            $connections = [self::CONNECTION_DEFAULT_NAME => $connections];
        }

        $manager = new Manager();
        foreach ($connections as $name => $connection) {
            $manager->addConnection([], $name);
            $manager->getDatabaseManager()
                ->extend($name, static fn(): Connection => new Connection($connection));
        }

        return $manager;
    }
}
