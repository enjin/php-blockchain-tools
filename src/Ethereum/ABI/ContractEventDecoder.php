<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractEvent;

class ContractEventDecoder
{
    /**
     * @var string
     */
    protected $dataBlockDecoderClass;

    public function __construct(string $dataBlockDecoderClass = DataBlockDecoder::class)
    {
        $this->dataBlockDecoderClass = $dataBlockDecoderClass;
    }

    public function decodeInput(ContractEvent $function, array $topics, string $data): DataBlockDecoder
    {
        return $this->decode(
            $function->inputs(),
            $topics,
            $data
        );
    }

    public function decode(array $eventInputs, array $topics, string $data): DataBlockDecoder
    {
        return $this->decodeData(
            $eventInputs,
            $topics,
            $data
        );
    }

    protected function decodeData(array $eventInputs, array $topics, string $data): DataBlockDecoder
    {
        /** @var DataBlockDecoder $results */
        $results = new $this->dataBlockDecoderClass($eventInputs);

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
                $results->addEventTopic($item, 'cannot decode topics with type: ' . $item->type());

                continue;
            }

            $indexedValue = $indexedValues[$i];

            $results->addEventTopic($item, $indexedValue);
        }

        $functionSerializer = new ContractFunctionDecoder();
        $results = $functionSerializer->decodeWithoutMethodId($nonIndexedInputs, $data, $results);

        return $results;
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
