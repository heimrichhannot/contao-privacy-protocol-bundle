<?php

namespace HeimrichHannot\PrivacyProtocolBundle\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PrivacyProtocolArchiveVoter extends Voter
{

    protected function supports(string $attribute, $subject)
    {
        // TODO: Implement supports() method.
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        // TODO: Implement voteOnAttribute() method.
    }
}