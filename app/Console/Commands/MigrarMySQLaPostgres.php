<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:migrar-my-s-q-la-postgres')]
#[Description('Command description')]
class MigrarMySQLaPostgres extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
