<?php

namespace EnjinCoin;

use EnjinCoin\Ethereum\DataTypes\EthAddress;
use EnjinCoin\Ethereum\DataTypes\EthAddressArray;
use EnjinCoin\Ethereum\DataTypes\EthBoolean;
use EnjinCoin\Ethereum\DataTypes\EthBytes32;
use EnjinCoin\Ethereum\DataTypes\EthString;
use EnjinCoin\Ethereum\DataTypes\EthUint256;
use EnjinCoin\Ethereum\DataTypes\EthUint256Array;
use EnjinCoin\Ethereum\DataTypes\EthUint32;
use EnjinCoin\Support\Hex;

class Serializer
{
    public function encodeDataBlock($method, array $data) : string
    {
        // Set the dynamic data start position.
        $dynamicDataPosition = (count($method->inputs) * 32);

        for ($i = 0; $i < count($method->inputs); $i++) {
            $abiParam = $method->inputs[$i];

            if (preg_match('/uint(8|128|256)\[[0-9]+\]/', $abiParam->type)) {
                $uint256Array = $data[$abiParam->name] ?? null;
                $dynamicDataPosition += (count($uint256Array) - 1) * 32;
            }
        }

        $dataBlock = '';

        // Create an array to hold the dynamic properties.
        $dynamicDataValues = [];

        // Read the data and create the encoded types.
        for ($i = 0; $i < count($method->inputs); $i++) {
            $abiParam = $method->inputs[$i];
            if (empty($abiParam->name)) {
                $abiParam->name = $i;
            }

            switch ($abiParam->type) {
                case 'bool':
                    $bool = $data[$abiParam->name] ?? null;
                    $param = new EthBoolean($bool);
                    $dataBlock .= str_pad($param->encodedValue(false), 64, '0', STR_PAD_LEFT);

                    break;
                case 'uint8':
                case 'uint16':
                case 'uint32':
                case 'uint128':
                case 'uint256':
                    $param = new EthUint256($data[$abiParam->name] ?? null);
                    $dataBlock .= $param->encodedValue(false);

                    break;
                case 'address':
                    $param = new EthAddress($data[$abiParam->name] ?? null);
                    $dataBlock .= $param->encodedValue(false);

                    break;
                case 'bytes32':
                    $param = new EthBytes32($data[$abiParam->name] ?? null);
                    $dataBlock .= $param->encodedValue(false);

                    break;
                case 'bytes':
                case 'string':
                    $param = new EthString($data[$abiParam->name] ?? null);
                    $dataPosition = (new EthUint256($dynamicDataPosition))->encodedValue(false);
                    $dynamicDataValues[] = (object) ['startPosition' => $dataPosition, 'data' => $param];
                    $dataBlock .= $dataPosition;
                    $dynamicDataPosition += strlen($param->encodedValue(false)) - 64;

                    break;
                case preg_match('/uint(8|128|256)\[[0-9]+\]/', $abiParam->type) ? true : false:
                    $uint256Array = $data[$abiParam->name] ?? null;
                    foreach ($uint256Array as $uint256) {
                        $param = new EthUint256($uint256);
                        $dataBlock .= $param->encodedValue(false);
                    }

                    break;
                case 'uint8[]':
                case 'uint16[]':
                case 'uint32[]':
                case 'uint128[]':
                case 'uint256[]':
                    $param = new EthUint256Array($data[$abiParam->name] ?? null);
                    $dataPosition = (new EthUint256($dynamicDataPosition))->encodedValue(false);
                    $dynamicDataValues[] = (object) ['startPosition' => $dataPosition, 'data' => $param];
                    $dataBlock .= $dataPosition;
                    $dynamicDataPosition += ($param->length() * 32) + 32;

                    break;
                case 'address[]':
                    $param = new EthAddressArray($data[$abiParam->name] ?? null);
                    $dataPosition = (new EthUint256($dynamicDataPosition))->encodedValue(false);
                    $dynamicDataValues[] = (object) ['startPosition' => $dataPosition, 'data' => $param];
                    $dataBlock .= $dataPosition;
                    $dynamicDataPosition += ($param->length() * 32) + 32;

                    break;
            }
        }

        foreach ($dynamicDataValues as $dataValue) {
            $dataBlock .= $dataValue->data->encodedValue(false);
        }

        return $dataBlock;
    }

    public function decodeDataBlock($method, string $data, bool $output = true, bool $includeIndexed = true) : array
    {
        $data = Hex::stripPrefix($data);
        $dataPosition = 0;

        if ($output) {
            $abiParams = $method->outputs;
        } else {
            $abiParams = $method->inputs;
        }

        for ($i = 0; $i < count($abiParams); $i++) {
            $abiParam = $abiParams[$i];
            if ($includeIndexed || (isset($abiParam->indexed) && $abiParam->indexed == false)) {
                $fragment = substr($data, $dataPosition, 64);
                switch ($abiParam->type) {
                    case 'bool':
                        $param = new EthBoolean($fragment, true);
                        $abiParams[$i]->value = $param;

                        break;
                    case 'uint8':
                    case 'uint16':
                    case 'uint32':
                    case 'uint126':
                    case 'uint256':
                        $param = new EthUint256($fragment, true);
                        $abiParams[$i]->value = $param;

                        break;
                    case 'address':
                        $param = new EthAddress($fragment, true);
                        $abiParams[$i]->value = $param;

                        break;
                    case 'bytes32':
                        $param = new EthBytes32($fragment, true);
                        $abiParams[$i]->value = $param;

                        break;
                    case 'bytes':
                    case 'string':
                        $stringPos = new EthUint32($fragment, true);
                        $stringLength = new EthUint32(substr($data, ($stringPos->value() * 2), 64), true);
                        $param = new EthString(substr($data, ($stringPos->value() * 2), (int) (($stringLength->value() * 2) + 64)), true);
                        $abiParams[$i]->value = $param;

                        break;
                    case preg_match('/uint(8|128|256)\[[0-9]+\]/', $abiParam->type) ? true : false:
                        preg_match('/[0-9]+\]/', $abiParam->type, $arrayLength);
                        $arrayLength = trim($arrayLength[0], ']');
                        $abiParams[$i]->value = [];
                        for ($e = 0; $e < $arrayLength; $e++) {
                            $param = new EthUint256($fragment, true);
                            $abiParams[$i]->value[] = $param;
                            $dataPosition += 64;
                            $fragment = substr($data, $dataPosition, 64);
                        }
                        $dataPosition -= 64;

                        break;
                    case 'uint8[]':
                    case 'uint16[]':
                    case 'uint32[]':
                    case 'uint128[]':
                    case 'uint256[]':
                        $arrayPos = new EthUint32($fragment, true);
                        $arrayLength = new EthUint32(substr($data, ($arrayPos->value() * 2), 64), true);
                        $param = new EthUint256Array(substr($data, (int) ($arrayPos->value() * 2), (int) (($arrayLength->value() * 64) + 64)), true);
                        $abiParams[$i]->value = $param;

                        break;
                    case 'address[]':
                        $arrayPos = new EthUint32($fragment, true);
                        $arrayLength = new EthUint32(substr($data, (int) ($arrayPos->value() * 2), 64), true);
                        $param = new EthAddressArray(substr($data, (int) ($arrayPos->value() * 2), (int) (($arrayLength->value() * 64) + 64)), true);
                        $abiParams[$i]->value = $param;

                        break;
                }
                $dataPosition += 64;
            }
        }

        return $abiParams;
    }
}
