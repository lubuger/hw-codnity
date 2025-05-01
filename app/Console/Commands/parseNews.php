<?php

namespace App\Console\Commands;

use App\Http\Controllers\NewsController;
use Illuminate\Console\Command;

class parseNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses news from https://news.ycombinator.com';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        (new \App\Http\Controllers\NewsController)->parse();

        $this->info("Parsing completed");
    }
}
