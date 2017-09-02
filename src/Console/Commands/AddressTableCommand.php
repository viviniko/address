<?php

namespace Viviniko\Address\Console\Commands;

use Viviniko\Support\Console\CreateMigrationCommand;

class AddressTableCommand extends CreateMigrationCommand
{
    /**
     * @var string
     */
    protected $name = 'address:table';

    /**
     * @var string
     */
    protected $description = 'Create a migration for the address service table';

    /**
     * @var string
     */
    protected $stub = __DIR__.'/stubs/address.stub';

    /**
     * @var string
     */
    protected $migration = 'create_address_table';
}
