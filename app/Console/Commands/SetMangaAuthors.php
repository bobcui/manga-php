<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

use App\Manga;

class SetMangaAuthors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manga:set-authors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mangas = Manga::select(['id', 'ath'])->whereNull('authors')->get();
        
        $this->output->progressStart(count($mangas));

        foreach ($mangas as $manga) {
            $authorIds = explode(',', trim($manga->ath, ','));
            $authorNames = $this->getAuthorNames($authorIds);
            $manga->authors = $authorNames;
            $manga->save();
            $this->output->progressAdvance();
        }

        $this->output->progressFinish();

    }

    private function getAuthorNames($authorIds)
    {
        $results = DB::table('wp_wpm_mng_ppl')->select('nme')->whereIn('id', $authorIds)->get();
        $names = [];
        foreach ($results as $result) {
            $names[] = $result->nme;
        }
        return $names;
    }
}
