<?php

namespace HeimrichHannot\PrivacyProtocolBundle\DataContainer;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\CoreBundle\String\SimpleTokenParser;
use Contao\DataContainer;
use Contao\Date;
use HeimrichHannot\PrivacyProtocolBundle\Model\PrivacyProtocolArchiveModel;
use HeimrichHannot\PrivacyProtocolBundle\Model\PrivacyProtocolEntryModel;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

class PrivacyProtocolEntryContainer
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly SimpleTokenParser $parser,
        private readonly TranslatorInterface $translator,
    )
    {
    }

    #[AsCallback(table: 'tl_privacy_protocol_entry', target: 'config.onload')]
    public function onConfigLoadCallback(?DataContainer $dc = null): void
    {
        if (null === $dc || !$dc->id || 'edit' !== $this->requestStack->getCurrentRequest()->query->get('act')) {
            return;
        }

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

    /**
     * @Callback(table="tl_privacy_protocol_entry", target="list.sorting.child_record")
     */
    public function onListSortingChildRecordCallback(array $row): string
    {
        $titlePattern = '##type## (##id##)';

        $protocolEntry = PrivacyProtocolEntryModel::findByPk($row['id']);
        $protocolArchive = PrivacyProtocolArchiveModel::findByPk($protocolEntry?->pid);
        if ($protocolEntry && $protocolArchive && $protocolArchive->titlePattern) {
            $titlePattern = $protocolArchive->titlePattern;
        }

        $data = array_merge(
            json_decode($protocolEntry->data, true) ?? [],
            $protocolEntry->row()
        );
        $data['pid'] = $protocolArchive->title;
        $data['type'] = $this->translator->trans('tl_privacy_protocol_entry.reference.'.$protocolEntry->type, [], 'contao_tl_privacy_protocol_entry');

        $title = $this->parser->parse($titlePattern, $data);

        return '<div class="tl_content_left">' . $title . ' <span style="color:#b3b3b3; padding-left:3px">[' . Date::parse(
                Date::getNumericDatimFormat(),
                trim($row['dateAdded'])
            ) . ']</span></div>';
    }
}