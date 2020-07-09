<?php

namespace Enjin\BlockchainTools\Generators;

use Enjin\BlockchainTools\Generators\Concerns\HelpsGenerateFiles;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexUInt\BaseHexUInt;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;
use Nette\PhpGenerator\Type;

class UIntGenerator
{
    use HelpsGenerateFiles;

    public function generate()
    {
        $sizes = $this->getIntLengths();

        $namespaceString = 'Enjin\BlockchainTools\HexUInt';

        foreach ($sizes as $size) {
            $result = $this->makeHexUIntSizeClass($size, $namespaceString, $sizes);

            $className = $result['className'];
            $contents = $result['contents'];

            $destDir = __DIR__ . '/../../src/HexUInt/';
            $this->writePHPFile($destDir, $className, $contents);
        }

        $result = $this->makeHexUIntConverterClass($sizes, 'Enjin\BlockchainTools');

        $className = $result['className'];
        $contents = $result['contents'];

        $destDir = __DIR__ . '/../../src/';
        $this->writePHPFile($destDir, $className, $contents);
    }

    public function makeHexUIntSizeClass(
        int $size,
        string $namespaceString,
        array $sizes
    ) {
        $namespace = new PhpNamespace($namespaceString);

        $className = 'HexUInt' . $size;
        $class = $namespace->addClass($className);

        $class->setExtends(BaseHexUInt::class);

        $length = $size / 4;
        $class->addConstant('LENGTH', $length)->setPublic();

        $hexMin = str_repeat('0', $length);
        $hexMax = str_repeat('f', $length);

        $class->addConstant('HEX_MIN', $hexMin)->setPublic();
        $class->addConstant('HEX_MAX', $hexMax)->setPublic();

        $intMax = HexConverter::hexToUInt($hexMax);
        $class->addConstant('INT_MIN', '0')->setPublic();
        $class->addConstant('INT_MAX', $intMax)->setPublic();

        foreach ($sizes as $targetSize) {
            $targetClassName = 'HexUInt' . $targetSize;

            if ($targetSize < $size) {
                $class->addMethod('toUInt' . $targetSize . 'Top')
                    ->setReturnType(Type::STRING)
                    ->addBody('return $this->convertDownToTop($this->value, ' . $targetClassName . '::LENGTH);');

                $class->addMethod('toUInt' . $targetSize . 'Bottom')
                    ->setReturnType(Type::STRING)
                    ->addBody('return $this->convertDownToBottom($this->value, ' . $targetClassName . '::LENGTH);');
            } elseif ($size < $targetSize) {
                $class->addMethod('toUInt' . $targetSize)
                    ->setReturnType(Type::STRING)
                    ->addBody('return $this->convertUpTo($this->value, ' . $targetClassName . '::LENGTH);');
            }
        }
        $printer = new PsrPrinter;


        return [
            'className' => $class->getName(),
            'contents' => $printer->printNamespace($namespace),
        ];
    }

    public function makeHexUIntConverterClass(array $sizes, string $namespaceString)
    {
        $namespace = new PhpNamespace($namespaceString);

        $class = $namespace->addClass('HexUInt');

        foreach ($sizes as $size) {
            $targetClassName = 'HexUInt' . $size;
            $targetClass = $namespaceString . '\\HexUInt\\' . $targetClassName;

            $namespace->addUse($targetClass);

            $paramName = 'uInt' . $size;
            $method = $class->addMethod('fromUInt' . $size)
                ->setStatic()
                ->setBody('return new ' . $targetClassName . '($' . $paramName . ');')
                ->setReturnType($targetClass);

            $method->addParameter($paramName)
                ->setType(Type::STRING);
        }

        $printer = new PsrPrinter;

        return [
            'className' => $class->getName(),
            'contents' => $printer->printNamespace($namespace),
        ];
    }
}
