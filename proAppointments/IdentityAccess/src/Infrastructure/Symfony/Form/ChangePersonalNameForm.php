<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Symfony\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ChangePersonalNameForm extends AbstractType
{
    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'first_name',
                TextType::class,
                [
                    'label' => 'form.identity.change_personal_name.first_name.label',
                    'help' => 'form.identity.change_personal_name.first_name.help',
                ]
            )
            ->add(
                'last_name',
                TextType::class,
                [
                    'label' => 'form.identity.change_personal_name.last_name.label',
                    'help' => 'form.identity.change_personal_name.last_name.help',
                ]
            )
            ->add(
                'change_personal_name_submit',
                SubmitType::class,
                [
                    'label' => 'change_personal_name_form.submit.label',
                ]
            )
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('action', $this->urlGenerator->generate('identity_change_name'));
    }
}
