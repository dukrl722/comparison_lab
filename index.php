<?php

declare(strict_types = 1);

require __DIR__ . '/vendor/autoload.php';

function benchmark(callable $method, string $name, int $repeat = 100): void
{
    $initialMemory = memory_get_peak_usage();

    $start = hrtime(true);

    for ($i = 0; $i < $repeat; $i++) {
        $method();
    }

    $end = hrtime(true);

    $finalMemory = memory_get_peak_usage();

    $timeInNanoseconds       = $end - $start;
    $averageMillisecondsTime = ($timeInNanoseconds / $repeat) / 1_000_000;
    $usedMemory              = ($finalMemory - $initialMemory) / 1024;

    echo "Benchmark: $name \n";
    echo 'Average Time: ' . number_format($averageMillisecondsTime, 4) . "ms\n";
    echo 'Memory Peak: ' . number_format($usedMemory, 4) . "KB\n";
}
