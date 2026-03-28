<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riddle;
use Meilisearch\Client;
use Meilisearch\Contracts\DocumentsQuery;
use Laravel\Scout\EngineManager;



class SearchController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new \Meilisearch\Client(
            config('scout.meilisearch.host'),
            config('scout.meilisearch.key')
        );
    }

    public function search(Request $request)
    {
        $riddles = Riddle::search($request->q)->get();
        return view('search', ['riddles' => $riddles, 'request' => $request]);
    }

    // изменяем список стоп-слов
    public function updateStopWords(): void
    {
        $index = $this->client->index('riddles');
        $current = $index->getSynonyms();
    }

    public function getSynonyms()
    {
        $index = $this->client->index('riddles');
        return $index->getSynonyms();
    }

    public function updateSynonyms(): void
    {
        $index = $this->client->index('riddles');
        $current = $index->getSynonyms();
        $new = [
            'не смог'       => ['не удалось', 'не получилось'],
            'не получилось' => ['не смог', 'не удалось'],
            'не удалось'    => ['не смог', 'не получилось'],
        ];

        $index->updateSynonyms(array_merge($current, $new));
    }

    public function test()
    {
        /** @var \Laravel\Scout\Engines\MeilisearchEngine $engine */
        $engine = app(EngineManager::class)->engine();

        /** @var \Meilisearch\Endpoints\Indexes $index */
        $index = $engine->getIndex('riddles');

        // $index->setProximityPrecision('byAttribute');

        /*$index->updateRankingRules([
            'words',      // количество совпавших слов
            'typo',       // исправление опечаток
            'attribute',  // учитывает searchableAttributes
        ]);
        $index->updateSearchableAttributes([
            'searchable',
            'title',
            'riddle',
        ]);*/
    }
}
