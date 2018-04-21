<?php
/**
 * This file is part of the Passwords App
 * created by Marius David Wieschollek
 * and licensed under the AGPL.
 */

namespace OCA\Passwords\Helper\Settings;

use OCA\Passwords\Services\ConfigurationService;
use OCP\IURLGenerator;

/**
 * Class ServerSettingsHelper
 *
 * @package OCA\Passwords\Helper\Settings
 */
class ServerSettingsHelper {

    const SERVER_MANUAL_URL = 'https://raw.githubusercontent.com/wiki/marius-wieschollek/passwords/Users/';

    /**
     * @var ConfigurationService
     */
    protected $config;

    /**
     * @var IURLGenerator
     */
    protected $urlGenerator;

    /**
     * @var ShareSettingsHelper
     */
    protected $shareSettings;

    /**
     * @var ThemeSettingsHelper
     */
    protected $themeSettings;

    /**
     * ServerSettingsHelper constructor.
     *
     * @param IURLGenerator        $urlGenerator
     * @param ConfigurationService $config
     * @param ShareSettingsHelper  $shareSettings
     * @param ThemeSettingsHelper  $themeSettings
     */
    public function __construct(
        IURLGenerator $urlGenerator,
        ConfigurationService $config,
        ShareSettingsHelper $shareSettings,
        ThemeSettingsHelper $themeSettings
    ) {
        $this->urlGenerator  = $urlGenerator;
        $this->shareSettings = $shareSettings;
        $this->themeSettings = $themeSettings;
        $this->config        = $config;
    }

    /**
     * @param string $key
     *
     * @return null|string
     */
    public function get(string $key) {
        if(strpos($key, '.') !== false) {
            list($scope, $subKey) = explode('.', $key, 2);
        } else {
            $scope  = $key;
            $subKey = '';
        }

        switch($scope) {
            case 'version':
                return $this->getServerVersion();
            case 'baseUrl':
                return $this->urlGenerator->getBaseUrl();
            case 'theme':
                return $this->themeSettings->get($subKey);
            case 'sharing':
                return $this->shareSettings->get($subKey);
            case 'handbook':
                $handbookUrl = $this->config->getAppValue('handbook/url', self::SERVER_MANUAL_URL);
                return empty($handbookUrl) ? self::SERVER_MANUAL_URL:$handbookUrl;
        }

        return null;
    }

    /**
     * @return array
     */
    public function list(): array {
        return array_merge(
            [
                'server.baseUrl'    => $this->get('baseUrl'),
                'server.version'    => $this->get('version'),
                'server.handbook.url' => $this->get('handbook.url')
            ],
            $this->themeSettings->list(),
            $this->shareSettings->list()
        );
    }

    /**
     * @return string
     */
    protected function getServerVersion(): string {
        $version = $this->config->getSystemValue('version');

        return explode('.', $version, 2)[0];
    }
}