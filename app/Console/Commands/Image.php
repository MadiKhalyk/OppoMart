<?php

namespace App\Console\Commands;

use App\Models\DiscountImage;
use Illuminate\Console\Command;

class Image extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       dd( \App\Models\ComboDiscount::first()->images);
    }
}
