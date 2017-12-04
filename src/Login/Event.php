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
namespace Login;

class Event
{
	const USER_REGISTERED             = "__user_registered";
	const USER_REGISTERED_FAILED      = "__user_registered_failed";

	const USER_LOGGED_IN              = "__user_logged_in";
	const USER_LOGGED_OUT             = "__user_logged_out";

	const USER_AUTH_FAILED            = "__user_auth_failed";

	const USER_PASS_RECOVERED         = "__user_pass_recovered";
	const USER_PASS_RECOVER_FAILED    = "__user_pass_recover_failed";

	const USER_PASS_CHANGED           = "__user_pass_changed";
	const USER_PASS_CHANGE_FAILED     = "__user_pass_change_failed";

}