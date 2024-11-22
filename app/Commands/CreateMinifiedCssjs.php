<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use MatthiasMullie\Minify;

class CreateMinifiedCssjs extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'App';
    protected $theme = 'public/theme/';
    protected $newLanding = 'public/new-landing/assets/';
    protected $version = '1.0.33';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'minify:assets';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Used to minify CSS and JS files and save to public/style-v-x-x.css and style-x-x.js.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'minify:assets [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $this->minifyCss();
        $this->minifyJs();
    }

    private function minifyCss() : void {
        CLI::write('Minifying CSS files...', 'green');
        $cssFiles = [
            ROOTPATH . $this->newLanding.'css/bootstrap.min.css',
            ROOTPATH . $this->newLanding.'css/odometer.min.css',
            ROOTPATH . $this->newLanding.'css/nice-select.css',
            ROOTPATH . $this->newLanding.'css/swiper.min.css',
            ROOTPATH . $this->newLanding.'css/main.css',
            ROOTPATH . $this->newLanding.'css/zappta.css',
            ROOTPATH . $this->newLanding.'css/lightslider.css',
            ROOTPATH . $this->newLanding.'css/inner-pages.css',
            ROOTPATH . $this->newLanding.'css/loader.css',
        ];

        // Initialize the Minify\CSS instance
        $minifier = new Minify\CSS();

        // Add each CSS file to the minifier
        foreach ($cssFiles as $file) {
            if (file_exists($file)) {
                $minifier->add($file);
                CLI::write("Added: $file", 'green');
            } else {
                CLI::write("File not found: $file", 'yellow');
            }
        }

        // Define the output path for the minified file
        if(!is_dir(ROOTPATH . 'public/minified/css')) {
            mkdir(ROOTPATH . 'public/minified/css', 0777, true);
        }
        $minifiedPath = ROOTPATH . 'public/minified/css/styles-'.$this->version.'.min.css';

        // Minify and save the output
        try {
            $minifier->minify($minifiedPath);
            CLI::write("CSS files have been minified and saved to $minifiedPath", 'green');
        } catch (\Exception $e) {
            CLI::write("Error: " . $e->getMessage(), 'red');
        }
    }

    private function minifyjs() : void {
        $jsFiles = [
            ROOTPATH . $this->newLanding.'js/jquary-3.6.0.min.js',
            ROOTPATH . $this->newLanding.'js/swiper.min.js',
            ROOTPATH . $this->newLanding.'js/imagesloaded-pkgd.js',
            ROOTPATH . $this->newLanding.'js/waypoints.min.js',
            ROOTPATH . $this->newLanding.'js/odometer.min.js',
            ROOTPATH . $this->newLanding.'js/smooth-scroll.js',
            ROOTPATH . $this->newLanding.'js/jquery.isotope.js',
            ROOTPATH . $this->newLanding.'js/countdown.js',
            ROOTPATH . $this->newLanding.'js/nice-select.js',
            ROOTPATH . $this->newLanding.'js/contact.js',
            ROOTPATH . $this->newLanding.'js/main.js',
            ROOTPATH . $this->newLanding.'js/login.js',
            ROOTPATH . $this->newLanding.'js/notifications.js',
            ROOTPATH . $this->theme.'js/bundle.js',
            ROOTPATH . $this->theme.'js/notify.js',
            ROOTPATH . $this->theme.'js/themee.js',
            ROOTPATH . $this->theme.'js/cart.js',
            ROOTPATH . $this->theme.'js/main.js'
        ];

        // Initialize the Minify\JS instance
        $minifier = new Minify\JS();

        // Add each JS file to the minifier
        foreach ($jsFiles as $file) {
            if (file_exists($file)) {
                $minifier->add($file);
                CLI::write("Added: $file", 'green');
            } else {
                CLI::write("File not found: $file", 'yellow');
            }
        }

        // Define the output path for the minified file
        if(!is_dir(ROOTPATH . 'public/minified/js')) {
            mkdir(ROOTPATH . 'public/minified/js', 0777, true);
        }
        $minifiedPath = ROOTPATH . 'public/minified/js/scripts-'.$this->version.'.min.js';

        // Minify and save the output
        try {
            $minifier->minify($minifiedPath);
            CLI::write("JS files have been minified and saved to $minifiedPath", 'green');
        } catch (\Exception $e) {
            CLI::write("Error: " . $e->getMessage(), 'red');
        }
    }
}
