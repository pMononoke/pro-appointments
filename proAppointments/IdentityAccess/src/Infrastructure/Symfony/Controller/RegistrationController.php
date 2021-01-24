<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Symfony\Controller;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Application\UserUseCase\RegisterUserRequest;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;
use ProAppointments\IdentityAccess\Infrastructure\Symfony\Form\RegisterUserForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /** @var ApplicationService */
    private $usecase;

    /**
     * RegistrationController constructor.
     */
    public function __construct(ApplicationService $registerUserUseCase)
    {
        $this->usecase = $registerUserUseCase;
    }

    /**
     * @Route("/registration", name="identity_register_user", methods={"GET","POST"})
     */
    public function registerAction(Request $request): Response
    {
        $form = $this->createForm(RegisterUserForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            try {
                // happy path if valid form
                // Todo remove VO form request here. (should use only primitives)
                $useCaseRequest = new RegisterUserRequest(
                    //Todo remove userId
                    UserId::generate(),
                    UserEmail::fromString($formData['email']),
                    UserPassword::fromString($formData['password'])
                );

                $this->usecase->execute($useCaseRequest);

                // TODO redirect to login || message 'check your mail for confirmation link'
                return $this->redirectToRoute('app_login');
            } catch (\Exception $exception) {
                //$this->convertExceptionToFormError($form, 'leanpubInvoiceId', $exception);
            }
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

//    private function convertExceptionToFormError(FormInterface $form, string $field, UserFacingError $exception): void
//    {
//        $form->get($field)->addError(
//            new FormError(
//                $this->translator->trans($exception->translationId(), $exception->translationParameters()),
//                $exception->translationId(),
//                $exception->translationParameters()
//            )
//        );
//    }
}
