<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class MeilisearchStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:meili-start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Meilsearch server start';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $binary = base_path('meilisearch.exe');
        $dataPath = base_path('meili-data');
        $host = '127.0.0.1:7700';
        $key = config('scout.meilisearch.key');

        if (!file_exists($binary)) {
            $this->error('meilisearch.exe not found in project root');
            return self::FAILURE;
        }

        $command = [
            $binary,
            '--http-addr',
            $host,
            '--db-path',
            $dataPath,
        ];

        if (!empty($key)) {
            $command[] = '--master-key';
            $command[] = $key;
        }

        $this->info('Starting Meilisearch...');
        $this->line(implode(' ', $command));

        $process = new Process($command, base_path());
        $process->setTimeout(null);
        $process->start();

        foreach ($process as $type => $data) {
            echo $data;
        }

        return self::SUCCESS;
    }
}
