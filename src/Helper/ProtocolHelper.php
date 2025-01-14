<?php

namespace HeimrichHannot\PrivacyProtocolBundle\Helper;

use HeimrichHannot\PrivacyBundle\Model\ProtocolArchiveModel;
use HeimrichHannot\PrivacyProtocolBundle\Model\PrivacyProtocolEntryModel;
use HeimrichHannot\PrivacyProtocolBundle\Protocol\ProtocolType;

class ProtocolHelper
{
    public function ()
    {

    }



    public function addEntry(ProtocolType $type, int|ProtocolArchiveModel $archive, array $data, $packageName = '', $skipFields = ['id', 'tstamp', 'dateAdded', 'pid', 'type'])
    {
        if (is_int($archive)) {
            $archive = ProtocolArchiveModel::findByPk($archive);
        }

        if (null === $archive) {
            return false;
        }

        $protocolEntry = new PrivacyProtocolEntryModel();
        $protocolEntry->tstamp = $protocolEntry->dateAdded = time();
        $protocolEntry->pid = $archive;
        $protocolEntry->type = $type->value;

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

        $allowedPersonalFields = \Contao\StringUtil::deserialize($protocolArchive->personalFields, true);
        $allowedCodeFields = \Contao\StringUtil::deserialize($protocolArchive->codeFields, true);

        Controller::loadDataContainer('tl_privacy_protocol_entry');

        $dca = &$GLOBALS['TL_DCA']['tl_privacy_protocol_entry'];

        foreach ($dca['fields'] as $field => $fieldData) {
            if (!\in_array($field, $allowedPersonalFields) && isset($fieldData['eval']['personalField']) && $fieldData['eval']['personalField']) {
                continue;
            }

            if ((!\in_array($field, $allowedCodeFields) || !$protocolArchive->addCodeProtocol) && isset($fieldData['eval']['codeField'])
                && $fieldData['eval']['codeField']) {
                continue;
            }

            switch ($field) {
                case 'ip':
                    if (Environment::get('remoteAddr')) {
                        $protocolEntry->ip = System::anonymizeIp(Environment::get('ip'));
                    }

                    break;

                case 'cmsScope':
                    if (TL_MODE == 'FE') {
                        $protocolEntry->cmsScope = ProtocolEntryContainer::CMS_SCOPE_FRONTEND;

                        if (null !== ($member = FrontendUser::getInstance()) && $member->id) {
                            $protocolEntry->authorType = DcaUtil::AUTHOR_TYPE_MEMBER;
                            $protocolEntry->author = $member->id;
                        }
                    } elseif (TL_MODE == 'BE') {
                        $protocolEntry->cmsScope = ProtocolEntryContainer::CMS_SCOPE_BACKEND;

                        if (null !== ($user = BackendUser::getInstance()) && $user->id) {
                            $protocolEntry->authorType = DcaUtil::AUTHOR_TYPE_USER;
                            $protocolEntry->author = $user->id;
                        }
                    }

                    break;

                case 'url':
                    $protocolEntry->url = \Environment::get('url').'/'.\Environment::get('request');

                    break;

                case 'bundle':
                    $protocolEntry->bundle = $packageName;

                    break;

                case 'bundleVersion':
                    if (!$packageName) {
                        continue 2;
                    }

                    $path = TL_ROOT.'/composer/composer.lock';

                    if (!file_exists($path)) {
                        $path = TL_ROOT.'/composer.lock';
                    }

                    if (!file_exists($path)) {
                        continue 2;
                    }

                    $composerLock = file_get_contents($path);

                    if (!$composerLock) {
                        continue 2;
                    }

                    try {
                        $composerLock = json_decode($composerLock, true);

                        foreach ($composerLock['packages'] as $package) {
                            if (isset($package['name']) && $package['name'] === $packageName) {
                                if (isset($package['version'])) {
                                    $protocolEntry->bundleVersion = $package['version'];
                                }

                                break;
                            }
                        }
                    } catch (\Exception $e) {
                        // silently fail
                    }

                    break;

                case 'codeFile':
                    if (!empty($relevantStackEntry)) {
                        $protocolEntry->codeFile = $relevantStackEntry['file'];
                    }

                    break;

                case 'codeLine':
                    if (!empty($relevantStackEntry)) {
                        $protocolEntry->codeLine = $relevantStackEntry['line'];
                    }

                    break;

                case 'codeFunction':
                    if (!empty($relevantStackEntry)) {
                        $protocolEntry->codeFunction = $relevantStackEntry['function'];
                    }

                    break;

                case 'codeStacktrace':
                    $protocolEntry->codeStacktrace = (new \Exception())->getTraceAsString();

                    break;

                case 'dataContainer':
                    // provide backward compability to implementations with table (version 1.x)
                    if (isset($data['table'])) {
                        $protocolEntry->dataContainer = $data['table'];
                    }
            }

            // $data always has the highest priority
            if (isset($data[$field]) && !\in_array($field, $skipFields)) {
                $protocolEntry->{$field} = $data[$field];
            }
        }

        $protocolEntry->save();

        return $protocolEntry;
    }
}