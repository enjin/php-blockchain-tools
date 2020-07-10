<?php

namespace Enjin\BlockchainTools\Generators;

use Enjin\BlockchainTools\Generators\Concerns\HelpsGenerateFiles;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexUInt\BaseHexUInt;
use Nette\PhpGenerator\ClassType;
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
            $targetClassName = 'HexUInt' . $targetSize;

            if ($targetSize === $size) {
                $class->addMethod('toHexUInt' . $targetSize)
                    ->setReturnType(Type::STRING)
                    ->addBody('return $this->value;');
            } elseif ($targetSize < $size) {
                $class->addMethod('toHexUInt' . $targetSize . 'Top')
                    ->setReturnType(Type::STRING)
                    ->addBody('return $this->convertDownToTop($this->value, ' . $targetClassName . '::HEX_LENGTH);');

                $class->addMethod('toHexUInt' . $targetSize . 'Bottom')
                    ->setReturnType(Type::STRING)
                    ->addBody('return $this->convertDownToBottom($this->value, ' . $targetClassName . '::HEX_LENGTH);');
            } elseif ($size < $targetSize) {
                $class->addMethod('toHexUInt' . $targetSize)
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

    public function makeHexUIntConverterClass(array $sizes)
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
                ->setType(Type::STRING);
        }

        $printer = new PsrPrinter;

        return [
            'className' => $class->getName(),
            'contents' => $printer->printNamespace($namespace),
        ];
    }

    protected function addFromHexBitSizeMethod(ClassType $class)
    {
        $method = $class->addMethod('fromHexUIntBitSize')
            ->setStatic();

        $method->addParameter('bitSize')
            ->setType(Type::INT);

        $method->addParameter('hex')
            ->setType(Type::STRING);

        $method->setBody('
if (!array_key_exists($bitSize, static::BIT_SIZE_TO_CLASS)) {
    throw new InvalidArgumentException(\'Invalid bit size: \' . $bitSize);
}

$class = static::BIT_SIZE_TO_CLASS[$bitSize];

return new $class($hex);
                ');
    }

    protected function addFromNumberBitSizeMethod(ClassType $class)
    {
        $method = $class->addMethod('fromUIntBitSize')
            ->setStatic();

        $method->addParameter('bitSize')
            ->setType(Type::INT);

        $method->addParameter('int')
            ->setType(Type::STRING);

        $method->setBody('
if (!array_key_exists($bitSize, static::BIT_SIZE_TO_CLASS)) {
    throw new InvalidArgumentException(\'Invalid bit size: \' . $bitSize);
}

$class = static::BIT_SIZE_TO_CLASS[$bitSize];

return  $class::fromUInt($int);
                ');
    }
}
