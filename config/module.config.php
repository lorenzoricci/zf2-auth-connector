<?php
/**
 * This file is part of Zend Framework 2 Auth Connector (later ZF2AuthConnector).
 *
 * ZF2AuthConnector is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ZF2AuthConnector is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with ZF2AuthConnector.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      https://github.com/lorenzoricci/zf2-auth-connector source repository
 * @author    Lorenzo Ricci
 */
return array(
	/**
	 * Those are not needed anymore because of the use
	 * of Module::getControllerConfig() in which we
	 * are injecting the required services
	 */
	'controllers' => array(
		'invokables' => array(
//			'Login\Controller\Login' 	=> 'Login\Controller\LoginController',
//			'Login\Controller\Profile'	=> 'Login\Controller\ProfileController',
		),
	),


	'service_manager' => array(
		'invokables' => array(
			'user_listener' 	=> '\Login\Listener\User',
            'user_auth_service' => 'Zend\Authentication\AuthenticationService',
			'login_form_change_password_form' => 'Login\Form\ChangePasswordForm',
			'login_form_login' => 'Login\Form\LoginForm',
			'login_form_register_form' => 'Login\Form\RegisterForm',
			'login_form_password_recovery_form' => 'Login\Form\PasswordRecoveryForm'
		),
		'factories' => array(
			'user_factory' => '\Login\User\Factory',
		),
        'aliases' => array(
            'Zend\Authentication\AuthenticationService' => 'user_auth_service',
        ),
		'shared' => array(
			// services that should **NOT** be shared
			'login_form_change_password_form' => false,
			'login_form_login' => false,
			'login_form_register_form' => false,
			'login_form_password_recovery_form' => false,
		),
	),	
							
	'router' => array(
		'routes' => array(

			'login-user-login' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
						'route'    => '/user/login',
						'defaults' => array(
								'controller' => 'Login\Controller\Login',
								'action'     => 'login',
						),
				),
			),				
			'login-user-logout' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route'    => '/user/logout',
					'defaults' => array(
						'controller' => 'Login\Controller\Login',
						'action'     => 'logout',
					),
				),
			),

			'login-user-register' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route'    => '/user/register',
					'defaults' => array(
						'controller' => 'Login\Controller\Login',
						'action'     => 'register',
					),
				),
			),				
			'login-user-changepassword' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route'    => '/user/change-password',
					'defaults' => array(
						'controller' => 'Login\Controller\Profile',
						'action'     => 'change-password',
					),
				),
			),

//			'login-user-editprofile' => array(
//				'type' => 'Zend\Mvc\Router\Http\Literal',
//				'options' => array(
//					'route'    => '/user/edit-profile',
//					'defaults' => array(
//						'controller' => 'Login\Controller\Profile',
//						'action'     => 'editprofile',
//					),
//				),
//			),
								
			'login-user-passwordrecovery' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route'    => '/user/password-recovery',
					'defaults' => array(
						'controller' => 'Login\Controller\Login',
						'action'     => 'password-recovery',
					),
				),
			),
								
								
		),
	),

    'view_manager' => array(
            'template_map' => array(

                'login/login/login'						=> __DIR__ . '/../view/login.phtml',
                'login/login/register'					=> __DIR__ . '/../view/register.phtml',
                'login/login/passwordrecovery'		=> __DIR__ . '/../view/passwordrecovery.phtml',
                'login/profile/changepassword'		=> __DIR__ . '/../view/changepassword.phtml',
                'login/profile/editprofile'			=> __DIR__ . '/../view/editprofile.phtml',

            ),
    ),

    'login_user' => array(
        'provider' => null
    ),

	/*
	 * This is used to collect ignored annotations that are
	 * used inside the main application and you don't want to
	 * declare as class inside this module
	 */
	'zf2-auth-ignored-annotations' => array(
	),

);

