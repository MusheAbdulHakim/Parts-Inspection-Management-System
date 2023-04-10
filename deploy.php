<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/rsync.php';



// Config

set('repository', 'https://github.com/MusheAbdulHakim/Parts-Inspection-Management-System.git');

set('ssh_multiplexing', true); // Speed up deployment

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


host(' altalus.online') // Name of the server
    ->real_hostname('104.243.34.13') // Hostname or IP address
    ->stage('production') // Deployment stage (production, staging, etc)
    ->remote_user('altalus1') // SSH user
    ->set('deploy_path', '/home/altalus1/pims.altalus.online/public'); // Deploy path

// Set up a deployer task to copy secrets to the server.
// Grabs the dotenv file from the github secret
task('deploy:secrets', function () {
    file_put_contents(__DIR__ . '/.env', getenv('DOT_ENV'));
    upload('.env', get('deploy_path') . '/shared');
});

// Hooks

after('deploy:failed', 'deploy:unlock'); // Unlock after failed deploy

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
    'cleanup',
]);
