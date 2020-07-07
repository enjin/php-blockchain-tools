<?php

use Enjin\BlockchainTools\HexUInt\BaseHexUInt;
use Nette\PhpGenerator\Type;

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/helpers.php';

$sizes = getIntLengths();

$convertUptToMethods = [];
$namespaceString = 'Enjin\BlockchainTools\HexUInt';

foreach ($sizes as $size) {
    $result = makeHexUIntSizeClass($size, $namespaceString, $sizes);

    $className = $result['className'];
    $contents = $result['contents'];

    $destDir = __DIR__ . '/../src/HexUInt/';
    writePHPFile($destDir, $className, $contents);
}

$result = makeHexUIntConverterClass($sizes, 'Enjin\BlockchainTools');

$className = $result['className'];
$contents = $result['contents'];

$destDir = __DIR__ . '/../src/';
writePHPFile($destDir, $className, $contents);

function makeHexUIntConverterClass(array $sizes, string $namespaceString)
{
    $namespace = new Nette\PhpGenerator\PhpNamespace($namespaceString);

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

    return [
        'className' => $class->getName(),
        'contents' => (string) $namespace,
    ];
}

function makeHexUIntSizeClass(int $size, string $namespaceString, array $sizes)
{
    $namespace = new Nette\PhpGenerator\PhpNamespace($namespaceString);

    $className = 'HexUInt' . $size;
    $class = $namespace->addClass($className);

    $class->setExtends(BaseHexUInt::class);

    $length = $size / 4;
    $class->addConstant('LENGTH', $length)->setPublic();

    $hexMin = str_repeat('0', $length);
    $hexMax = str_repeat('f', $length);

    $class->addConstant('HEX_MIN', $hexMin)->setPublic();
    $class->addConstant('HEX_MAX', $hexMax)->setPublic();

    $intMax = \Enjin\BlockchainTools\HexConverter::hexToUInt($hexMax);
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
                ->addBody('return $this->convertDownToBottom($this->value,' . $targetClassName . '::LENGTH);');
        } elseif ($size < $targetSize) {
            $class->addMethod('toUInt' . $targetSize)
                ->setReturnType(Type::STRING)
                ->addBody('return $this->convertUpTo($this->value, ' . $targetClassName . '::LENGTH);');
        }
    }

    return [
        'className' => $class->getName(),
        'contents' => (string) $namespace,
    ];
}
