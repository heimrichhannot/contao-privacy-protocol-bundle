<?php

namespace HeimrichHannot\PrivacyProtocolBundle\DataContainer;

use Contao\Backend;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\CoreBundle\Exception\AccessDeniedException;
use Contao\CoreBundle\Security\ContaoCorePermissions;
use Contao\Database;
use Contao\DataContainer;
use Contao\Image;
use Contao\Input;
use Contao\StringUtil;
use HeimrichHannot\PrivacyProtocolBundle\Security\PrivacyProtocolPermissions;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;
use Symfony\Component\Security\Core\Security;

class PrivacyProtocolArchiveContainer
{
    public function __construct(
        private readonly Security $security,
        private readonly RequestStack $requestStack,
    )
    {
    }

    #[AsCallback(table: 'tl_privacy_protocol_archive', target: 'config.onload')]
    public function onConfigLoadCallback(?DataContainer $dc = null): void
    {
        $this->checkPermissions();
    }

    #[AsCallback(table: 'tl_privacy_protocol_archive', target: 'config.oncreate')]
    public function onConfigCreateCallback(string $table, int $insertId): void
    {
        $this->adjustPermissions($insertId);
    }

    #[AsCallback(table: 'tl_privacy_protocol_archive', target: 'config.oncopy')]
    public function onConfigCopyCallback(int $insertId): void
    {
        $this->adjustPermissions($insertId);
    }

    #[AsCallback(table: 'tl_privacy_protocol_archive', target: 'list.operations.edit.button')]
    public function onListOperationsEditButtonCallback(array $row, ?string $href, string $label, string $title, ?string $icon, string $attributes,): string
    {
        if (!$this->security->isGranted(ContaoCorePermissions::USER_CAN_EDIT_FIELDS_OF_TABLE, 'tl_privacy_protocol_archive')) {
            return '';
        }

        return sprintf(
            '<a href="%s" title="%s"%s>%s</a> ',
            Backend::addToUrl($href . '&amp;id=' . $row['id']),
            StringUtil::specialchars($title),
            $attributes,
            Image::getHtml($icon, $label)
        );
    }

    #[AsCallback(table: 'tl_privacy_protocol_archive', target: 'list.operations.copy.button')]
    public function onListOperationsCopyButtonCallback(array $row, ?string $href, string $label, string $title, ?string $icon, string $attributes,): string
    {
        if (!$this->security->isGranted(PrivacyProtocolPermissions::USER_CAN_CREATE_ARCHIVES)) {
            return '';
        }

        return sprintf(
            '<a href="%s" title="%s"%s>%s</a> ',
            Backend::addToUrl($href . '&amp;id=' . $row['id']),
            StringUtil::specialchars($title),
            $attributes,
            Image::getHtml($icon, $label)
        );
    }

    #[AsCallback(table: 'tl_privacy_protocol_archive', target: 'list.operations.delete.button')]
    public function onListOperationsDeleteButtonCallback(array $row, ?string $href, string $label, string $title, ?string $icon, string $attributes,): string
    {
        if (!$this->security->isGranted(PrivacyProtocolPermissions::USER_CAN_DELETE_ARCHIVES)) {
            return '';
        }

        return sprintf(
            '<a href="%s" title="%s"%s>%s</a> ',
            Backend::addToUrl($href . '&amp;id=' . $row['id']),
            StringUtil::specialchars($title),
            $attributes,
            Image::getHtml($icon, $label)
        );
    }

    protected function checkPermissions(): void
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return;
        }

        $user = $this->security->getUser();

        // Set root IDs
        if (!\is_array($user->privacy_protocols) || empty($user->privacy_protocols)) {
            $root = [0];
        } else {
            $root = $user->privacy_protocols;
        }

        $GLOBALS['TL_DCA']['tl_privacy_protocol_archive']['list']['sorting']['root'] = $root;

        // Check permissions to add archives
        if (!$this->security->isGranted(PrivacyProtocolPermissions::USER_CAN_CREATE_ARCHIVES)) {
            $GLOBALS['TL_DCA']['tl_privacy_protocol_archive']['config']['closed'] = true;
            $GLOBALS['TL_DCA']['tl_privacy_protocol_archive']['config']['notCreatable'] = true;
            $GLOBALS['TL_DCA']['tl_privacy_protocol_archive']['config']['notCopyable'] = true;
        }

        // Check permissions to delete archives
        if (!$this->security->isGranted(PrivacyProtocolPermissions::USER_CAN_DELETE_ARCHIVES))
        {
            $GLOBALS['TL_DCA']['tl_privacy_protocol_archive']['config']['notDeletable'] = true;
        }

        // Check current action
        switch (Input::get('act')) {
            case 'select':
                // Allow
                break;

            case 'create':
                if (!$this->security->isGranted(PrivacyProtocolPermissions::USER_CAN_CREATE_ARCHIVES))
                {
                    throw new AccessDeniedException('Not enough permissions to create protocal archives.');
                }
                break;

            case 'edit':
            case 'delete':
            case 'show':
                if (!in_array(Input::get('id'), $root) || (Input::get('act') == 'delete' && !$this->security->isGranted(PrivacyProtocolPermissions::USER_CAN_DELETE_ARCHIVES)))
                {
                    throw new AccessDeniedException('Not enough permissions to ' . Input::get('act') . ' protocal archive ID ' . Input::get('id') . '.');
                }
                break;

            case 'editAll':
            case 'deleteAll':
            case 'overrideAll':
                $session = $this->requestStack->getSession()->all();

                if (Input::get('act') == 'deleteAll' && !$this->security->isGranted(PrivacyProtocolPermissions::USER_CAN_DELETE_ARCHIVES))
                {
                    $session['CURRENT']['IDS'] = [];
                }
                else
                {
                    $session['CURRENT']['IDS'] = array_intersect((array) $session['CURRENT']['IDS'], $root);
                }
            $this->requestStack->getSession()->replace($session);
                break;

            default:
                if (Input::get('act'))
                {
                    throw new AccessDeniedException('Not enough permissions to ' . Input::get('act') . ' protocol archives.');
                }
                break;
        }

    }

    /**
     * Add the new archive to the permissions
     *
     * @param $insertId
     */
    protected function adjustPermissions(int $insertId)
    {
        if ($this->security->isGranted('ROLE_ADMIN'))
        {
            return;
        }

        $user = $this->security->getUser();

        // Set root IDs
        if (!\is_array($user->privacy_protocols) || empty($user->privacy_protocols)) {
            $root = [0];
        } else {
            $root = $user->privacy_protocols;
        }

        // The archive is enabled already
        if (in_array($insertId, $root))
        {
            return;
        }

        $database = Database::getInstance();

        /** @var AttributeBagInterface $objSessionBag */
        $objSessionBag = $this->requestStack->getSession()->getBag('contao_backend');

        $arrNew = $objSessionBag->get('new_records');

        if (is_array($arrNew['tl_privacy_protocol_archive']) && in_array($insertId, $arrNew['tl_privacy_protocol_archive']))
        {
            // Add the permissions on group level
            if ($user->inherit != 'custom')
            {
                $objGroup = $database->execute(
                    "SELECT id, privacy_protocols, privacy_protocolp FROM tl_user_group WHERE id IN(" . implode(',', array_map('\intval', $user->groups)) . ")"
                );

                while ($objGroup->next())
                {
                    $arrNewp = StringUtil::deserialize($objGroup->privacy_protocolp);

                    if (is_array($arrNewp) && in_array('create', $arrNewp))
                    {
                        $archives = StringUtil::deserialize($objGroup->privacy_protocols, true);
                        $archives[] = $insertId;

                        $database->prepare("UPDATE tl_user_group SET privacy_protocols=? WHERE id=?")
                            ->execute(serialize($archives), $objGroup->id);
                    }
                }
            }

            // Add the permissions on user level
            if ($user->inherit != 'group')
            {
                $objUser = $database->prepare(
                    "SELECT privacy_protocols, privacy_protocolp FROM tl_user WHERE id=?"
                )
                    ->limit(1)
                    ->execute($user->id);

                $arrNewp = StringUtil::deserialize($objUser->privacy_protocolp);

                if (is_array($arrNewp) && in_array('create', $arrNewp))
                {
                    $archives = StringUtil::deserialize($objUser->privacy_protocols, true);
                    $archives[] = $insertId;

                    $database->prepare("UPDATE tl_user SET privacy_protocols=? WHERE id=?")
                        ->execute(serialize($archives), $user->id);
                }
            }

            // Add the new element to the user object
            $root[] = $insertId;
            $user->privacy_protocols = $root;
        }
    }
}