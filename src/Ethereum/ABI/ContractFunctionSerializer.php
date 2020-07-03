<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunction;
use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunctionInput;
use Enjin\BlockchainTools\Ethereum\ABI\DataTypes\EthAddress;
use Enjin\BlockchainTools\Ethereum\ABI\DataTypes\EthBoolean;
use Enjin\BlockchainTools\Ethereum\ABI\DataTypes\EthBytes32;
use Enjin\BlockchainTools\HexConverter;

class ContractFunctionSerializer
{
    public function encode(ContractFunction $function, array $data): string
    {
        // Set the dynamic data start position.
        // $inputCount = count($function->inputs());

        // $dynamicDataPosition = $inputCount * 32;

        // /** @var ContractFunctionInput $input */
        // foreach ($function->inputs() as $input) {
        //     // @TODO wtf is happening here?
        //     if (preg_match('/uint(8|16|32|64|128|256)\[[0-9]+\]/', $input->type())) {
        //         $uint256Array = $data[$input->name()] ?? null;
        //         $dynamicDataPosition += (count($uint256Array) - 1) * 32;
        //     }
        // }

        $dataBlock = '';

        // Create an array to hold the dynamic properties.
        // $dynamicDataValues = [];

        // Read the data and create the encoded types.

        foreach ($function->inputs() as $i => $input) {
            /** @var ContractFunctionInput $input */
            $inputName = $input->name() ?: $i;
            $value = $data[$inputName] ?? null;

            $dataType = $input->dataType();
            $baseType = $dataType->baseType();
            $isArray = $dataType->isArray();

            if ($isArray) {
                if ($dataType->arrayLength() !== 'dynamic') {
                    foreach ($value as $arrayItem) {
                        $dataBlock .= HexConverter::uIntToHexPrefixed($arrayItem);
                    }
                }
            } else {
                if ($baseType === 'uint') {
                    if ($dataType->aliasedFrom() === 'bool') {
                        $value = (int) $value;
                    }
                    $length = $dataType->length() * 0.25;
                    $dataBlock .= HexConverter::uIntToHexPrefixed($value, $length);
                }
            }

            switch ($input->type()) {
                case 'bool':
                    $dataBlock .= EthBoolean::encode($value);

                    break;
                case 'address':
                    $dataBlock .= EthAddress::encode($value);

                    break;
                case 'bytes32':
                    $dataBlock .= EthBytes32::encode($value);

                    break;
                // case 'bytes':
                // case 'string':
                //     $param = EthString::encode($value);
                //     $dataPosition = EthUint256::encode($dynamicDataPosition);
                //     $dynamicDataValues[] = (object) ['startPosition' => $dataPosition, 'data' => $param];
                //     $dataBlock .= $dataPosition;
                //     $dynamicDataPosition += strlen($param) - 64;
                //
                //     break;
                // case preg_match('/uint(8|128|256)\[[0-9]+\]/', $input->type()) ? true : false:
                //     $uint256Array = $value;
                //     foreach ($uint256Array as $uint256) {
                //         $param = new EthUint256($uint256);
                //         $dataBlock .= $param->encodedValue(false);
                //     }
                //
                //     break;
                // case 'uint8[]':
                // case 'uint16[]':
                // case 'uint32[]':
                // case 'uint128[]':
                // case 'uint256[]':
                //     $param = new EthUint256Array($value);
                //     $dataPosition = (new EthUint256($dynamicDataPosition))->encodedValue(false);
                //     $dynamicDataValues[] = (object) ['startPosition' => $dataPosition, 'data' => $param];
                //     $dataBlock .= $dataPosition;
                //     $dynamicDataPosition += ($param->length() * 32) + 32;
                //
                //     break;
                // case 'address[]':
                //     $param = new EthAddressArray($value);
                //     $dataPosition = (new EthUint256($dynamicDataPosition))->encodedValue(false);
                //     $dynamicDataValues[] = (object) ['startPosition' => $dataPosition, 'data' => $param];
                //     $dataBlock .= $dataPosition;
                //     $dynamicDataPosition += ($param->length() * 32) + 32;
                //
                //     break;
            }
        }
        //
        // foreach ($dynamicDataValues as $dataValue) {
        //     $dataBlock .= $dataValue->data->encodedValue(false);
        // }

        return $dataBlock;
    }

    public function decode(ContractFunction $function, string $data): array
    {
        $output = [];
        foreach ($function->inputs() as $i => $input) {
            /** @var ContractFunctionInput $input */
            $inputName = $input->name() ?: $i;
            $value = $data[$inputName] ?? null;

            $dataType = $input->dataType();
            $baseType = $dataType->baseType();
            $isArray = $dataType->isArray();

            if ($isArray) {
            } else {
                if ($baseType === 'uint') {
                    if ($dataType->aliasedFrom() === 'bool') {
                        $value = (bool) $value;
                    }

                    $output[$inputName] = HexConverter::hexToUInt($value);
                }
            }
        }

        return $inputs;
    }
}
