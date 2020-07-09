<?php

namespace Enjin\BlockchainTools\Generators\Concerns;

trait HelpsGenerateFiles
{
    protected function writePHPFile(string $destDir, string $className, string $namespace)
    {
        $destinationFile = $destDir . $className . '.php';
        $contents = '<?php' . PHP_EOL . PHP_EOL . $namespace;

        $contents = str_replace(PHP_EOL . PHP_EOL . PHP_EOL, PHP_EOL . PHP_EOL, $contents);
        file_put_contents($destinationFile, $contents);
    }

    protected function getIntLengths(): array
    {
        $sizes = [];
        foreach (range(8, 256) as $i) {
            if ($i % 8 == 0) {
                $sizes[] = $i;
            }
        }

        return $sizes;
    }
}
