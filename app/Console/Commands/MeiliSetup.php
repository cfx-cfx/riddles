<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Meilisearch\Client;

class MeiliSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:meili-setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(Client $client)
    {
        $client->index('riddles')->updateSettings([
            'searchableAttributes' => [
                'title',
                'riddle',
            ],
            'synonyms' => [],
        ]);

        $this->info('Meilisearch settings applied');
    }
}
