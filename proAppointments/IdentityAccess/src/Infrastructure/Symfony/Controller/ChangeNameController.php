<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Symfony\Controller;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Application\UserUseCase\ChangeNameRequest;
use ProAppointments\IdentityAccess\Application\UserViewCase\MyAccountRequest;
use ProAppointments\IdentityAccess\Application\UserViewCase\MyAccountVewCase;
use ProAppointments\IdentityAccess\Infrastructure\Symfony\Form\ChangePersonalNameForm;
use ProAppointments\IdentityAccess\Infrastructure\Symfony\Security\SecurityUserAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChangeNameController extends AbstractController
{
    /** @var ApplicationService */
    private $usecase;

    /** @var MyAccountVewCase */
    private $userDataService;

    /**
     * RegistrationController constructor.
     */
    public function __construct(ApplicationService $changeNameUserUseCase, MyAccountVewCase $userDataService)
    {
        $this->usecase = $changeNameUserUseCase;
        $this->userDataService = $userDataService;
    }

    /**
     * @Route("/account/change-name", name="identity_change_name", methods={"GET","POST"})
     */
    public function changeNameAction(Request $request): Response
    {
        /** @var SecurityUserAdapter $securityUser */
        $securityUser = $this->getUser();

        $userData = $this->userDataService->execute(
            new MyAccountRequest($securityUser->getId())
        );

        $form = $this->createForm(
            ChangePersonalNameForm::class,
            ['first_name' => $userData->firstName(), 'last_name' => $userData->lastName()]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            try {
                $useCaseRequest = new ChangeNameRequest(
                    $securityUser->getId(),
                    $formData['first_name'],
                    $formData['last_name']
                );

                $this->usecase->execute($useCaseRequest);

                return $this->redirectToRoute('account');
            } catch (\Exception $exception) {
                // Todo convert domain Exception To FormError
            }
        }

        return $this->render('@identity/account/form/change_personal_name.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
