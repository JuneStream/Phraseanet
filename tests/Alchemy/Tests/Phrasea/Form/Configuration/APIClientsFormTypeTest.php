<?php

/*
 * This file is part of Phraseanet
 *
 * (c) 2005-2013 Alchemy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alchemy\Tests\Phrasea\Form\Configuration;

use Alchemy\Phrasea\Form\Configuration\APIClientsFormType;
use Alchemy\Tests\Phrasea\Form\FormTestCase;

class APIClientsFormTypeTest extends FormTestCase
{
    public function getForm()
    {
        return new APIClientsFormType();
    }
}
