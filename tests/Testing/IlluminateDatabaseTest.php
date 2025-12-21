<?php

declare(strict_types=1);

namespace PetrKnap\Shorts\Testing;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Eloquent\Model;
use PDO;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;

final class IlluminateDatabaseTest extends TestCase
{
    public const SQL_TABLE = 'table';
    private const SQL_CREATE_TABLE = 'CREATE TABLE `' . self::SQL_TABLE . '` (`value` INTEGER)';
    private const SQL_INSERT_INTO = 'INSERT INTO `' . self::SQL_TABLE . '` (`value`) VALUES (?)';

    private array $pdos;

    protected function setUp(): void
    {
        parent::setUp();

        $pdo1 = new PDO('sqlite::memory:');
        $pdo1->exec(self::SQL_CREATE_TABLE);
        $pdo1->prepare(self::SQL_INSERT_INTO)->execute([1]);

        $pdo2 = new PDO('sqlite::memory:');
        $pdo2->exec(self::SQL_CREATE_TABLE);
        $pdo2->prepare(self::SQL_INSERT_INTO)->execute([2]);

        $this->pdos = [
            'pdo1' => $pdo1,
            'pdo2' => $pdo2,
        ];
    }

    public function testCreatesCapsuleManager(): Manager
    {
        $capsuleManager = IlluminateDatabase::createCapsuleManager($this->pdos);

        self::assertInstanceOf(Manager::class, $capsuleManager);
        foreach ($this->pdos as $name => $pdo) {
            self::assertSame($pdo, $capsuleManager->getConnection($name)->getPdo());
        }

        return $capsuleManager;
    }

    #[Depends('testCreatesCapsuleManager')]
    public function testCreatedCapsuleManagerWorksWithEloquent(Manager $manager): void
    {
        $manager->bootEloquent();

        self::assertSame(
            [
                'pdo1' => [1],
                'pdo2' => [2],
            ],
            [
                'pdo1' => self::createModel('pdo1')->newQuery()->pluck('value')->all(),
                'pdo2' => self::createModel('pdo2')->newQuery()->pluck('value')->all(),
            ]
        );
    }

    private static function createModel(string $connection): Model
    {
        $model = new class () extends Model {
            protected $table = IlluminateDatabaseTest::SQL_TABLE;
            public $timestamps = false;
        };
        $model->setConnection($connection);
        return $model;
    }
}
