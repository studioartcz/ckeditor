<?php

namespace StudioArtCz;

use Nette\Application\Request;
use Nette\Application\UI\Presenter;
use Nette\Security\User;
use elFinderConnector;
use elFinder;

class FmanPresenter extends Presenter
{
    private $url;
    private $fman_folder;

    public function __construct(Request $request, User $user)
    {
        if(!$user->isLoggedIn()) {
            http_response_code(403);
            die();
        }

        $this->url = $request->getUrl()->baseUrl;
        $this->fman_folder = '/img/fman/'; // todo: make by config
    }

    /**
     * Setup on ./api/fman/connector page
     */
    public function actionConnector() {

        if(!file_exists(WWW_DIR . $this->fman_folder)) {
            mkdir(WWW_DIR . $this->fman_folder, 777, true);
        }

        $opts = array(
            'debug' => true,
            'locale' => '',
            'roots'  => array(
                array(
                    'driver' => 'LocalFileSystem',
                    'path'   => WWW_DIR . $this->fman_folder,
                    'URL'    => $this->url . $this->fman_folder,
                    'alias'      => 'Home',
                    'mimeDetect' => 'internal',
                    'imgLib'     => 'gd',
                    'tmbPath'    => 'thumbnails',
                )
            )
        );

        // run elFinder
        $connector = new elFinderConnector(new elFinder($opts));
        $this->template->connector = $connector->run();
    }

    /**
     * Default render
     */
    public function actionDefault()
    {
        $this->template->fman_url  = $this->url . "/fman";
        $this->template->connector = "./fman/connector";
    }
}