<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.logo','');
        $this->migrator->add('general.favicon','');
        $this->migrator->add('general.currency','');
    }
}
