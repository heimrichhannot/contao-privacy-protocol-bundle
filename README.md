# Contao Privacy Protocol Bundle

This bundle add a privacy logging entity to contao as required by the European Union's "General Data Protection Regulation" (
GDPR, in German: "Datenschutz-Grundverordnung", DSGVO).

> [!NOTE]
> **Legal disclaimer**
> 
> Use this bundle at your own risk. Although we as the developer try our best to design this bundle to fulfill the legal
> requirements we __CAN'T GUARANTEE__ anything in terms completeness and correctness. Also we don't offer any legal
> consulting. We strongly encourage you to consult a lawyer if you have any questions or concerns.

## Usage

1. Install with composer or contao manager: `composer require heimrichhannot/contao-privacy-protocol-bundle`
2. Update database
3. Find a new menu entry "Protocol" within the section "Privacy" in the contao backend menu
4. Create a new protocol archive and configure it

## Add logs from your code

```php
use HeimrichHannot\PrivacyProtocolBundle\Protocol\PrivacyProtocolLogger;
use HeimrichHannot\PrivacyProtocolBundle\Protocol\ProtocolEntry;
use HeimrichHannot\PrivacyProtocolBundle\Protocol\ProtocolType;

class ExampleController
{
    public function __construct(
        private readonly PrivacyProtocolLogger $logger,
    ) {}
    
    public function __invoke()
    {
        // create a new protocol entry
        $entry = new ProtocolEntry(
            person: ['email' => 'someone@example.org',],
            target: ['dataContainer' => 'tl_mailing_list', 'id' => 43,],
            type: ProtocolType::FIRST_OPT_IN,
            archiveId: 2,
            packageName: 'vendor/example-bundle',
        );
        
        // add an optional description
        $entry->description = 'someone@example.org has subscribed to the mailing list with ID 43.';
        
        $this->logger->log($entry);
        
    }
}
```

Explanation:
- The ProtocolEntry parameters:
  - `person (array)`: An array containing the personal data of the person that is affected by the action, e.g. an email address, a name, etc.
  - `target (array)`: An array containing information about the target (e.g. a mailing list, subscription list, ...) of the action, e.g. the data container, the id, etc.
  - `type (ProtocolType)`: The type of the protocol entry, e.g. first opt-in, opt-in, opt-out, etc.
  - `archiveId (int)`: The protocol archive id
  - `packageName (string)`: The package name of the bundle that triggers the protocol entry