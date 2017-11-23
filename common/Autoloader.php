<?php


class Autoloader
{
    protected $namespacesMap = array();

    public function addNamespace($namespace, $rootDir): bool
    {
        if (is_dir($rootDir)) {
            $this->namespacesMap[$namespace] = $rootDir;
            return true;
        }
        return false;
    }

    public function register(): bool
    {
        return spl_autoload_register(array($this, 'autoload'));
    }

    /**
     * @param $class
     * @return bool
     */
    protected function autoload($class): bool
    {
        if (!empty($this->namespacesMap)) {
            foreach ($this->namespacesMap as $item => $value) {
                $filePath = $this->namespacesMap[$item] . '/' . $class . '.php';
                if (is_file($filePath)) {
                    require_once $filePath;
                }
            }
            return true;
        }
        return false;
    }

}
