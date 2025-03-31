<?php

namespace Enjin\BlockchainTools\Support\Generators;

use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexUInt\BaseHexUInt;
use Enjin\BlockchainTools\Support\Generators\Concerns\HelpsGenerateFiles;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;
use Nette\PhpGenerator\Type;

class UIntGenerator
{
    use HelpsGenerateFiles;

    protected const string NAMESPACE = 'Enjin\BlockchainTools\HexNumber';
    protected const string DIR = __DIR__ . '/../../../src/HexNumber';

    public function generate(): void
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

    public function makeHexUIntSizeClass(int $size, array $sizes): array
    {
        $namespaceString = static::NAMESPACE . '\HexUInt';
        $namespace = new PhpNamespace($namespaceString);

        $className = 'HexUInt' . $size;
        $class = $namespace->addClass($className);

        $class->setExtends(BaseHexUInt::class);

        $class->addConstant('BIT_SIZE', $size)->setPublic();

        $length = $size / 4;
        $class->addConstant('HEX_LENGTH', $length)->setPublic();

        $hexMin = str_repeat('0', $length);
        $hexMax = str_repeat('f', $length);

        $class->addConstant('HEX_MIN', $hexMin)->setPublic();
        $class->addConstant('HEX_MAX', $hexMax)->setPublic();

        $intMax = HexConverter::hexToUInt($hexMax);
        $class->addConstant('INT_MIN', '0')->setPublic();
        $class->addConstant('INT_MAX', $intMax)->setPublic();

        foreach ($sizes as $targetSize) {
            if ($targetSize === $size) {
                $class->addMethod('toHexUInt' . $targetSize)
                    ->setReturnType(Type::String)
                    ->addBody('return $this->value;');
            } elseif ($targetSize < $size) {
                $class->addMethod('toHexUInt' . $targetSize . 'Top')
                    ->setReturnType(Type::String)
                    ->addBody('return $this->convertDownToTop(' . $targetSize . ');');

                $class->addMethod('toHexUInt' . $targetSize . 'Bottom')
                    ->setReturnType(Type::String)
                    ->addBody('return $this->convertDownToBottom(' . $targetSize . ');');
            } elseif ($size < $targetSize) {
                $class->addMethod('toHexUInt' . $targetSize)
                    ->setReturnType(Type::String)
                    ->addBody('return $this->convertUpTo(' . $targetSize . ');');
            }
        }
        $printer = new PsrPrinter;

        return [
            'className' => $class->getName(),
            'contents' => $printer->printNamespace($namespace),
        ];
    }

    public function makeHexUIntConverterClass(array $sizes): array
    {
        $namespace = new PhpNamespace(static::NAMESPACE);

        $class = $namespace->addClass('HexUInt');
        $namespace->addUse('InvalidArgumentException');

        $targetClasses = [];
        $bitSizeToClass = [];

        foreach ($sizes as $size) {
            $targetClassName = 'HexUInt' . $size;
            $targetClass = static::NAMESPACE . '\\HexUInt\\' . $targetClassName;

            $targetClasses[] = [
                'size' => $size,
                'targetClassName' => $targetClassName,
                'targetClass' => $targetClass,
            ];
            $bitSizeToClass[$size] = $targetClass;
            $namespace->addUse($targetClass);
        }

        $class->addConstant('BIT_SIZE_TO_CLASS', $bitSizeToClass);

        $this->addFromHexBitSizeMethod($class);

        $this->addFromNumberBitSizeMethod($class);

        foreach ($targetClasses as $item) {
            $targetClassName = $item['targetClassName'];
            $targetClass = $item['targetClass'];
            $size = $item['size'];

            $paramName = 'uInt' . $size;
            $method = $class->addMethod('fromHexUInt' . $size)
                ->setStatic()
                ->setBody('return new ' . $targetClassName . '($' . $paramName . ');')
                ->setReturnType($targetClass);

            $method->addParameter($paramName)
                ->setType(Type::String);
        }

        $printer = new PsrPrinter;

        return [
            'className' => $class->getName(),
            'contents' => $printer->printNamespace($namespace),
        ];
    }

    protected function addFromHexBitSizeMethod(ClassType $class): void
    {
        $method = $class->addMethod('fromHexUIntBitSize')
            ->setStatic();

        $method->addParameter('bitSize')
            ->setType(Type::Int);

        $method->addParameter('hex')
            ->setType(Type::String);

        $method->setBody('
if (!array_key_exists($bitSize, static::BIT_SIZE_TO_CLASS)) {
    throw new InvalidArgumentException(\'Invalid bit size: \' . $bitSize);
}

$class = static::BIT_SIZE_TO_CLASS[$bitSize];

return new $class($hex);
                ');
    }

    protected function addFromNumberBitSizeMethod(ClassType $class): void
    {
        $method = $class->addMethod('fromUIntBitSize')
            ->setStatic();

        $method->addParameter('bitSize')
            ->setType(Type::Int);

        $method->addParameter('int')
            ->setType(Type::String);

        $method->setBody('
if (!array_key_exists($bitSize, static::BIT_SIZE_TO_CLASS)) {
    throw new InvalidArgumentException(\'Invalid bit size: \' . $bitSize);
}

$class = static::BIT_SIZE_TO_CLASS[$bitSize];

return  $class::fromUInt($int);
                ');
    }
}
