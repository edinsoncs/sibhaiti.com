<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RunDataFix extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'RunDataFix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to fix data.';

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
    public function fire()
    {
        $animals = Animal::where('datIdantFix', NULL)->limit(10000)->get();

        foreach ($animals as $item)
        {
            if ($item->datIdant)
            {
                $data = explode("/", $item->datIdant);
                if (array_get($data, 2))
                {
                    $item->datIdantFix = array_get($data, 2) . "-" . array_get($data, 1) . "-" . array_get($data, 0) . " 00:00:00";
                    $item->save();
                }
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
        return array(
            array('example', InputArgument::REQUIRED, 'An example argument.'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
        return array(
            array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
        );
    }

}
