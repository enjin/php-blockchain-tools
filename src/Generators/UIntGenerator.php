<?php

namespace Enjin\BlockchainTools\Generators;

use Enjin\BlockchainTools\Generators\Concerns\HelpsGenerateFiles;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexUInt\BaseHexUInt;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;
use Nette\PhpGenerator\Type;

class UIntGenerator
{
    use HelpsGenerateFiles;

    protected const NAMESPACE = 'Enjin\BlockchainTools\HexNumber';
    protected const DIR = __DIR__ . '/../../src/HexNumber';

    public function generate()
    {
        $sizes = $this->getIntLengths();

        foreach ($sizes as $size) {
            $result = $this->makeHexUIntSizeClass($size, $sizes);

            $className = $result['className'];
            $contents = $result['contents'];

            $destDir = static::DIR . '/HexUInt/';
            $this->writePHPFile($destDir, $className, $contents);
        }

        $result = $this->makeHexUIntConverterClass($sizes);

        $className = $result['className'];
        $contents = $result['contents'];

        $destDir = static::DIR . '/';
        $this->writePHPFile($destDir, $className, $contents);
    }

    public function makeHexUIntSizeClass(int $size, array $sizes)
    {
        $namespaceString = static::NAMESPACE . '\HexUInt';
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
                $class->addMethod('toHexUInt' . $targetSize . 'Top')
                    ->setReturnType(Type::STRING)
                    ->addBody('return $this->convertDownToTop($this->value, ' . $targetClassName . '::LENGTH);');

                $class->addMethod('toHexUInt' . $targetSize . 'Bottom')
                    ->setReturnType(Type::STRING)
                    ->addBody('return $this->convertDownToBottom($this->value, ' . $targetClassName . '::LENGTH);');
            } elseif ($size < $targetSize) {
                $class->addMethod('toHexUInt' . $targetSize)
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

    public function makeHexUIntConverterClass(array $sizes)
    {
        $namespace = new PhpNamespace(static::NAMESPACE);

        $class = $namespace->addClass('HexUInt');

        foreach ($sizes as $size) {
            $targetClassName = 'HexUInt' . $size;
            $targetClass = static::NAMESPACE . '\\HexUInt\\' . $targetClassName;

            $namespace->addUse($targetClass);

            $paramName = 'uInt' . $size;
            $method = $class->addMethod('fromHexUInt' . $size)
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
