<?php

namespace HaoZiTeam\LaravelInstaller\Helpers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    public function getEnvPath()
    {
        return $this->envPath;
    }

    /**
     * Get the the .env.example file path.
     *
     * @return string
     */
    public function getEnvExamplePath()
    {
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
        } catch (Exception $e) {
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
        $envFileData = '';
        $env_vars_data = $request->all();

        foreach ($env_vars_data as $env_var_name => $env_var_value) {
            if (in_array($env_var_name, config('installer.environment.ignoreOnSave'))) {
                continue;
            }
            if (!empty($env_var_value)) {

                if ($env_var_name === 'app_url') {
                    $env_var_value = rtrim($env_var_value, '/');
                }

                $envFileData .= mb_strtoupper($env_var_name) . '="' . $env_var_value . "\"\n";



            }
        }

        $envFileData .= 'APP_KEY=' . 'base64:' . base64_encode(Str::random(32)) . "\n";

        try {
            file_put_contents($this->envPath, $envFileData);
        } catch (Exception $e) {
            $results = trans('installer_messages.environment.errors');
        }

        return $results;
    }



    public function addEnvVar($env_var_name, $value): void
    {

        $env_path = $this->getEnvPath();

        if ($this->envVarExists($env_var_name)) {
            $this->updateEnvVar($env_var_name, $value);
        } else {
            $content_to_add = sprintf('%s="%s"', $env_var_name, $value) . PHP_EOL;
            file_put_contents($env_path, $content_to_add, FILE_APPEND);
        }

    }

    public function updateEnvVar($env_var_name, $new_value): void
    {

        $env_path = $this->getEnvPath();
        $lines = file($env_path);
        $content = '';

        foreach ($lines as $line) {
            if (str_starts_with(trim($line), $env_var_name)) {
                $content .= sprintf('%s="%s"', $env_var_name, $new_value) . PHP_EOL;
            } else {
                $content .= $line;
            }
        }

        file_put_contents($env_path, $content);

    }

    public function deleteEnvVar($env_var_name): void
    {

        $env_path = $this->getEnvPath();
        $lines = file($env_path);
        $content = '';

        foreach ($lines as $line) {
            if (!str_starts_with(trim($line), $env_var_name)) {
                $content .= $line;
            }
        }

        file_put_contents($env_path, $content);

    }

    public function envVarExists($env_var_name): bool
    {
        $env_path = $this->getEnvPath();
        $lines = file($env_path);

        foreach ($lines as $line) {
            if (str_starts_with(trim($line), $env_var_name)) {
                return true;
            }
        }

        return false;
    }
}
