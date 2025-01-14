<?php

namespace HeimrichHannot\PrivacyProtocolBundle\Protocol;

use Contao\BackendUser;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\FrontendUser;
use Contao\MemberModel;
use Contao\System;
use Contao\UserModel;
use HeimrichHannot\PrivacyProtocolBundle\Model\PrivacyProtocolArchiveModel;
use HeimrichHannot\PrivacyProtocolBundle\Model\PrivacyProtocolEntryModel;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class PrivacyProtocolLogger
{
    private ?array $stackTrace = null;

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly ScopeMatcher $scopeMatcher,
        private readonly Security $security
    )
    {
    }

    public function log(ProtocolEntry $entry): void
    {
        $archive = PrivacyProtocolArchiveModel::findByPk($entry->archiveId);

        if (!$archive) {
            throw new \InvalidArgumentException('Invalid privacy protocol archive id');
        }

        $protocolEntry = new PrivacyProtocolEntryModel();
        $protocolEntry->tstamp = $protocolEntry->dateAdded = time();
        $protocolEntry->pid = $archive->id;
        $protocolEntry->type = $entry->type->value;

        $this->code($protocolEntry, $entry, $archive);

        $ip = $entry->ip ?? $this->requestStack->getCurrentRequest()?->getClientIp();
        if ($ip) {
            if ($archive->skipIpAnonymization) {
                $protocolEntry->ip = $ip;
            } else {
                $protocolEntry->ip = System::anonymizeIp($ip);
            }
        }

        if ($entry->scope) {
            $protocolEntry->cmsScope = $entry->scope->value;
        } elseif ($this->requestStack->getCurrentRequest()) {
            $protocolEntry->cmsScope = $this->scopeMatcher->isBackendRequest($this->requestStack->getCurrentRequest()) ? ProtocolCmsScope::BACKEND : ProtocolCmsScope::FRONTEND;
        }

        $author = $entry->author ?? $this->security->getUser();
        if ($author instanceof UserModel || $author instanceof BackendUser) {
            $protocolEntry->author = $author->id;
            $protocolEntry->authorType = 'user';
        } elseif ($author instanceof MemberModel || $author instanceof FrontendUser) {
            $protocolEntry->author = $author->id;
            $protocolEntry->authorType = 'member';
        }

        $protocolEntry->save();
    }

    private function code(PrivacyProtocolEntryModel $model, ProtocolEntry $entry, PrivacyProtocolArchiveModel $archive): void
    {
        if ($archive->skipCodeProtocol) {
            return;
        }

        $this->stackTrace = null;

        $model->code =
            ($entry->codeFile ?? $this->getRelevantStackTrace()['file'] ?? '') . ':'
            . ($entry->codeFunction ?? $this->getRelevantStackTrace()['function'] ?? '')
            . '(' . ($entry->codeLine ?? $this->getRelevantStackTrace()['line'] ?? '') . ")\n"
            . $entry->codeStacktrace ?? (new \Exception())->getTraceAsString();


    }

    private function getRelevantStackTrace(): array
    {
        if (null === $this->stackTrace) {
            // compute stacktrace entry containing the relevant function call
            $stackTrace = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 4);
            $relevantStackEntry = [];
            if (!empty($stackTrace)) {
                $classMethods = get_class_methods(self::class);

                foreach ($stackTrace as $index => $entry) {
                    if (!str_ends_with($entry['file'], 'ProtocolHelper.php') || !\in_array($entry['function'], $classMethods)) {
                        $relevantStackEntry = $entry;

                        if (isset($stackTrace[$index + 1]['function'])) {
                            $relevantStackEntry['function'] = $stackTrace[$index + 1]['function'];
                        }

                        break;
                    }
                }
            }

            $this->stackTrace = $relevantStackEntry;
        }

        return $this->stackTrace;
    }
}