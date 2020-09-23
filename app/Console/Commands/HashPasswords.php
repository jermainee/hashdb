<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HashPasswords extends Command
{
    protected $signature = 'passwords:hash';

    protected $description = 'hash passwords';

    public function handle(): int
    {
        DB::table('passwords')->orderBy('updated_at', 'asc')->chunk(100, function($passwords) {
            $this->hashPasswords($passwords);
        });

        return 0;
    }

    private function hashPasswords(Collection $passwords): void
    {
        foreach($passwords as $password) {
            print('.');

            $this->generateHashes($password);
        }
    }

    private function generateHashes(\stdClass $password): void
    {
        $rows = [];

        foreach(hash_algos() as $algorithm) {
            $rows[] = $this->generateDataRow($password, $algorithm);
        }

        $this->insertData($rows);
    }

    private function generateDataRow(\stdClass $password, string $algorithm): array
    {
        $dateTime = new Carbon();

        return [
            'hash' => hash($algorithm, $password->value),
            'algorithm' => $algorithm,
            'password_id' => $password->id,
            'created_at' =>  $dateTime,
            'updated_at' =>  $dateTime,
        ];
    }

    private function insertData(array $hashes): void
    {
        DB::table('hashes')->insertOrIgnore($hashes);
    }
}
