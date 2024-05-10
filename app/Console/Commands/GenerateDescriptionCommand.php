<?php

namespace App\Console\Commands;

use App\Http\Controllers\ChatGPTController;
use Illuminate\Console\Command;

class GenerateDescriptionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:description';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate ChatGPT content and review for the organizations';

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
     * @return int
     */
    public function handle()
    {
        $controller = new ChatGPTController();
        $description = $controller->getAboutUs();
        $this->info('Generate Description: ' . $description);
        return 0;
    }
}
