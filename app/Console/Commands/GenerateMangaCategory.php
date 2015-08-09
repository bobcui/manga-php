<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;
use App\Manga;
use App\MangaCategory;

class GenerateMangaCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manga:generate-manga-category';

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
        $mangaCount = Manga::count();
        $offset = 0;
        $limit = 1000;

        $this->output->progressStart($mangaCount);

        DB::beginTransaction();
        DB::table('manga_category')->delete();

        while ($offset < $mangaCount) {
            $mangas = Manga::select(['id', 'cat'])
                ->orderBy('id', 'asc')
                ->skip($offset)
                ->take($limit)
                ->get();

            foreach ($mangas as $manga) {
                foreach ($manga->cat as $catId) {
                    if ($catId != '') {
                        $mangaCategory = new MangaCategory;
                        $mangaCategory->mng_id = $manga->id;
                        $mangaCategory->cat_id = $catId;
                        $mangaCategory->save();
                    }
                }

                $this->output->progressAdvance();
            }

            $offset += $limit;
        }

        DB::commit();

        $this->output->progressFinish();        
    }
}
