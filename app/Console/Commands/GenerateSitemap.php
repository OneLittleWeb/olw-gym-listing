<?php

namespace App\Console\Commands;

use App\Http\Controllers\SitemapController;
use App\Notifications\SitemapUpdateNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will generate sitemap files';

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
       try {
            File::ensureDirectoryExists(public_path('old_sitemaps'));
            $path = public_path('old_sitemaps');
            $files = File::cleanDirectory($path);
            $searchFiles = File::glob(public_path() . '/' . 'sitemap*');
            foreach ($searchFiles as $f) {
                $filename = substr($f, strrpos($f, '/') + 1);
                File::move(public_path() . '/' . $filename, public_path('old_sitemaps') . '/' . $filename);
            }
            $sitemap = new SitemapController();
            $sitemap->sitemapStore();
            $message = 'Hey, GymNearX sitemap is updated on ' . Carbon::now()->format('d m Y.');
            Notification::send('nothing', new  SitemapUpdateNotification($message));
        } catch (\Exception $e) {
            $message = 'Hey, There is an issue please check ';
            Notification::send('nothing', new  SitemapUpdateNotification($message));
        } catch (\Error $e){
            $message = 'Hey, There is an error: '.$e->getMessage();
            Notification::send('nothing', new  SitemapUpdateNotification($message));
        }
    }
}
