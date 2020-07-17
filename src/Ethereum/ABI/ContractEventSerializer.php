<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractEvent;

class ContractEventSerializer
{
    public function decodeInput(ContractEvent $function, array $topics, string $data): array
    {
        return $this->decode(
            $function->inputs(),
            $topics,
            $data
        );
    }

    public function decodeInputRaw(ContractEvent $function, array $topics, string $data): array
    {
        return $this->decodeRaw(
            $function->inputs(),
            $topics,
            $data
        );
    }

    public function decode(array $eventInputs, array $topics, string $data)
    {
        return $this->decodeData(
            $eventInputs,
            $topics,
            $data,
            true
        );
    }

    public function decodeRaw(array $eventInputs, array $topics, string $data)
    {
        return $this->decodeData(
            $eventInputs,
            $topics,
            $data,
            false
        );
    }

    protected function decodeData(array $eventInputs, array $topics, string $data, bool $decodeValues)
    {
        $results = [];

        $separated = $this->separateInputs($eventInputs);

        $indexedInputs = $separated['indexed'];
        $nonIndexedInputs = $separated['nonIndexed'];

        // Removing topic[0]. Topic[n-1] are indexed values.
        $indexedValues = array_slice($topics, 1);

        foreach ($indexedInputs as $i => $item) {
            $itemName = $item->name() ?: $i;
            $dataType = $item->dataType();
            $isArray = $dataType->isArray();
            $baseType = $dataType->baseType();

            $dynamicLengthTypes = ['bytes', 'string'];
            if ($isArray || in_array($baseType, $dynamicLengthTypes)) {
                $results[$itemName] = 'cannot decode topics with type: ' . $item->type();

                continue;
            }

            $indexedValue = $indexedValues[$i];

            $value = $indexedValue;
            if ($decodeValues) {
                $value = $dataType->decodeBaseType($indexedValue);
            }
            $results[$itemName] = $value;
        }

        $functionSerializer = new ContractFunctionSerializer();

        if ($decodeValues) {
            $nonIndexedValues = $functionSerializer->decodeWithoutMethodId($nonIndexedInputs, $data);
        } else {
            $nonIndexedValues = $functionSerializer->decodeRawWithoutMethodId($nonIndexedInputs, $data);
        }

        $results = array_merge($results, $nonIndexedValues);

        // reorder to match spec
        $output = [];
        foreach ($eventInputs as $input) {
            $name = $input->name();
            $output[$name] = $results[$name];
        }
        return $output;
    }

    protected function separateInputs(array $eventInputs): array
    {
        $indexed = [];
        $nonIndexed = [];

        foreach ($eventInputs as $input) {
            if ($input->indexed()) {
                $indexed[] = $input;
            } else {
                $nonIndexed[] = $input;
            }
        }

        return [
            'indexed' => $indexed,
            'nonIndexed' => $nonIndexed,
        ];
    }
}
