<?php

declare(strict_types=1);

namespace PetrKnap\Shorts;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class FilterCommand
{
    use HasRequirements;

    /**
     * @param non-empty-string $command
     * @param array<non-empty-string> $options
     */
    public function __construct(
        private readonly string $command,
        private readonly array $options = [],
    ) {
        self::checkRequirements(
            classes: [
                Process::class,
                ProcessFailedException::class,
            ],
        );
    }

    /**
     * @throws Exception\FilterCommandCouldNotFilterData
     */
    public function filter(string $data): string
    {
        $process = new Process([
            $this->command,
            ...$this->options,
        ]);
        $process->setInput($data);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new Exception\FilterCommandCouldNotFilterData(__METHOD__, $data, new ProcessFailedException($process));
        }
        return $process->getOutput();
    }
}
