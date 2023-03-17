<?php
namespace App\Settings;
use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $logo,$favicon,$currency;
    
    
    public static function group(): string
    {
        return 'general';
    }
}