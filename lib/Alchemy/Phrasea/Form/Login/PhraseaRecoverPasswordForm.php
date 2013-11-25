<?php

/*
 * This file is part of Phraseanet
 *
 * (c) 2005-2013 Alchemy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alchemy\Phrasea\Form\Login;

use Alchemy\Phrasea\Application;
use Alchemy\Phrasea\Form\Constraint\PasswordToken;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Form used to renew password when password lost
 */
class PhraseaRecoverPasswordForm extends AbstractType
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('token', 'hidden', [
            'required'      => true,
            'constraints'   => [
                new PasswordToken($this->app, $this->app['tokens'])
            ]
        ]);

        $builder->add('password', 'repeated', [
            'type'              => 'password',
            'required'          => true,
            'invalid_message'   => 'Please provide the same passwords.',
            'first_name'        => 'password',
            'second_name'       => 'confirm',
            'first_options'     => ['label' => ('New password')],
            'second_options'    => ['label' => ('New password (confirmation)')],
            'constraints'       => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 5]),
            ],
        ]);
    }

    public function getName()
    {
        return null;
    }
}
