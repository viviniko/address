<?php

namespace Viviniko\Address\Console;

use Viviniko\Address\Models\Country;
use Illuminate\Console\Command;

class CountrySeedCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'address:country:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Countries.';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        Country::truncate();

        foreach ($this->getCountries() as $country) {
            Country::create($country);
        }
    }

    protected function getCountries()
    {
        return json_decode(file_get_contents(__DIR__.'/stubs/countries.json'), true);
    }
}
