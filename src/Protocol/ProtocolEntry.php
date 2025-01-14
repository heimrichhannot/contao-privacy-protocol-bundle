<?php

namespace HeimrichHannot\PrivacyProtocolBundle\Protocol;

use Contao\MemberModel;
use Contao\UserModel;

class ProtocolEntry
{
    public ProtocolType $type;
    public int $archiveId;
    public array $data;
    public ?string $ip = null;
    public ?string $email = null;
    public ?ProtocolCmsScope $scope = null;
    public ?string $url = null;
    public ?string $packageName = null;
    public ?string $packageVersion = null;
    public ?string $codeFile = null;
    public ?int $codeLine = null;
    public ?string $codeFunction = null;
    public ?string $codeStacktrace = null;
    public ?string $dataContainer = null;
    public UserModel|MemberModel|null $author = null;
}