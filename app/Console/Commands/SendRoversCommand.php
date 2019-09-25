<?php

namespace App\Console\Commands;

use App\ControlCentre\ControlCentre;
use Illuminate\Console\Command;

class SendRoversCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rover:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send rovers on a journey across a world';

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
        $size = $this->ask('What is the map size?');
        $this->mappingData = [];
        $this->mappingData[] = $size;

        $this->askForRoutes();

        $controlCentre = app(ControlCentre::class);

        $routeData = implode("\n", $this->mappingData);

        $controlCentre->configureRoutes($routeData);

        $controlCentre->executeRoutes();

        $this->info($controlCentre->locateRovers());
    }

    public function askForRoutes(): void
    {
        $this->mappingData[] = $this->ask('Please give a mapping.');

        if ($this->confirm('Do you wish to add another mapping?')) {
            $this->askForRoutes();
        }
    }

}
