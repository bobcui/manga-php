<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\SetMangaAuthors::class,
        \App\Console\Commands\SetChapterPageCount::class,
        \App\Console\Commands\GenerateMangaCategory::class,
    ];

    /**
     * Define the application's command schedule.
     *`
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('manga:set-authors')->everyMinute();
        $schedule->command('manga:set-chapter-page-count')->everyMinute(); 
        $schedule->command('manga:generate-manga-category')->dailyAt('5:00');
    }
}
