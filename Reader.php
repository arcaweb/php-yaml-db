<?php
namespace Arcaweb\PhpYamlDb;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class Reader
{
    private $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @todo return as object ?
     * @param  string $table = filename without .yml
     * @param  integer $id
     * @return array
     */
    public function get($table, $id = null)
    {
        try {
            $yaml = Yaml::parse(file_get_contents($this->path.$table.'.yml'));
            $yamlData = $this->formatArrayByKey($yaml);
        } catch (ParseException $e) {
        }
        return $id !== null && isset($yamlData[$id]) ? $yamlData[$id] : $yamlData;
    }

    /**
     * Format associative array indexed by specified key
     * @param  array  $array
     * @param  string $key
     * @return array
     */
    private function formatArrayByKey(array $array, $key = 'id')
    {
        $formatedArray = [];
        foreach ($array as $entry) {
            if (isset($entry[$key])) {
                $formatedArray[$entry[$key]] = $entry;
            }
        }
        return $formatedArray;
    }
}
