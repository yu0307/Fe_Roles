<?php

namespace FeIron\Fe_Roles\commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class fe_build_UserClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Build:BuildUserClass';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Used by Fe_Roles to build a user model that extends the current provider model.';

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
        $file=dirname(__DIR__, 1) . '/models/fe_User.php';
        file_put_contents($file,
                preg_replace(
                    '/(extends\s)[\w\\\\]*((?>\r\n|\n|\r)implements)/i',
                    '${1} \\' . (ltrim(Config::get('auth.providers.' . Config::get('auth.guards.' . Config::get('auth.defaults.guard') . '.provider') . '.model'), "\\")) . '${2}',
                    file_get_contents($file)
                )
            );
        return true;
    }
}
