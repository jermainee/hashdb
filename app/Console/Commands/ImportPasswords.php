<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImportPasswords extends Command
{
    protected $signature = 'passwords:import';

    protected $description = 'import passwords from txt';

    public function handle(): int
    {
        $lists = Storage::files('lists');

        foreach($lists as $listPath) {
            $this->importList($listPath);
        }

        return 0;
    }

    private function importList(string $listPath): void
    {
        $iterator = $this->readFile(Storage::disk('local')->getAdapter()->applyPathPrefix($listPath));

        do {
            $passwords = $this->iterateChunk($iterator);
            $this->insertData($passwords);
        } while (count($passwords) > 0);
    }

    private function iterateChunk(iterable &$iterator, int $chunkSize = 50): array
    {
        $passwords = [];
        $dateTime = new Carbon();

        while ($iterator->valid()) {
            if ((bool) $chunkSize-- === false) {
                break;
            }

            print('.');

            $passwords[] = [
                'value' => $iterator->current(),
                'created_at' =>  $dateTime,
                'updated_at' =>  $dateTime,
            ];

            $iterator->next();
        }

        return $passwords;
    }

    private function insertData(array $passwords): void
    {
        DB::table('passwords')->insertOrIgnore($passwords);
    }

    private function readFile(string $listPath): iterable
    {
        $handle = fopen($listPath, "r");

        while(!feof($handle)) {
            yield trim(fgets($handle));
        }

        fclose($handle);
    }
}
