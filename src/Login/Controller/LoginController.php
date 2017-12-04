<?php
namespace Login\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class LoginController extends AbstractActionController
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
	 * LoginController constructor.
	 *
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
	 * Login
	 *
	 * This method allows you to login an user. The method
	 * validate a "login" and a "password" and is agnostic
	 * about the authentication source.
	 *
	 * @triggers __user_logged_in (\Login\Event)
	 *           The user logged in correctly
	 * @triggers __user_auth_failed (\Login\Event)
	 *           The user login process failed. Details are
	 *           inside 'Message' parameter
	 * @return array
	 */
	public function loginAction()
	{
        $form = $this->formManager->get('login_form_login');
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
	
			$form->setData($request->getPost());
	
			if ($form->isValid()) {

 				$data = $form->getData();

				$this->userProvider->setUsername($data['login']);
				$this->userProvider->setPassword($data['password']);

				/** @var \Zend\Authentication\AuthenticationService $result */
				$result = $this->authService->authenticate($this->userProvider);

				if( !$result->isValid() )
					{
					$this->getEventManager()->trigger(
							\Login\Event::USER_AUTH_FAILED,
							$this,
							array( 'Message' => $this->translator->translate('The combination username/password is not correct!') )
						);
					}
				else 
					{
					$this->getEventManager()->trigger(
							\Login\Event::USER_LOGGED_IN,
							$this,
							array( 'User' => $this->authService->getIdentity() )
						);

					}					
			}
		}
		return array('form' => $form);
 	}

	/**
	 * Register user
	 *
	 * This method is used to register user. It's basically agnostic
	 * about the storage and you must implement the logic inside your
	 * application
	 *
	 * @triggers __user_registered (\Login\Event)
	 *           The user is registered correctly
	 * @triggers __user_registered_failed (\Login\Event)
	 *           The user registration failed
	 * @return array
	 */
	public function registerAction()
	{
        $form = $this->formManager->get('login_form_register_form');

		$request = $this->getRequest();

		if ($request->isPost()) {

			$form->setData($request->getPost());

			// No need to add an input filter explicit here because
			// you should declare it inside te form
			// $form->setInputFilter($formfilter->getInputFilter());

			if ($form->isValid()) {

				$data = $form->getData();

                // This method must return an instance of Login\Action\Result
                // and validation is made against the return code
				/** @var $result \Login\Action\Result */
                $result =  $this->userProvider->register( $data );

                if( $result->isSuccessful() )
                {
                    $this->getEventManager()->trigger(
                        \Login\Event::USER_REGISTERED,
                        $this,
                        array( 'user' => $this->userProvider->getUser() )
                    );
                }
                else
                {
                    $this->getEventManager()->trigger(
                        \Login\Event::USER_REGISTERED_FAILED,
                        $this,
                        array( 'Messages' => $result->getMessages() )
                    );
                }


			}
		}
		return array('form' => $form);
	}

	/**
	 * Logout
	 *
	 * This method basically launch a logout event that you must catch to
	 * exit from the application. Here a basic example, where $sem is the
	 * event manager:
	 *
	 * <code>
	 * $sem->attach( '*', \Login\Event::USER_LOGGED_OUT, function(\Zend\Mvc\MvcEvent $e){
	 * // Perform here the operations you need. An example could be this, redirectin to login:
	 * $url = $e->getRouter()->assemble(array(), array('name' => 'login-user-login'));
	 * $response=$e->getResponse();
	 * $response->getHeaders()->addHeaderLine('Location', $url);
	 * $response->setStatusCode(302);
	 * $response->sendHeaders();
	 * $stopCallBack = function($e) use ($response){
	 *    $event->stopPropagation();
	 *    return $response;
	 *    };
	 * $e->getApplication()->getEventManager()->attach(\Zend\Mvc\MvcEvent::EVENT_ROUTE, $stopCallBack,-10000);
	 * return $response;
	 * }
	 * </code>
	 *
	 * @triggers __user_logged_out (\Login\Event)
	 *           The user logs out
	 *
	 * @return void
	 */
 	public function logoutAction()
 	{
 		$this->getEventManager()->trigger(
 				\Login\Event::USER_LOGGED_OUT,
 				$this,
 				array( 'Message' => $this->translator->translate('User logged out successfully!') )
 		);
 	}

	/**
	 * Password Recovery
	 *
	 * @triggers __user_pass_recovered (\Login\Event)
	 *           The user password is recovered correctly
	 * @triggers __user_pass_recover_failed (\Login\Event)
	 *           The password recovery process was not correctly completed
	 * @return array
	 */
 	public function passwordRecoveryAction()
 	{
		$form = $this->formManager->get('login_form_password_recovery_form');

 		$request = $this->getRequest();
 		
 		if ($request->isPost()) {
			$form->setData($request->getPost());
 		
 			if ($form->isValid()) {
 				$data = $form->getData();

                $suggestedPassword = self::generateStrongPassword(12);
                // This method must return an instance of Login\Action\Result
                // and validation is made against the return code
				/** @var $result \Login\Action\Result */
				$result =  $this->userProvider->recoverPassword($data['email'], $suggestedPassword);

                if( $result->isSuccessful() )
                {
                    $this->getEventManager()->trigger(
                        \Login\Event::USER_PASS_RECOVERED,
                        $this,
                        array( 'email' => $data['email'] )
                    );

                }
                else
                {
                    $this->getEventManager()->trigger(
                        \Login\Event::USER_PASS_RECOVER_FAILED,
                        $this,
                        array( 'Messages' => $result->getMessages() )
                    );
                }


 			}
 		}
 		return array('form' => $form);
 	}

	/**
	 * Generate strong password
	 *
	 * Generate a strong password and you can tell the function which sets
	 * of characters you want to use. The available sets are:
	 * l: lowercase
	 * u: uppercase
	 * d: decimals
	 * s: special characters
	 *
	 * @param int $length
	 * @param bool $add_dashes
	 * @param string $available_sets
	 * @return string
	 */
	public static function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
 	{
 		$sets = array();
 		if(strpos($available_sets, 'l') !== false)
 			$sets[] = 'abcdefghjkmnpqrstuvwxyz';
 		if(strpos($available_sets, 'u') !== false)
 			$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
 		if(strpos($available_sets, 'd') !== false)
 			$sets[] = '23456789';
 		if(strpos($available_sets, 's') !== false)
 			$sets[] = '!@#$%&*?';
 	
 		$all = '';
 		$password = '';
 		foreach($sets as $set)
 		{
 			$password .= $set[array_rand(str_split($set))];
 			$all .= $set;
 		}
 	
 		$all = str_split($all);
 		for($i = 0; $i < $length - count($sets); $i++)
 			$password .= $all[array_rand($all)];
 	
 			$password = str_shuffle($password);
 	
 			if(!$add_dashes)
 				return $password;
 	
 				$dash_len = floor(sqrt($length));
 				$dash_str = '';
 				while(strlen($password) > $dash_len)
 				{
 				$dash_str .= substr($password, 0, $dash_len) . '-';
 						$password = substr($password, $dash_len);
 				}
 				$dash_str .= $password;
 				return $dash_str;
 	} 	
}