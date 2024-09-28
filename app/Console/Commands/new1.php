<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class new1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'new1:run';

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
        \Log::info('new1:run command started.');
        
        $response =Http::get('https://stagging.jookwang.me/api/daily-rate-updates');


        if ($response->successful()) {
            
            $sevenDaysAgo = Carbon::now()->subDays(7)->format('Y-m-d');

        
            DB::table('daily_rates')
                ->where('arrival_date', '<=', $sevenDaysAgo)
                ->delete();

            $this->info('Rates updates & Old daily rates have been deleted.');
            
        } else {
            $this->error('Failed to hit the daily rate updates API.');
        }
    
        \Log::info('new1:run command finished.');
    }

}
