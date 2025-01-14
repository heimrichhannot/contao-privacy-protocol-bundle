<?php

namespace HeimrichHannot\PrivacyProtocolBundle\Protocol;

enum ProtocolType: string
{
    case FIRST_OPT_IN = 'first_opt_in';
    case SECOND_OPT_IN = 'second_opt_in';
    case FIRST_OPT_OUT = 'first_opt_out';
    case SECOND_OPT_OUT = 'second_opt_out';
    case OPT_IN = 'opt_in';
    case OPT_OUT = 'opt_out';
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
}
