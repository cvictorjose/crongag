<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use DB;
use Mail;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;

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
        $app = app();
        $environment = $app->environment();


        switch ($environment) {
            // local
            case 'local':

                try {
                    $update_promo_email = $this->argument('status');
                    //$this->info('promo:email Comando funziona correttamente - !'.$update_promo_email);

                    $users = array();
                    $users = DB::table('users')->where('status', 0)->orderBy('id', 'desc')->get();


                    foreach ($users as $user) {
                        DB::table('users')
                            ->where('id', $user->id)
                            ->update(['status' => 1]);
                        \Log::info('Email promozionale inviata:'.$user->email);
                        $this->info('Email promozionale inviata:'.$user->email);
                    }


                } catch (\Exception $e) {
                    // registrazione dell'informazione dell'errore generato.

                    switch ($e->getStatusCode()) {
                        // not found
                        case 404:
                            \Log::warning('Errore 404' . $e->getMessage());
                            break;
                        // internal error
                        case 500:
                            \Log::alert('Errore 500' . $e->getMessage());
                            $this->send_email($e->getMessage(),$e->getStatusCode());
                            break;
                        default:
                            $log = new Logger('name');
                            $log->pushHandler(new RotatingFileHandler(storage_path().'/logs/debug/debug.log',2,Logger::INFO));
                            $log->info($e->getMessage());
                            break;
                    }
                }
                break;
            // Dev
            case 'development':
                //Funzione per interfacciarsi con il server di produzione
                break;

            case 'staging':
                //Funzione per interfacciarsi con il server di test
                break;
        }
    }

    public function send_email($e, $getStatusCode){
        Mail::send('emails.exception', ['error' => $e->getMessage(), 'code' => $getStatusCode], function ($m) {
            $m->to('email@email.com', 'Server Message')->subject('Error');
        });
    }


}
