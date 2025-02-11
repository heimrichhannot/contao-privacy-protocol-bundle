<?php

namespace HeimrichHannot\PrivacyProtocolBundle\Protocol;

use Contao\UserModel;

class ProtocolEntry
{
    public string $description = '';
    public ?string $ip = null;
    public ?ProtocolCmsScope $scope = null;
    public ?string $url = null;
    public ?string $packageVersion = null;
    public ?string $codeFile = null;
    public ?int $codeLine = null;
    public ?string $codeFunction = null;
    public ?string $codeStacktrace = null;
    public ?UserModel $author = null;

    public function __construct(
        public array $person,
        public array $target,
        public ProtocolType $type,
        public int $archiveId,
        public ?string $packageName = null,
    ) {
    }
}
