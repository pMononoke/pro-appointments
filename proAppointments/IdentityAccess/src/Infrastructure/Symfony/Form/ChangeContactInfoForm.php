<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Symfony\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ChangeContactInfoForm extends AbstractType
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
                'contact_email',
                TextType::class,
                [
                    'label' => 'form.identity.change_contact_info.email.label',
                    'help' => 'form.identity.change_contact_info.email.help',
                ]
            )
            ->add(
                'mobile_number',
                TextType::class,
                [
                    'label' => 'form.identity.change_contact_info.mobile_number.label',
                    'help' => 'form.identity.change_contact_info.mobile_number.help',
                ]
            )
            ->add(
                'change_contact_info_submit',
                SubmitType::class,
                [
                    'label' => 'change_contact_info_form.submit.label',
                ]
            )
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('action', $this->urlGenerator->generate('identity_change_contact_info'));
    }
}
