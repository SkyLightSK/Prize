<?php

namespace App\Console\Commands;

use App\Money;
use App\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;


class SendMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'money:send {per_run : Number of packets sent at once. }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for sending prize money to users';

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
        $money = Money::where('active', true)->get();
        $per_run = $money->count() < $this->argument('per_run') ? $money->count() : $this->argument('per_run') ;

        if ( !$money->count() ){
            return $this->line('No available users with cash');
        }

        $bar = $this->output->createProgressBar($per_run);

        $bar->start();

        for ($i = 0 ; $i < $per_run ; $i++)
        {
            $money[$i]->update([ "active" => false ]);

            $bar->advance();
            $this->line(PHP_EOL . 'Money Prize #' . $money[$i]->prize_id . ' sended');
        }

        $bar->finish();
        $this->line(PHP_EOL );
    }
}
