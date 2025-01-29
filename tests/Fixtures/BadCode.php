<?php

namespace Tests\Fixtures;

final class BadCode
{
    public function run(): int
    {
        return 5;

        // we never get here
        return 10;
    }
}
