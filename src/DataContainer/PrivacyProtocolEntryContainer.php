<?php

namespace HeimrichHannot\PrivacyProtocolBundle\DataContainer;

use Contao\BackendUser;
use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\CoreBundle\Exception\AccessDeniedException;
use Contao\CoreBundle\String\SimpleTokenParser;
use Contao\Database;
use Contao\DataContainer;
use Contao\Date;
use Contao\Input;
use HeimrichHannot\PrivacyProtocolBundle\Model\PrivacyProtocolArchiveModel;
use HeimrichHannot\PrivacyProtocolBundle\Model\PrivacyProtocolEntryModel;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;
use function array_combine;
use function array_keys;
use function array_map;

class PrivacyProtocolEntryContainer
{
    public function __construct(
        private readonly RequestStack        $requestStack,
        private readonly SimpleTokenParser   $parser,
        private readonly TranslatorInterface $translator,
        private readonly Security            $security,
    )
    {
    }

    #[AsCallback(table: 'tl_privacy_protocol_entry', target: 'config.onload')]
    public function onConfigLoadCallback(?DataContainer $dc = null): void
    {
        $this->checkPermission();

        if (null === $dc || !$dc->id || 'edit' !== $this->requestStack->getCurrentRequest()->query->get('act')) {
            return;
        }

        $GLOBALS['TL_DCA']['tl_privacy_protocol_entry']['fields']['dateAdded']['inputType'] = 'text';
        $GLOBALS['TL_DCA']['tl_privacy_protocol_entry']['fields']['dateAdded']['eval']['tl_class'] = 'w50';
        $GLOBALS['TL_DCA']['tl_privacy_protocol_entry']['fields']['dateAdded']['eval']['rgxp'] = 'datim';
        $GLOBALS['TL_DCA']['tl_privacy_protocol_entry']['fields']['dateAdded']['eval']['datepicker'] = true;

        $protocolEntry = PrivacyProtocolEntryModel::findByPk($dc->id);

        if (null === $protocolEntry) {
            return;
        }

        $archive = PrivacyProtocolArchiveModel::findByPk($protocolEntry->pid);
        if (!$archive) {
            return;
        }

        $pm = PaletteManipulator::create();

        if (!$archive->addCodeProtocol) {
            $pm->removeField('codeStacktrace');
        }

        $pm->applyToPalette('default', 'tl_privacy_protocol_entry');
    }

    #[AsCallback(table: 'tl_privacy_protocol_entry', target: 'list.sorting.child_record')]
    public function onListSortingChildRecordCallback(array $row): string
    {
        $titlePattern = '##type## (##id##)';

        $protocolEntry = PrivacyProtocolEntryModel::findByPk($row['id']);
        $protocolArchive = PrivacyProtocolArchiveModel::findByPk($protocolEntry?->pid);
        if ($protocolEntry && $protocolArchive && $protocolArchive->titlePattern) {
            $titlePattern = $protocolArchive->titlePattern;
        }

        $data = array_merge(
            $this->prefixArrayKey(json_decode($protocolEntry->target, true) ?? [], 'target_'),
            $this->prefixArrayKey(json_decode($protocolEntry->person, true) ?? [], 'person_'),
            array_filter($protocolEntry->row())
        );

        $data['pid'] = $protocolArchive->title;
        $data['type'] = $this->translator->trans('tl_privacy_protocol_entry.reference.' . $protocolEntry->type, [], 'contao_tl_privacy_protocol_entry');

        if (isset($data['person_email'])) {
            $data['email'] = $data['person_email'];
        }
        if (isset($data['person_name'])) {
            $data['name'] = $data['person_name'];
        } elseif (isset($data['person_firstname']) && $data['person_lastname']) {
            $data['name'] = $data['person_firstname'] . ' ' . $data['person_lastname'];
        }

        $title = $this->parser->parse($titlePattern, $data);

        return '<div class="tl_content_left">' . $title . ' <span style="color:#b3b3b3; padding-left:3px">[' . Date::parse(
                Date::getNumericDatimFormat(),
                trim($row['dateAdded'])
            ) . ']</span></div>';
    }

    #[AsCallback(table: 'tl_privacy_protocol_entry', target: 'fields.dataContainer.options')]
    public function onFieldsDataContainerCallback(?DataContainer $dc = null): array
    {
        return Database::getInstance()->listTables();
    }

    private function checkPermission(): void
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return;
        }

        /** @var BackendUser $user */
        $user = $this->security->getUser();
        $database = Database::getInstance();

        // Set the root IDs
        if (!\is_array($user->privacy_protocols) || empty($user->privacy_protocols)) {
            $root = [0];
        } else {
            $root = $user->privacy_protocols;
        }

        $id = ($this->requestStack->getCurrentRequest()?->query->get('id') ?? CURRENT_ID);

        // Check current action
        switch (Input::get('act')) {
            case 'paste':
            case 'select':
                // Check CURRENT_ID here (see #247)
                if (!in_array(CURRENT_ID, $root)) {
                    throw new AccessDeniedException('Not enough permissions to access private protocol ID ' . $id . '.');
                }
                break;

            case 'create':
                if (!\strlen(Input::get('pid')) || !\in_array(Input::get('pid'), $root)) {
                    throw new AccessDeniedException('Not enough permissions to create private protocol items in private protocol archive ID ' . Input::get('pid') . '.');
                }

                break;

            case 'cut':
//            case 'copy':
                if (Input::get('act') == 'cut' && Input::get('mode') == 1) {
                    $objArchive = $database->prepare("SELECT pid FROM tl_privacy_protocol_entry WHERE id=?")
                        ->limit(1)
                        ->execute(Input::get('pid'));

                    if ($objArchive->numRows < 1) {
                        throw new AccessDeniedException('Invalid news item ID ' . Input::get('pid') . '.');
                    }

                    $pid = $objArchive->pid;
                } else {
                    $pid = Input::get('pid');
                }


                if (!\in_array($pid, $root)) {
                    throw new AccessDeniedException('Not enough permissions to ' . Input::get('act') . ' private protocol item ID ' . $id . ' to private protocol archive ID ' . Input::get('pid') . '.');
                }
            // no break STATEMENT HERE

            case 'edit':
            case 'show':
            case 'delete':
                $objArchive = $database->prepare('SELECT pid FROM tl_privacy_protocol_entry WHERE id=?')
                    ->limit(1)
                    ->execute($id);

                if ($objArchive->numRows < 1) {
                    throw new AccessDeniedException('Invalid private protocol item ID ' . $id . '.');
                }

                if (!\in_array($objArchive->pid, $root)) {
                    throw new AccessDeniedException('Not enough permissions to ' . Input::get('act') . ' private protocol item ID ' . $id . ' of private protocol archive ID ' . $objArchive->pid . '.');
                }

                break;

            case 'editAll':
            case 'deleteAll':
            case 'overrideAll':
            case 'cutAll':
//            case 'copyAll':
                if (!\in_array($id, $root)) {
                    throw new AccessDeniedException('Not enough permissions to access private protocol archive ID ' . $id . '.');
                }

                $objArchive = $database->prepare('SELECT id FROM tl_privacy_protocol_entry WHERE pid=?')
                    ->execute($id);

                if ($objArchive->numRows < 1) {
                    throw new AccessDeniedException('Invalid private protocol archive ID ' . $id . '.');
                }

                $session = $this->requestStack->getSession();
                $sessionData = $session->all();
                $sessionData['CURRENT']['IDS'] = array_intersect(
                    $session['CURRENT']['IDS'] ?? [],
                    $objArchive->fetchEach('id')
                );
                $session->replace($sessionData);
                break;

            default:
                if (Input::get('act')) {
                    throw new AccessDeniedException('Invalid command "' . Input::get('act') . '".');
                } elseif (!\in_array($id, $root)) {
                    throw new AccessDeniedException('Not enough permissions to access private protocol archive ID ' . $id . '.');
                }

                break;
        }
    }

    private function prefixArrayKey(array $array, string $prefix): array
    {
        $keys = array_keys($array);
        $prefixedKeys = array_map(fn($key) => $prefix . $key, $keys);

        return array_combine($prefixedKeys, $array);
    }
}