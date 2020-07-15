# Blockchain Tools

## Hex Data

### HexConverter

See: [`Enjin\BlockchainTools\HexConverter`](src/HexConverter.php)

Contains static utility functions for handling decimal and hex data.

#### Conversion Method Reference

Method names indicate different types of values.

| Method  | From | To | Note |
| ----- | ---- | ---- | ---- |
| `hexToInt` | signed int (base 16) | signed int (base 10) |
| `intToHex` | signed int (base 10) | signed int (base 16) |
| `intToHexPrefixed` | - | - | returns hex prefixed with `0x`
| `hexToUInt` | unsigned int (base 16) | unsigned int (base 10) |
| `uIntToHex` | unsigned int (base 10) | unsigned int (base 16) |
| `uIntToHexPrefixed` | - | - | returns hex prefixed with `0x`
| `hexToString` | hex encoded string (base 16) | decoded string
| `stringToHex` | decoded string | hex encoded string (base 16) |
| `stringToHexPrefixed` | - | - | returns hex prefixed with `0x`
| `hexToBytes` | hex encoded bytes (base 16) | array of bytes
| `bytesToHex` | array of bytes | hex encoded bytes (base 16) |
| `bytesToHexPrefixed` | - | - | returns hex prefixed with `0x`### BigHex

See: [`Enjin\BlockchainTools\BigHex`](src/BigHex.php)

Object for handling large hex numbers.

```php

$longHex = '0xabc1234...';

$hex = new BigHex($longHex);

$hex->toStringPrefixed(); // '0xabc1234...'
$hex->toStringUnPrefixed(); // 'abc1234...'

// convert to phpseclib\Math\BigInteger
$bigInt = $hex->toBigInt();

```


## ABI Contracts


### Contract Data Types not supported
 - string[]
 - bytes[]
 - multi-dimensional arrays (uint16[][])
 - tuple
 - fixed
 - ufixed
 
#### Types used by CryptoItems.abi
 - address
 - address[]
 - bool
 - bytes
 - bytes32
 - bytes4
 - bytes4[]
 - string
 - uint128
 - uint128[]
 - uint16
 - uint256
 - uint256[3]
 - uint256[4]
 - uint256[]
 - uint32
 - uint8

#### Types used by ENJ.abi
 - address
 - bool
 - string
 - uint256
 - uint8

### ContractStore

Used to lazy load and re-use parsed abi json data. Create and re-use an instance of this class in your application to lazy load and cache processed abi files. 

See: [`Enjin\BlockchainTools\Ethereum\ABI\ContractStore`](src/Ethereum/ABI/ContractStore.php)

```php

use Enjin\BlockchainTools\Ethereum\ABI\ContractStore;

$store = new ContractStore();

$store->registerContract([
    'name' => 'my-contract',
    'address' => '0xabc...',
    'jsonFile' => '/path/to/abi/json/file'
]);

$contract = $store->contract('my-contract');

$contract = $store->contractByAddress('0xabc...');

```


### Contract

Interface to interact with an ABI contract.

See: [`Enjin\BlockchainTools\Ethereum\ABI\Contract`](src/Ethereum/ABI/Contract.php)

```php

$contract = $contractStore->contract('contract-name');

$name = $contract->name();
$address = $contract->address();

/* Functions */

$arrayOfFunctions = $contract->functions();
$function = $contract->function('function-name');

// first 8 characters of encoded input/output
$methodId = '...';
$function = $contract->findFunctionByMethodId($methodId);

$encodedInput = '...';
// looks up method from first 8 characters of encoded string and decodes
$decoded = $contract->decodeFunctionInput($encodedInput);
$decoded = $contract->decodeFunctionOutput($encodedInput);


/* Events */

$arrayOfEvents = $contract->events();
$event = $contract->event('event-name');

// topic[0] event signature
$signatureTopic = '...';
$event = $contract->findEventBySignatureTopic($signatureTopic);

$topics = [];
$data = '...';
// lookup event by topic[0] and decode input
$decoded = $contract->decodeEventInput($topics, $data);

```

## ContractFunction

Represents an ABI contract function.

See: [`Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunction`](src/Ethereum/ABI/Contract/ContractFunction.php)


```php
$contract = $contractStore->contract('contract-name');

$function = $contract->function('function-name');

$name = $function->name();
$constant = $function->constant();
$payable = $function->payable();
$stateMutability = $function->stateMutability();

// signature example: myFunction(uint16,string)
$signature = $function->signature();

// first 4 bytes of Keccak hashed signature
$methodId = $function->methodId();

$arrayOfInputs = $function->inputs();
$arrayOfOutputs = $function->outputs();


$data = [
    'foo' => 'bar',
    'key' => 'value',
];

$dataBlock = $function->encodeInput($data);
// or
$dataBlock = $function->encodeOutput($data);

// methodId from function
$dataBlock->methodId();

// convert to encoded string
$dataBlock->toString();

// convert to array of 64 character chunks (excluding methodId)
$dataBlock->toArray();

// convert to array of 64 character chunks with metadata about each chunk (helps with debugging)
$dataBlock->toArrayWithMeta();


// data string with or without methodId at the start
$dataString = '...';
// returns key value pairs as array
$decoded = $function->decodeInput($dataString);
$decoded = $function->decodeOutput($dataString);

```

## ContractEvent

Represents an ABI contract event.

See: [`Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractEvent`](src/Ethereum/ABI/Contract/ContractEvent.php)

```php

$contract = $contractStore->contract('contract-name');

$event = $contract->event('event-name');

$name = $event->name();
$anonymous = $event->anonymous();

// signature example: myFunction(uint16,string)
$signature = $event->signature();

// Keccak hashed signature found in topic[0] of encoded event input
$methodId = $event->signatureTopic();

$arrayOfInputs = $event->inputs();
$input = $event->input('input-name');

$topics = ['...'];
$data = '...';

// convert event to array of key-value pairs
$decoded = $event->decodeInput($topics, $data);

```
