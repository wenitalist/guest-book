<?php

namespace App;

use Exception;

class Migrations {

    private $connect;

    public function __construct()
    {
        $database = Connect::getInstance();
        $this->connect = $database->getConnection();
    }

    public function make(string $name): string {
        try {
            $now = new \DateTime('now');
            $timestamp = $now->getTimestamp();
    
            $path = __DIR__ . "/../migrations/";
            $filename = "{$timestamp}-{$name}.php";
            $className = str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    
            $file = fopen($path . $filename, 'w');
    
            if ($file !== false) {
                $createClass = "<?php\n\nclass {$className} {\n\tpublic function getQuery(): string {\n\t\treturn \"\"; // Запрос\n\t}\n}\n";
                fwrite($file, $createClass);
    
                $this->connect->exec("INSERT INTO migrations_accounting (name, status) VALUES ('{$timestamp}-{$name}', 'not applied')");
    
                fclose($file);
                return $filename;
            }
        } catch (Exception $e) {
            echo $e . "\n";
        }
    }

    public function apply(): void {
        try {
            $path = __DIR__ . '/../migrations/';
            $migrations = scandir($path);
            
            foreach ($migrations as $filename) {
                if ($filename === '.' || $filename === '..') {
                    continue;
                }
    
                $temp = str_replace('.php', '', $filename);
                $response = $this->connect->query("SELECT * FROM migrations_accounting WHERE name = '{$temp}'")->fetch(\PDO::FETCH_ASSOC);
    
                if (!$response) {
                    $this->connect->exec("INSERT INTO migrations_accounting (name, status) VALUES ('{$temp}', 'not applied')");
    
                    require_once("{$path}{$filename}");
                    $this->migrationApply($filename);
    
                } else if ($response && $response['status'] === 'not applied') {
                   
                    require_once("{$path}{$filename}");
                    $this->migrationApply($filename);
                }
            }
        } catch (Exception $e) {
            echo $e . "\n";
        }
    }

    public function migrationApply(string $filename): void {
        try {
            $className = $this->createClassName($filename);
            $temp = str_replace('.php', '', $filename);
        
            $class = new $className;
            $query = $class->getQuery();
    
            $this->connect->query($query);
            $this->connect->query("UPDATE migrations_accounting SET status = 'applied' WHERE name = '{$temp}'");
            echo "Миграция применена: {$temp}\n";
        } catch (Exception $e) {
            echo "Ошибка при применении: {$temp}\n";
        }
    }

    public function createClassName(string $filename): string {
        $className = "";

        $temp = str_replace('.php', '', $filename);
        $temp = explode('-', $temp);
        for ($i = 0; $i < count($temp); $i++) {
            if ($i !== 0) {
                $className .= "{$temp[$i]} ";
            }
        }
        $className = trim(ucwords($className));
        $className = str_replace(' ', '', $className);

        return $className;
    }
}