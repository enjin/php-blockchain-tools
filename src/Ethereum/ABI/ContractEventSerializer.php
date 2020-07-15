<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractEvent;

class ContractEventSerializer
{
    public function decodeInput(ContractEvent $function, array $topics, string $data): array
    {
        return $this->decode($function->inputs(), $topics, $data);
    }

    public function decode(array $eventInputs, array $topics, string $data)
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
            $results[$itemName] = $dataType->decodeBaseType($indexedValue);
        }

        $nonIndexedValues = (new ContractFunctionSerializer())->decodeWithoutMethodId($nonIndexedInputs, $data);
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
