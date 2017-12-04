<?php
namespace Login\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class ProfileController
 * @package Login\Controller
 */
class ProfileController extends AbstractActionController
{
    /** @var  $appConfig array */
    protected $appConfig;
    /** @var  $translator \Zend\Mvc\I18n\Translator */
    protected $translator;
    /** @var  $formManager \Zend\Form\FormElementManager */
    protected $formManager;
    /* @var $authService \Zend\Authentication\AuthenticationService */
    protected $authService;
    /* @var $userProvider \Login\Provider\User */
    protected $userProvider;

    /**
     * ProfileController constructor.
     * @param array $appConfig
     * @param \Zend\Mvc\I18n\Translator $translator
     * @param \Zend\Form\FormElementManager $formManager
     * @param \Zend\Authentication\AuthenticationService $authService
     * @param \Login\Provider\User $userProvider
     */
    public function __construct($appConfig, $translator, $formManager, $authService, $userProvider)
    {
        $this->appConfig = $appConfig;
        $this->translator = $translator;
        $this->formManager = $formManager;
        $this->authService = $authService;
        $this->userProvider = $userProvider;
    }

    /**
     * Change password
     *
     * Change password action
     *
     * @triggers __user_pass_changed (\Login\Event)
     *           The user password changed correctly
     * @triggers __user_pass_change_failed (\Login\Event)
     *           The change password process failed
     * @return arrayResponse
     */
 	public function changePasswordAction()
 	{
        if ( !$this->authService->hasIdentity() ){
            return $this->redirect()->toRoute('login-user-login');
        }

        $form = $this->formManager->get('login_form_change_password_form');

 		$request = $this->getRequest();
 		
 		if ($request->isPost()) {
 			
 			$form->setData($request->getPost());

            if ($form->isValid()) {

                $data = $form->getData();

                $result = $this->userProvider->changePassword($data);

                if( $result->isSuccessful() )
                {
                    $this->getEventManager()->trigger(
                        \Login\Event::USER_PASS_CHANGED,
                        $this,
                        array( 'User' => $this->authService->getIdentity() )
                    );
                }
                else
                {
                    $this->getEventManager()->trigger(
                        \Login\Event::USER_PASS_CHANGE_FAILED,
                        $this,
                        array( 'Messages' => $result->getMessages() )
                    );
                }
            }

 		}
        return array('form' => $form);
 	}

    public function editprofileAction()
    {
        throw new \Exception("Must be implemented!");
    }
}