<?php

final class DemoFile
{
    public function run(): int
    {
        return 5;

        // we never get here
        return 10;
    }
}
