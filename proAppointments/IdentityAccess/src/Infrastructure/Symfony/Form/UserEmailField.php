<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Symfony\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UserEmailField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'label' => 'form.identity.user_email.label',
                'help' => 'form.identity.user_email.help',
                'constraints' => [
                    //new NotBlank(),
                ],
            ]
        );
    }

    public function getParent()
    {
        return TextType::class;
    }
}
