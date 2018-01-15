<?php

namespace Ridoy\LaravelInstaller\Helpers;

use Exception;
use Illuminate\Http\Request;

class EnvironmentManager
{
    /**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    /**
     * Get the content of the .env file.
     *
     * @return string
     */
    public function getEnvContent()
    {
        if (!file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }

        return file_get_contents($this->envPath);
    }

    /**
     * Get the the .env file path.
     *
     * @return string
     */
    public function getEnvPath() {
        return $this->envPath;
    }

    /**
     * Get the the .env.example file path.
     *
     * @return string
     */
    public function getEnvExamplePath() {
        return $this->envExamplePath;
    }

    /**
     * Save the edited content to the .env file.
     *
     * @param Request $input
     * @return string
     */
    public function saveFileClassic(Request $input)
    {
        $message = trans('installer_messages.environment.success');

        try {
            file_put_contents($this->envPath, $input->get('envConfig'));
        }
        catch(Exception $e) {
            $message = trans('installer_messages.environment.errors');
        }

        return $message;
    }

    /**
     * Save the form content to the .env file.
     *
     * @param Request $request
     * @return string
     */
    public function saveFileWizard(Request $request)
    {
        $results = trans('installer_messages.environment.success');

        $envFileData =
        'APP_NAME=' . 'SoftKing' . "\n" .
        'APP_ENV=' .'local' . "\n" .
        'APP_KEY=' . 'base64:bODi8VtmENqnjklBmNJzQcTTSC8jNjBysfnjQN59btE=' . "\n" .
        'APP_DEBUG=' . 'true' . "\n" .
        'APP_LOG_LEVEL=' . 'debug' . "\n" .
        'APP_URL=' . $request->app_url . "\n\n" .
        'DB_CONNECTION=' . 'mysql' . "\n" .
        'DB_HOST=' . $request->database_hostname . "\n" .
        'DB_PORT=' . '3306' . "\n" .
        'DB_DATABASE=' . $request->database_name . "\n" .
        'DB_USERNAME=' . $request->database_username . "\n" .
        'DB_PASSWORD=' . $request->database_password . "\n\n" .
        'BROADCAST_DRIVER=' . 'log' . "\n" .
        'CACHE_DRIVER=' . 'file' . "\n" .
        'SESSION_DRIVER=' . 'file' . "\n" .
        'QUEUE_DRIVER=' . 'sync' . "\n\n" .
        'REDIS_HOST=' . '127.0.0.1' . "\n" .
        'REDIS_PASSWORD=' . 'null' . "\n" .
        'REDIS_PORT=' . '6379' . "\n\n" .
        'MAIL_DRIVER=' . 'smtp' . "\n" .
        'MAIL_HOST=' . 'null' . "\n" .
        'MAIL_PORT=' .'null' . "\n" .
        'MAIL_USERNAME=' . '' . "\n" .
        'MAIL_PASSWORD=' . '' . "\n" .
        'MAIL_ENCRYPTION=' . 'null' . "\n\n" .
        'PUSHER_APP_ID=' . '' . "\n" .
        'PUSHER_APP_KEY=' . '' . "\n" .
        'PUSHER_APP_SECRET=' . ''.
        'envato_username=' . $request->envato_username . "\n" .
        'envato_purchase_code=' . $request->envato_purchase_code;

        try {
            file_put_contents($this->envPath, $envFileData);

        }
        catch(Exception $e) {
            $results = trans('installer_messages.environment.errors');
        }

        return $results;
    }
}
