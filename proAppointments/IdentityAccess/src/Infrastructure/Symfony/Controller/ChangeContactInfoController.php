<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Symfony\Controller;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Application\UserUseCase\ChangeContactInformationRequest;
use ProAppointments\IdentityAccess\Application\UserViewCase\MyAccountRequest;
use ProAppointments\IdentityAccess\Application\UserViewCase\MyAccountVewCase;
use ProAppointments\IdentityAccess\Infrastructure\Symfony\Form\ChangeContactInfoForm;
use ProAppointments\IdentityAccess\Infrastructure\Symfony\Security\SecurityUserAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChangeContactInfoController extends AbstractController
{
    /** @var ApplicationService */
    private $usecase;

    /** @var MyAccountVewCase */
    private $userDataService;

    /**
     * RegistrationController constructor.
     */
    public function __construct(ApplicationService $changeContactInformationUserUseCase, MyAccountVewCase $userDataService)
    {
        $this->usecase = $changeContactInformationUserUseCase;
        $this->userDataService = $userDataService;
    }

    /**
     * @Route("/account/change-contact-info", name="identity_change_contact_info", methods={"GET","POST"})
     */
    public function changeContactInfoAction(Request $request): Response
    {
        /** @var SecurityUserAdapter $securityUser */
        $securityUser = $this->getUser();

        $userData = $this->userDataService->execute(
            new MyAccountRequest($securityUser->getId())
        );

        $form = $this->createForm(
            ChangeContactInfoForm::class,
            ['contact_email' => $userData->contactEmail(), 'mobile_number' => $userData->contactNumber()]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            try {
                $useCaseRequest = new ChangeContactInformationRequest(
                    $securityUser->getId(),
                    $formData['contact_email'],
                    $formData['mobile_number']
                );

                $this->usecase->execute($useCaseRequest);

                return $this->redirectToRoute('account');
            } catch (\Exception $exception) {
                // Todo convert domain Exception To FormError
            }
        }

        return $this->render('@identity/account/form/change_contact_info.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
