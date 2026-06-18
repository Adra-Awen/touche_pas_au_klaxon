<?php

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testDatabaseClassExists(): void
    {
        $this->assertTrue(
            class_exists(\Config\Database::class)
        );
    }
}