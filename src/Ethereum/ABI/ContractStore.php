<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Exceptions\ContractFileException;
use Enjin\BlockchainTools\HexConverter;
use InvalidArgumentException;

class ContractStore
{
    private $contractMeta = [];

    private $contracts = [];

    public function registerContracts(array $contractMeta = [])
    {
        foreach ($contractMeta as $meta) {
            $this->registerContract($meta['name'], $meta['address'], $meta['jsonFile']);
        }
    }

    public function registerContract(string $name, string $address, string $jsonFile)
    {
        $contractMeta = [
            'name' => $name,
            'address' => $this->normalizeAddress($address),
            'jsonFile' => $jsonFile,
        ];
        $this->contractMeta[$name] = $contractMeta;
    }

    public function contract(string $name): Contract
    {
        if (!isset($this->contracts[$name])) {
            $this->contracts[$name] = $this->makeContract($name);
        }

        return $this->contracts[$name];
    }

    public function contractByAddress(string $address): Contract
    {
        $name = $this->addressToName($address);

        if ($name === null) {
            throw new InvalidArgumentException('contract with address not found: ' . $address);
        }

        return $this->contract($name);
    }

    public function decodeEvent(string $address, array $topics, string $data): array
    {
        $contract = $this->contractByAddress($address);

        $event = $contract->findEventBySignatureTopic($topics[0]);

        return $event->decodeInput($topics, $data);
    }

    protected function makeContract(string $name): Contract
    {
        if (!isset($this->contractMeta[$name])) {
            throw new InvalidArgumentException('contract name not found: ' . $name);
        }
        $meta = $this->contractMeta[$name];

        $jsonFile = $meta['jsonFile'];
        $address = $meta['address'];

        $contents = file_get_contents($jsonFile);
        $json = json_decode($contents, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ContractFileException('Invalid json found in contract file: ' . $jsonFile);
        }

        return new Contract($name, $address, $json);
    }

    protected function normalizeAddress(string $address): string
    {
        return HexConverter::unPrefix(strtolower($address));
    }

    protected function addressToName(string $address): ?string
    {
        foreach ($this->contractMeta as $item) {
            if ($item['address'] == $this->normalizeAddress($address)) {
                return $item['name'];
            }
        }

        return null;
    }
}
