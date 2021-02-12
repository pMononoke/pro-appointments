<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Symfony\Controller;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Application\UserUseCase\ChangePasswordRequest;
use ProAppointments\IdentityAccess\Application\UserViewCase\MyAccountVewCase;
use ProAppointments\IdentityAccess\Infrastructure\Symfony\Form\ChangeUserPasswordForm;
use ProAppointments\IdentityAccess\Infrastructure\Symfony\Security\SecurityUserAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChangePasswordController extends AbstractController
{
    /** @var ApplicationService */
    private $usecase;

    /** @var MyAccountVewCase */
    private $userDataService;

    /**
     * RegistrationController constructor.
     */
    public function __construct(ApplicationService $changePasswordUserUseCase, MyAccountVewCase $userDataService)
    {
        $this->usecase = $changePasswordUserUseCase;
        $this->userDataService = $userDataService;
    }

    /**
     * @Route("/account/change-password", name="identity_change_password", methods={"GET","POST"})
     */
    public function changePasswordAction(Request $request): Response
    {
        /** @var SecurityUserAdapter $securityUser */
        $securityUser = $this->getUser();

        $form = $this->createForm(ChangeUserPasswordForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            try {
                $useCaseRequest = new ChangePasswordRequest(
                    $securityUser->getId(),
                    $formData['password'],
                );

                $this->usecase->execute($useCaseRequest);

                return $this->redirectToRoute('account');
            } catch (\Exception $exception) {
                // Todo convert domain Exception To FormError
            }
        }

        return $this->render('@identity/account/form/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
