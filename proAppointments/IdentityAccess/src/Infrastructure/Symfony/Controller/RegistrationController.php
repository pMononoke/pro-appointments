<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Symfony\Controller;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Application\UserUseCase\RegisterUserRequest;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
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
                $useCaseRequest = new RegisterUserRequest(
                    $formData['email'],
                    $formData['password'],
                    null,
                    null,
                    null,
                    //Todo remove userId
                    UserId::generate()->toString(),
                );

                $this->usecase->execute($useCaseRequest);

                return $this->redirectToRoute('app_login');
            } catch (\Exception $exception) {
                // Todo convert Exception To FormError
            }
        }

        return $this->render('@identity/registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
