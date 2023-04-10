<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/rsync.php';


// Config

set('repository', 'https://github.com/MusheAbdulHakim/Parts-Inspection-Management-System.git');
set('ssh_multiplexing', true);

set('shared_dirs', ['storage']);
set('shared_files', ['.env']);
set('writable_dirs', [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);
set('log_files', 'storage/logs/*.log');
set('laravel_version', function () {
    $result = run('{{bin/php}} {{release_or_current_path}}/artisan --version');
    preg_match_all('/(\d+\.?)+/', $result, $matches);
    return $matches[0][0] ?? 5.5;
});

/*
 * Maintenance mode.
 */

 desc('Puts the application into maintenance / demo mode');
 task('artisan:down', artisan('down', ['showOutput']));

 desc('Brings the application out of maintenance mode');
 task('artisan:up', artisan('up', ['showOutput']));

 /*
  * Generate keys.
  */

 desc('Sets the application key');
 task('artisan:key:generate', artisan('key:generate'));

 desc('Creates the encryption keys for API authentication');
 task('artisan:passport:keys', artisan('passport:keys'));

 /*
  * Database and migrations.
  */

 desc('Runs the database migrations');
 task('artisan:migrate', artisan('migrate --force', ['skipIfNoEnv']));

 desc('Seeds the database with records');
 task('artisan:db:seed', artisan('db:seed --force', ['skipIfNoEnv', 'showOutput']));

 desc('Drops all tables and re-run all migrations');
 task('artisan:migrate:fresh', artisan('migrate:fresh --force', ['skipIfNoEnv']));

 desc('Rollbacks the last database migration');
 task('artisan:migrate:rollback', artisan('migrate:rollback --force', ['skipIfNoEnv', 'showOutput']));

 desc('Shows the status of each migration');
 task('artisan:migrate:status', artisan('migrate:status', ['skipIfNoEnv', 'showOutput']));

 /*
  * Cache and optimizations.
  */

 desc('Flushes the application cache');
 task('artisan:cache:clear', artisan('cache:clear'));

 desc('Creates a cache file for faster configuration loading');
 task('artisan:config:cache', artisan('config:cache'));

 desc('Removes the configuration cache file');
 task('artisan:config:clear', artisan('config:clear'));

 desc('Discovers and cache the application\'s events and listeners');
 task('artisan:event:cache', artisan('event:cache', ['min' => '5.8.9']));

 desc('Clears all cached events and listeners');
 task('artisan:event:clear', artisan('event:clear', ['min' => '5.8.9']));

 desc('Lists the application\'s events and listeners');
 task('artisan:event:list', artisan('event:list', ['showOutput', 'min' => '5.8.9']));

 desc('Cache the framework bootstrap files');
 task('artisan:optimize', artisan('optimize'));

 desc('Removes the cached bootstrap files');
 task('artisan:optimize:clear', artisan('optimize:clear'));

 desc('Creates a route cache file for faster route registration');
 task('artisan:route:cache', artisan('route:cache'));

 desc('Removes the route cache file');
 task('artisan:route:clear', artisan('route:clear'));

 desc('Lists all registered routes');
 task('artisan:route:list', artisan('route:list', ['showOutput']));

 desc('Creates the symbolic links configured for the application');
 task('artisan:storage:link', artisan('storage:link', ['min' => 5.3]));

 desc('Compiles all of the application\'s Blade templates');
 task('artisan:view:cache', artisan('view:cache', ['min' => 5.6]));

 desc('Clears all compiled view files');
 task('artisan:view:clear', artisan('view:clear'));



set('rsync_src', function () {
    return __DIR__; // If your project isn't in the root, you'll need to change this.
});

// Configuring the rsync exclusions.
// You'll want to exclude anything that you don't want on the production server.
add('rsync', [
    'exclude' => [
        '.git',
        '/.env',
        '/storage/',
        '/vendor/',
        '/node_modules/',
        '.github',
        'deploy.php',
    ],
]);

task('deploy:secrets', function () {
    file_put_contents(__DIR__ . '/.env', getenv('DOT_ENV'));
    upload('.env', get('deploy_path') . '/shared');
});



// Hosts

host('104.243.34.13')
    ->set('remote_user', 'altalus1')
    ->set('deploy_path', '/home/altalus1/pims.altalus.online/public');

// Hooks

after('deploy:failed', 'deploy:unlock');

/**
 * Main deploy task.
 */
desc('Deploy the application');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'rsync', // Deploy code & built assets
    'deploy:secrets', // Deploy secrets
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link', // |
    'artisan:view:cache',   // |
    'artisan:config:cache', // | Laravel specific steps
    'artisan:optimize',     // |
    'artisan:migrate',      // |
    'artisan:db:seed',
    'deploy:symlink',
    'deploy:unlock',
    'deploy:publish',
]);
