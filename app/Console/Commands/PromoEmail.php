<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PromoEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promo:email {status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invia Email di promozione del servizio';

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
        $update_promo_email = $this->argument('status');
        $this->info('promo:email Comando funziona correttamente - !'.$update_promo_email);
    }
}
