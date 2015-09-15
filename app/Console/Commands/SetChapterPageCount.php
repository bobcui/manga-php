<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

use App\Chapter;

class SetChapterPageCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manga:set-chapter-page-count';

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
        $pagePathTemplate = Config::get('manga.chapter_page_path');
        $endDateTime = date('Y-m-d H:i:s', time()-60*10);

        $nonPageCountChapterCount = Chapter::select(['mng_id', 'dir_pth'])
            ->where('dte_upd', '<=', $endDateTime)
            ->where('sts', '=', 1)
            ->whereNull('pageCount')
            ->count();

        $offset = 0;
        $limit = 1000;

        $this->output->progressStart($nonPageCountChapterCount);

        while ($offset < $nonPageCountChapterCount) {
            $nonPageCountChapters = Chapter::select(['id', 'mng_id', 'dir_pth'])
                ->where('dte_upd', '<=', $endDateTime)
                ->where('sts', '=', 1)
                ->whereNull('pageCount')
                ->orderBy('id', 'asc')
                ->skip($offset)
                ->take($limit)
                ->get();

            foreach ($nonPageCountChapters as $chapter) {
                $pagePath = strtr($pagePathTemplate, array(
                    '{manga-id}' => $chapter->mng_id,
                    '{chapter-idx}' => $chapter->dir_pth
                ));
                echo $chapter,"\n";

                if ($chapter->dir_pth !== '' && file_exists($pagePath)) {
                    $chapter->pageCount = count(glob("${pagePath}/p_*.jpg"));       
                    $chapter->save();
                }

                $this->output->progressAdvance();
            }

            $offset += $limit;
        }

        $this->output->progressFinish();
    }
}
