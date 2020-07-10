<?php

namespace Enjin\BlockchainTools\Generators;

use Enjin\BlockchainTools\Generators\Concerns\HelpsGenerateFiles;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;
use Nette\PhpGenerator\Type;

class IntGenerator
{
    use HelpsGenerateFiles;

    protected const NAMESPACE = 'Enjin\BlockchainTools\HexNumber';
    protected const DIR = __DIR__ . '/../../src/HexNumber';

    public function generate()
    {
        $sizes = $this->getIntLengths();

        foreach ($sizes as $size) {
            $result = $this->makeHexIntSizeClass($size, $sizes);

            $className = $result['className'];
            $contents = $result['contents'];

            $destDir = static::DIR . '/HexInt/';
            $this->writePHPFile($destDir, $className, $contents);
        }

        $result = $this->makeHexIntConverterClass($sizes);

        $className = $result['className'];
        $contents = $result['contents'];

        $destDir = static::DIR . '/';
        $this->writePHPFile($destDir, $className, $contents);
    }

    public function makeHexIntSizeClass(int $size, array $sizes)
    {
        $namespaceString = static::NAMESPACE . '\HexInt';
        $namespace = new PhpNamespace($namespaceString);

        $className = 'HexInt' . $size;
        $class = $namespace->addClass($className);

        $class->setExtends(HexInt::class);

        $length = $size / 4;
        $class->addConstant('HEX_LENGTH', $length)->setPublic();

        $a = bcpow(2, $size);
        $b = bcdiv($a, 2);
        $intMin = bcmul($b, -1);
        $intMax = bcsub($b, 1);

        $hexMin = HexConverter::intToHexInt($intMin, $length);
        $hexMax = HexConverter::intToHexInt($intMax, $length);

        $class->addConstant('HEX_MIN', $hexMin)->setPublic();
        $class->addConstant('HEX_MAX', $hexMax)->setPublic();

        $class->addConstant('INT_MIN', $intMin)->setPublic();
        $class->addConstant('INT_MAX', $intMax)->setPublic();

        $intSize = bcsub($intMax, $intMin);
        $class->addConstant('INT_SIZE', $intSize)->setPublic();

        foreach ($sizes as $targetSize) {
            $targetClassName = 'HexInt' . $targetSize;

            if ($targetSize < $size) {
            } elseif ($size < $targetSize) {
                $class->addMethod('toHexInt' . $targetSize)
                    ->setReturnType(Type::STRING)
                    ->addBody('return $this->convertUpTo($this->value, ' . $targetClassName . '::HEX_LENGTH);');
            }
        }
        $printer = new PsrPrinter;

        return [
            'className' => $class->getName(),
            'contents' => $printer->printNamespace($namespace),
        ];
    }

    public function makeHexIntConverterClass(array $sizes)
    {
        $namespace = new PhpNamespace(static::NAMESPACE);

        $class = $namespace->addClass('HexInt');

        $namespace->addUse('InvalidArgumentException');
        $targetClasses = [];
        $bitSizeToClass = [];

        foreach ($sizes as $size) {
            $targetClassName = 'HexInt' . $size;
            $targetClass = static::NAMESPACE . '\\HexInt\\' . $targetClassName;

            $targetClasses[] = [
                'size' => $size,
                'targetClassName' => $targetClassName,
                'targetClass' => $targetClass,
            ];
            $bitSizeToClass[$size] = $targetClass;
            $namespace->addUse($targetClass);
        }

        $class->addConstant('BIT_SIZE_TO_CLASS', $bitSizeToClass);
        $method = $class->addMethod('fromHexIntBitSize')
            ->setStatic()
            ->setBody('
if (!array_key_exists($bitSize, static::BIT_SIZE_TO_CLASS)) {
    throw new InvalidArgumentException(\'Invalid bit size: \' . $bitSize);
}

$class = static::BIT_SIZE_TO_CLASS[$bitSize];

return new $class($hex);
                ');

        $method->addParameter('bitSize')
            ->setType(Type::INT);

        $method->addParameter('hex')
            ->setType(Type::STRING);

        foreach ($targetClasses as $item) {
            $targetClassName = $item['targetClassName'];
            $targetClass = $item['targetClass'];
            $size = $item['size'];

            $paramName = 'Int' . $size;
            $method = $class->addMethod('fromHexInt' . $size)
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
