<?php

declare(strict_types=1);

namespace Nakukryskin\OrchidFlexibleContentField\Commands;

use Illuminate\Console\Command;

/**
 * Class LinkCommand.
 */
class LinkCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'orchid:flexible_content:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a symbolic link from "orchid-flexible-content-field/public" to "public/'.ORCHID_FLEXIBLE_CONTENT_PUBLIC_ASSET_PATH.'"';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->updateGitIgnore();

        if (file_exists(public_path(ORCHID_FLEXIBLE_CONTENT_PUBLIC_ASSET_PATH))) {
            $this->error('The "public/'.ORCHID_FLEXIBLE_CONTENT_PUBLIC_ASSET_PATH.'" directory already exists.');

            return;
        }

        $this->laravel->make('files')->link(realpath(ORCHID_FLEXIBLE_CONTENT_FIELD_PACKAGE_PATH.'/public'),
            public_path(ORCHID_FLEXIBLE_CONTENT_PUBLIC_ASSET_PATH));

        $this->info('The [/public/'.ORCHID_FLEXIBLE_CONTENT_PUBLIC_ASSET_PATH.'] directory has been linked.');
    }

    /**
     * Adding orchid_repeater to .gitignore.
     */
    private function updateGitIgnore(): void
    {
        if (! file_exists(app_path('../.gitignore'))) {
            $this->warn('Unable to locate ".gitignore".  Did you move this file?');
            $this->warn('A semantic link to public files was not added to the ignore list');

            return;
        }

        $str = file_get_contents(app_path('../.gitignore'));

        if ($str !== false && strpos($str, '/public/'.ORCHID_FLEXIBLE_CONTENT_PUBLIC_ASSET_PATH) === false) {
            file_put_contents(app_path('../.gitignore'),
                $str.PHP_EOL.'/public/'.ORCHID_FLEXIBLE_CONTENT_PUBLIC_ASSET_PATH.PHP_EOL);
        }
    }
}
