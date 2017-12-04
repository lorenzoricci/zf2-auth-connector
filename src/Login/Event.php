<?php
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