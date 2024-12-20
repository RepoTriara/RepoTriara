<?php
/**
 * Class that handles all the e-mails that the system can send.
 *
 * Currently there are emails defined for the following actions:
 * - A new file has been uploaded by a system user.
 * - A new file has been uploaded by a client.
 * - A new client has been created by a system user.
 * - A new client has self-registered.
 * - A new system user has been created.
 * - A user or client requested a password reset.
 *
 * @package		ProjectSend
 * @subpackage	Classes
 */

/**
 * Call the file that has the markup for the header and footer
 * of the e-mails.
 */
include_once(ROOT_DIR.'/includes/email-template.php');

/**
 * Default e-mail templates files
 */
define('EMAIL_TEMPLATE_HEADER', 'header.html');
define('EMAIL_TEMPLATE_FOOTER', 'footer.html');
define('EMAIL_TEMPLATE_NEW_CLIENT', 'new-client.html');
define('EMAIL_TEMPLATE_NEW_CLIENT_SELF', 'new-client-self.html');
define('EMAIL_TEMPLATE_CLIENT_EDITED', 'client-edited.html');
define('EMAIL_TEMPLATE_NEW_USER', 'new-user.html');
define('EMAIL_TEMPLATE_ACCOUNT_APPROVE', 'account-approve.html');
define('EMAIL_TEMPLATE_ACCOUNT_DENY', 'account-deny.html');
define('EMAIL_TEMPLATE_NEW_FILE_BY_USER', 'new-file-for-client.html');
define('EMAIL_TEMPLATE_NEW_FILE_BY_CLIENT', 'new-file-by-client.html');
define('EMAIL_TEMPLATE_PASSWORD_RESET', 'password-reset.html');

global $email_template_header;
global $email_template_footer;
$email_template_header = file_get_contents(ROOT_DIR.'/emails/'.EMAIL_TEMPLATE_HEADER);
$email_template_footer = file_get_contents(ROOT_DIR.'/emails/'.EMAIL_TEMPLATE_FOOTER);

/** Define the messages texts */

/** Strings for the "New file uploaded" BY A SYSTEM USER e-mail */
$email_strings_file_by_user = array(
									'subject'	=> ( defined('EMAILS_FILE_BY_USER_USE_SUBJECT_CUSTOM' ) && EMAILS_FILE_BY_USER_USE_SUBJECT_CUSTOM == 1 && defined( 'EMAILS_FILE_BY_USER_SUBJECT' ) ) ? EMAILS_FILE_BY_USER_SUBJECT : __('New files uploaded for you','cftp_admin'),
									'body'		=> __('The following files are now available for you to download.','cftp_admin'),
									'body2'		=> __("Si usted prefiere no ser notificado de nuevos archivos, vaya a Mi Cuenta y desactive la opción",'cftp_admin'),
									'body3'		=> __('You can access a list of all your files or upload your own','cftp_admin'),
									'body4'		=> __('by logging in here','cftp_admin')
								);

/** Strings for the "New file uploaded" BY A CLIENT e-mail */
$email_strings_file_by_client = array(
									'subject'	=> ( defined('EMAILS_FILE_BY_CLIENT_USE_SUBJECT_CUSTOM' ) && EMAILS_FILE_BY_CLIENT_USE_SUBJECT_CUSTOM == 1 && defined( 'EMAILS_FILE_BY_CLIENT_SUBJECT' ) ) ? EMAILS_FILE_BY_CLIENT_SUBJECT : __('New files uploaded by clients','cftp_admin'),
									'body'		=> __('New files has been uploaded by the following clients','cftp_admin'),
									'body2'		=> __("You can manage these files",'cftp_admin'),
									'body3'		=> __('by logging in here','cftp_admin')
								);


/** Strings for the "New client created" e-mail */
$email_strings_new_client = array(
									'subject'		=> ( defined('EMAILS_CLIENT_BY_USER_USE_SUBJECT_CUSTOM' ) && EMAILS_CLIENT_BY_USER_USE_SUBJECT_CUSTOM == 1 && defined( 'EMAILS_CLIENT_BY_USER_SUBJECT' ) ) ? EMAILS_CLIENT_BY_USER_SUBJECT : __('Welcome to ProjectSend','cftp_admin'),
									'body'			=> __('A new account was created for you. From now on, you can access the files that have been uploaded under your account using the following credentials:','cftp_admin'),
									'body2'			=> __('You can log in following this link','cftp_admin'),
									'body3'			=> __('Please contact the administrator if you need further assistance.','cftp_admin'),
									'label_user'	=> __('Your username','cftp_admin'),
									'label_pass'	=> __('Your password','cftp_admin')
								);

/**
 * Strings for the "New client" e-mail to the admin
 * on self registration.
 */
$email_strings_new_client_self = array(
									'subject'		=> ( defined('EMAILS_CLIENT_BY_SELF_USE_SUBJECT_CUSTOM' ) && EMAILS_CLIENT_BY_SELF_USE_SUBJECT_CUSTOM == 1 && defined( 'EMAILS_CLIENT_BY_SELF_SUBJECT' ) ) ? EMAILS_CLIENT_BY_SELF_SUBJECT : __('A new client has registered.','cftp_admin'),
									'body'			=> __('A new account was created using the self registration form on your site. Registration information:','cftp_admin'),
									'label_name'	=> __('Full name','cftp_admin'),
									'label_user'	=> __('Username','cftp_admin'),
									'label_request'	=> __('Additionally, the client requests access to the following group(s)','cftp_admin')
								);
								if ( defined('CLIENTS_AUTO_APPROVE') && CLIENTS_AUTO_APPROVE == '0') {
									$email_strings_new_client_self['body2'] = __('Please log in to process the request.','cftp_admin');
									$email_strings_new_client_self['body3'] = __('Remember, your new client will not be able to log in until an administrator has approved their account.','cftp_admin');
								}
								else {
									$email_strings_new_client_self['body2'] = __('Auto-approvals of new accounts are currently enabled.','cftp_admin');
									$email_strings_new_client_self['body3'] = __('You can log in to manually deactivate it.','cftp_admin');
								}


/** Strings for the "Account approved" e-mail */
$email_strings_account_approved = array(
									'subject'			=> ( defined('EMAILS_ACCOUNT_APPROVE_USE_SUBJECT_CUSTOM' ) && EMAILS_ACCOUNT_APPROVE_USE_SUBJECT_CUSTOM == 1 && defined( 'EMAILS_ACCOUNT_APPROVE_SUBJECT' ) ) ? EMAILS_ACCOUNT_APPROVE_SUBJECT : __('You account has been approved','cftp_admin'),
									'body'				=> __('Your account has been approved.','cftp_admin'),
									'title_memberships'	=> __('Additionally, your group membership requests have been processed.','cftp_admin'),
									'title_approved'	=> __('Approved requests:','cftp_admin'),
									'title_denied'		=> __('Denied requests:','cftp_admin'),
									'body2'				=> __('You can log in following this link','cftp_admin'),
									'body3'				=> __('Please contact the administrator if you need further assistance.','cftp_admin')
								);

/** Strings for the "Account denied" e-mail */
$email_strings_account_denied = array(
									'subject'		=> ( defined('EMAILS_ACCOUNT_DENY_USE_SUBJECT_CUSTOM' ) && EMAILS_ACCOUNT_DENY_USE_SUBJECT_CUSTOM == 1 && defined( 'EMAILS_ACCOUNT_DENY_SUBJECT' ) ) ? EMAILS_ACCOUNT_DENY_SUBJECT : __('You account has been denied','cftp_admin'),
									'body'			=> __('Your account request has been denied.','cftp_admin'),
									'body2'			=> __('Please contact the administrator if you need further assistance.','cftp_admin')
								);

/** Strings for the "New system user created" e-mail */
$email_strings_new_user = array(
									'subject'		=> ( defined('EMAILS_NEW_USER_USE_SUBJECT_CUSTOM' ) && EMAILS_NEW_USER_USE_SUBJECT_CUSTOM == 1 && defined( 'EMAILS_NEW_USER_SUBJECT' ) ) ? EMAILS_NEW_USER_SUBJECT : __('Welcome to ProjectSend','cftp_admin'),
									'body'			=> __('A new account was created for you. From now on, you can access the system administrator using the following credentials:','cftp_admin'),
									'body2'			=> __('Access the system panel here','cftp_admin'),
									'body3'			=> __('Thank you for using ProjectSend.','cftp_admin'),
									'label_user'	=> __('Your username','cftp_admin'),
									'label_pass'	=> __('Your password','cftp_admin')
								);


/** Strings for the "Reset password" e-mail */
$email_strings_pass_reset = array(
									'subject'		=> ( defined('EMAILS_PASS_RESET_USE_SUBJECT_CUSTOM' ) && EMAILS_PASS_RESET_USE_SUBJECT_CUSTOM == 1 && defined( 'EMAILS_PASS_RESET_SUBJECT' ) ) ? EMAILS_PASS_RESET_SUBJECT : __('Password reset instructions','cftp_admin'),
									'body'			=> __('A request has been received to reset the password for the following account:','cftp_admin'),
									'body2'			=> __('To continue, please visit the following link','cftp_admin'),
									'body3'			=> __('The request is valid only for 24 hours.','cftp_admin'),
									'body4'			=> __('If you did not make this request, simply ignore this email.','cftp_admin'),
									'label_user'	=> __('Username','cftp_admin'),
								);

/**
 * Strings for the "Review client group requests" e-mail to the admin
 */
$email_strings_client_edited = array(
									'subject'			=> ( defined('EMAILS_CLIENT_EDITED_USE_SUBJECT_CUSTOM' ) && EMAILS_CLIENT_EDITED_USE_SUBJECT_CUSTOM == 1 && defined( 'EMAILS_CLIENT_EDITED_SUBJECT' ) ) ? EMAILS_CLIENT_EDITED_SUBJECT : __('A client has changed memberships requests.','cftp_admin'),
									'body'				=> __('A client on you site has just changed his groups membership requests and needs your approval.','cftp_admin'),
									'label_name'		=> __('Full name','cftp_admin'),
									'label_user'		=> __('Username','cftp_admin'),
									'label_request'	=> __('The client requests access to the following group(s)','cftp_admin'),
									'body2'				=> __('Please log in to process the request.','cftp_admin')
								);

class PSend_Email
{
	/**
	 * The body of the e-mails is gotten from the html templates
	 * found on the /emails folder.
	 */
	function email_prepare_body($type)
	{
		global $email_template_header;
		global $email_template_footer;

		switch ($type) {
			case 'new_client':
					$filename	= EMAIL_TEMPLATE_NEW_CLIENT;
					$body_check	= (!defined('EMAILS_CLIENT_BY_USER_USE_CUSTOM') || EMAILS_CLIENT_BY_USER_USE_CUSTOM == '0') ? '0' : EMAILS_CLIENT_BY_USER_USE_CUSTOM;
					$body_text	= EMAILS_CLIENT_BY_USER_TEXT;
				break;
			case 'new_client_self':
					$filename	= EMAIL_TEMPLATE_NEW_CLIENT_SELF;
					$body_check	= (!defined('EMAILS_CLIENT_BY_SELF_USE_CUSTOM') || EMAILS_CLIENT_BY_SELF_USE_CUSTOM == '0') ? '0' : EMAILS_CLIENT_BY_SELF_USE_CUSTOM;
					$body_text	= EMAILS_CLIENT_BY_SELF_TEXT;
				break;
			case 'client_approve':
					$filename	= EMAIL_TEMPLATE_ACCOUNT_APPROVE;
					$body_check	= (!defined('EMAILS_ACCOUNT_APPROVE_USE_CUSTOM') || EMAILS_ACCOUNT_APPROVE_USE_CUSTOM == '0') ? '0' : EMAILS_ACCOUNT_APPROVE_USE_CUSTOM;
					$body_text	= EMAILS_ACCOUNT_APPROVE_TEXT;
				break;
			case 'client_deny':
					$filename	= EMAIL_TEMPLATE_ACCOUNT_DENY;
					$body_check	= (!defined('EMAILS_ACCOUNT_DENY_USE_CUSTOM') || EMAILS_ACCOUNT_DENY_USE_CUSTOM == '0') ? '0' : EMAILS_ACCOUNT_DENY_USE_CUSTOM;
					$body_text	= EMAILS_ACCOUNT_DENY_TEXT;
				break;
			case 'new_user':
					$filename	= EMAIL_TEMPLATE_NEW_USER;
					$body_check	= (!defined('EMAILS_NEW_USER_USE_CUSTOM') || EMAILS_NEW_USER_USE_CUSTOM == '0') ? '0' : EMAILS_NEW_USER_USE_CUSTOM;
					$body_text	= EMAILS_NEW_USER_TEXT;
				break;
			case 'new_file_by_user':
					$filename	= EMAIL_TEMPLATE_NEW_FILE_BY_USER;
					$body_check	= (!defined('EMAILS_FILE_BY_USER_USE_CUSTOM') || EMAILS_FILE_BY_USER_USE_CUSTOM == '0') ? '0' : EMAILS_FILE_BY_USER_USE_CUSTOM;
					$body_text	= EMAILS_FILE_BY_USER_TEXT;
				break;
			case 'new_file_by_client':
					$filename	= EMAIL_TEMPLATE_NEW_FILE_BY_CLIENT;
					$body_check	= (!defined('EMAILS_FILE_BY_CLIENT_USE_CUSTOM') || EMAILS_FILE_BY_CLIENT_USE_CUSTOM == '0') ? '0' : EMAILS_FILE_BY_CLIENT_USE_CUSTOM;
					$body_text	= EMAILS_FILE_BY_CLIENT_TEXT;
				break;
			case 'password_reset':
					$filename	= EMAIL_TEMPLATE_PASSWORD_RESET;
					$body_check	= (!defined('EMAILS_PASS_RESET_USE_CUSTOM') || EMAILS_PASS_RESET_USE_CUSTOM == '0') ? '0' : EMAILS_PASS_RESET_USE_CUSTOM;
					$body_text	= EMAILS_PASS_RESET_TEXT;
				break;
			case 'client_edited':
					$filename	= EMAIL_TEMPLATE_CLIENT_EDITED;
					$body_check	= (!defined('EMAILS_CLIENT_EDITED_USE_CUSTOM') || EMAILS_CLIENT_EDITED_USE_CUSTOM == '0') ? '0' : EMAILS_CLIENT_EDITED_USE_CUSTOM;
					$body_text	= EMAILS_CLIENT_EDITED_TEXT;
				break;
		}

		if ($body_check == '0') {
			$this->get_body = file_get_contents(ROOT_DIR.'/emails/'.$filename);
		}
		else {
			$this->get_body = $body_text;
		}

		/**
		 * Header
		 */
		if (!defined('EMAILS_HEADER_FOOTER_CUSTOM') || EMAILS_HEADER_FOOTER_CUSTOM == '0') {
			$this->make_body = $email_template_header;
		}
		else {
			$this->make_body = EMAILS_HEADER_TEXT;
		}

		/**
		 * Body
		 */
		$this->make_body .= $this->get_body;

		/**
		 * Footer
		 */
		if (!defined('EMAILS_HEADER_FOOTER_CUSTOM') || EMAILS_HEADER_FOOTER_CUSTOM == '0') {
			$this->make_body .= $email_template_footer;
		}
		else {
			$this->make_body .= EMAILS_FOOTER_TEXT;
		}


		return $this->make_body;
	}

	/**
	 * Prepare the body for the "New Client" e-mail.
	 * The new username and password are also sent.
	 */
	function email_new_client($username,$password)
	{
		global $email_strings_new_client;
		$this->email_body = $this->email_prepare_body('new_client');
		$this->email_body = str_replace(
									array('%SUBJECT%','%BODY1%','%BODY2%','%BODY3%','%LBLUSER%','%LBLPASS%','%USERNAME%','%PASSWORD%','%URI%'),
									array(
											$email_strings_new_client['subject'],
											$email_strings_new_client['body'],
											$email_strings_new_client['body2'],
											$email_strings_new_client['body3'],
											$email_strings_new_client['label_user'],
											$email_strings_new_client['label_pass'],
											$username,
											$password,
											BASE_URI
										),
									$this->email_body
								);
		return array(
					'subject' => $email_strings_new_client['subject'],
					'body' => $this->email_body
				);
	}

	/**
	 * Prepare the body for the "New Client" self registration e-mail.
	 * The name of the client and username are also sent.
	 */
	function email_new_client_self($username,$fullname,$memberships_requests)
	{
		global $email_strings_new_client_self;
		$this->email_body = $this->email_prepare_body('new_client_self');
		$this->email_body = str_replace(
									array('%SUBJECT%','%BODY1%','%BODY2%','%BODY3%','%LBLNAME%','%LBLUSER%','%FULLNAME%','%USERNAME%','%URI%'),
									array(
										$email_strings_new_client_self['subject'],
										$email_strings_new_client_self['body'],
										$email_strings_new_client_self['body2'],
										$email_strings_new_client_self['body3'],
										$email_strings_new_client_self['label_name'],
										$email_strings_new_client_self['label_user'],
										$fullname,$username,BASE_URI
										),
									$this->email_body
								);
		if ( !empty( $memberships_requests ) ) {
			$this->groups		= new GroupActions;
			$this->groups_args	= array(
										'group_ids' => $memberships_requests
									);
			$this->get_groups = $this->groups->get_groups( $this->groups_args );

			$this->groups_list = '<ul>';
			foreach ( $this->get_groups as $group ) {
				$this->groups_list .= '<li>' . $group['name'] . '</li>';
			}
			$this->groups_list .= '</ul>';

			$memberships_requests = implode(',',$memberships_requests);
			$this->email_body = str_replace(
									array('%LABEL_REQUESTS%', '%GROUPS_REQUESTS%'),
									array(
										$email_strings_new_client_self['label_request'],
										$this->groups_list
									),
								$this->email_body
							);
		}
		return array(
					'subject' => $email_strings_new_client_self['subject'],
					'body' => $this->email_body
				);
	}

	/**
	 * Prepare the body for the "Account approved" e-mail.
	 * Also sends the memberships requests approval status.
	 */
	function email_account_approve($username,$name,$memberships_requests)
	{
		global $email_strings_account_approved;
		$requests_title_replace = false;

		$this->groups = new GroupActions();
		$this->get_args = array();
		$this->get_groups = $this->groups->get_groups( $this->get_args );

		if ( !empty( $memberships_requests['approved'] ) ) {
			$requests_title_replace = true;
			$approved_title = '<p>'.$email_strings_account_approved['title_approved'].'</p>';
			// Make the list
			$approved_list = '<ul>';
			foreach ( $memberships_requests['approved'] as $group_id ) {
				$approved_list .= '<li style="list-style:disc;">' . $this->get_groups[$group_id]['name'] . '</li>';
			}
			$approved_list .= '</ul><hr>';
		}
		else {
			$approved_list =  '';
			$approved_title = '';
		}
		if ( !empty( $memberships_requests['denied'] ) ) {
			$requests_title_replace = true;
			$denied_title = '<p>'.$email_strings_account_approved['title_denied'].'</p>';
			// Make the list
			$denied_list = '<ul>';
			foreach ( $memberships_requests['denied'] as $group_id ) {
				$denied_list .= '<li style="list-style:disc;">' . $this->get_groups[$group_id]['name'] . '</li>';
			}
			$denied_list .= '</ul><hr>';
		}
		else {
			$denied_list =  '';
			$denied_title = '';
		}

		$requests_title = ( $requests_title_replace == true ) ? '<p>'.$email_strings_account_approved['title_approved'].'</p>' : '';

		$this->email_body = $this->email_prepare_body('client_approve');
		$this->email_body = str_replace(
									array('%SUBJECT%','%BODY1%', '%REQUESTS_TITLE%', '%APPROVED_TITLE%','%GROUPS_APPROVED%','%DENIED_TITLE%','%GROUPS_DENIED%','%BODY2%','%BODY3%','%URI%'),
									array(
										$email_strings_account_approved['subject'],
										$email_strings_account_approved['body'],
										'<p>'.$email_strings_account_approved['title_memberships'].'</p>',
										$approved_title,
										$approved_list,
										$denied_title,
										$denied_list,
										$email_strings_account_approved['body2'],
										$email_strings_account_approved['body3'],
										BASE_URI
									),
									$this->email_body
								);
		return array(
					'subject' => $email_strings_account_approved['subject'],
					'body' => $this->email_body
				);
	}

	/**
	 * Prepare the body for the "Account denied" e-mail.
	 */
	function email_account_deny($username,$name)
	{
		global $email_strings_account_denied;
		$this->email_body = $this->email_prepare_body('client_deny');
		$this->email_body = str_replace(
									array('%SUBJECT%','%BODY1%','%BODY2%'),
									array(
										$email_strings_account_denied['subject'],
										$email_strings_account_denied['body'],
										$email_strings_account_denied['body2'],
									),
									$this->email_body
								);
		return array(
					'subject' => $email_strings_account_denied['subject'],
					'body' => $this->email_body
				);
	}

	/**
	 * Prepare the body for the "New User" e-mail.
	 * The new username and password are also sent.
	 */
	function email_new_user($username,$password)
	{
		global $email_strings_new_user;
		$this->email_body = $this->email_prepare_body('new_user');
		$this->email_body = str_replace(
									array('%SUBJECT%','%BODY1%','%BODY2%','%BODY3%','%LBLUSER%','%LBLPASS%','%USERNAME%','%PASSWORD%','%URI%'),
									array(
										$email_strings_new_user['subject'],
										$email_strings_new_user['body'],
										$email_strings_new_user['body2'],
										$email_strings_new_user['body3'],
										$email_strings_new_user['label_user'],
										$email_strings_new_user['label_pass'],
										$username,
										$password,
										BASE_URI
									),
									$this->email_body
								);
		return array(
					'subject' => $email_strings_new_user['subject'],
					'body' => $this->email_body
				);
	}

	/**
	 * Prepare the body for the "New files for client" e-mail and replace the
	 * tags with the strings values set at the top of this file and the
	 * link to the log in page.
	 */
	function email_new_files_for_client($files_list)
	{
		global $email_strings_file_by_user;
		$this->email_body = $this->email_prepare_body('new_file_by_user');
		$this->email_body = str_replace(
									array('%SUBJECT%','%BODY1%','%FILES%','%BODY2%','%BODY3%','%BODY4%','%URI%'),
									array(
										$email_strings_file_by_user['subject'],
										$email_strings_file_by_user['body'],
										$files_list,
										$email_strings_file_by_user['body2'],
										$email_strings_file_by_user['body3'],
										$email_strings_file_by_user['body4'],
										BASE_URI
									),
									$this->email_body
								);
		return array(
					'subject' => $email_strings_file_by_user['subject'],
					'body' => $this->email_body
				);
	}

	/**
	 * Prepare the body for the "New files by client" e-mail and replace the
	 * tags with the strings values set at the top of this file and the
	 * link to the log in page.
	 */
	function email_new_files_by_client($files_list)
	{
		global $email_strings_file_by_client;
		$this->email_body = $this->email_prepare_body('new_file_by_client');
		$this->email_body = str_replace(
									array('%SUBJECT%','%BODY1%','%FILES%','%BODY2%','%BODY3%','%URI%'),
									array(
										$email_strings_file_by_client['subject'],
										$email_strings_file_by_client['body'],
										$files_list,
										$email_strings_file_by_client['body2'],
										$email_strings_file_by_client['body3'],
										BASE_URI
									),
									$this->email_body
								);
		return array(
					'subject' => $email_strings_file_by_client['subject'],
					'body' => $this->email_body
				);
	}

	/**
	 * Prepare the body for the "Password reset" e-mail and replace the
	 * tags with the strings values set at the top of this file and the
	 * link to the log in page.
	 */
	function email_password_reset($username, $token)
	{
		global $email_strings_pass_reset;
		$this->email_body = $this->email_prepare_body('password_reset');
		$this->email_body = str_replace(
									array('%SUBJECT%','%BODY1%','%BODY2%','%BODY3%','%BODY4%','%LBLUSER%','%USERNAME%','%URI%'),
									array(
										$email_strings_pass_reset['subject'],
										$email_strings_pass_reset['body'],
										$email_strings_pass_reset['body2'],
										$email_strings_pass_reset['body3'],
										$email_strings_pass_reset['body4'],
										$email_strings_pass_reset['label_user'],
										$username,
										BASE_URI.'reset-password.php?token=' . $token . '&user=' . $username,
									),
									$this->email_body
								);
		return array(
					'subject' => $email_strings_pass_reset['subject'],
					'body' => $this->email_body
				);
	}

	/**
	 * Prepare the body for the e-mail sent when a client changes group
	 *  membeship requests.
	 */
	function email_client_edited($username,$fullname,$memberships_requests)
	{
		global $email_strings_client_edited;
		$this->email_body = $this->email_prepare_body('client_edited');
		$this->email_body = str_replace(
									array('%SUBJECT%','%BODY1%','%BODY2%','%LBLNAME%','%LBLUSER%','%FULLNAME%','%USERNAME%','%URI%'),
									array(
										$email_strings_client_edited['subject'],
										$email_strings_client_edited['body'],
										$email_strings_client_edited['body2'],
										$email_strings_client_edited['label_name'],
										$email_strings_client_edited['label_user'],
										$fullname,$username,BASE_URI
										),
									$this->email_body
								);
		if ( !empty( $memberships_requests ) ) {
			$this->groups		= new GroupActions;
			$this->groups_args	= array(
										'group_ids' => $memberships_requests
									);
			$this->get_groups = $this->groups->get_groups( $this->groups_args );

			$this->groups_list = '<ul>';
			foreach ( $this->get_groups as $group ) {
				$this->groups_list .= '<li>' . $group['name'] . '</li>';
			}
			$this->groups_list .= '</ul>';

			$memberships_requests = implode(',',$memberships_requests);
			$this->email_body = str_replace(
									array('%LABEL_REQUESTS%', '%GROUPS_REQUESTS%'),
									array(
										$email_strings_client_edited['label_request'],
										$this->groups_list
									),
								$this->email_body
							);
		}
		return array(
					'subject' => $email_strings_client_edited['subject'],
					'body' => $this->email_body
				);
	}


	/**
	 * Finally, try to send the e-mail and return a status, where
	 * 1 = Message sent OK
	 * 2 = Error sending the e-mail
	 *
	 * Returns custom values instead of a boolean value to allow more
	 * codes in the future, on new validations and functions.
	 */
	function psend_send_email($arguments)
	{
		/** Generate the values from the arguments */
		$this->preview		= (!empty($arguments['preview'])) ? $arguments['preview'] : false;
		$this->type			= $arguments['type'];
		$this->addresses	= (!empty($arguments['address'])) ? $arguments['address'] : '';
		$this->username		= (!empty($arguments['username'])) ? $arguments['username'] : '';
		$this->password		= (!empty($arguments['password'])) ? $arguments['password'] : '';
		$this->client_id	= (!empty($arguments['client_id'])) ? $arguments['client_id'] : '';
		$this->name			= (!empty($arguments['name'])) ? $arguments['name'] : '';
		$this->files_list	= (!empty($arguments['files_list'])) ? $arguments['files_list'] : '';
		$this->token		= (!empty($arguments['token'])) ? $arguments['token'] : '';
		$this->memberships	= (!empty($arguments['memberships'])) ? $arguments['memberships'] : '';

		require_once(ROOT_DIR.'/includes/phpmailer/class.phpmailer.php');

		if (!spl_autoload_functions() OR (!in_array('PHPMailerAutoload', spl_autoload_functions()))) {
			require_once(ROOT_DIR.'/includes/phpmailer/PHPMailerAutoload.php');
		}

		$this->try_bcc = false;
		switch($this->type) {
			case 'new_files_for_client':
				$this->mail_info = $this->email_new_files_for_client($this->files_list);
				if (COPY_MAIL_ON_USER_UPLOADS == '1') {
					$this->try_bcc = true;
				}
			break;
			case 'new_file_by_client':
				$this->mail_info = $this->email_new_files_by_client($this->files_list);
				if (COPY_MAIL_ON_CLIENT_UPLOADS == '1') {
					$this->try_bcc = true;
				}
			break;
			case 'new_client':
				$this->mail_info = $this->email_new_client($this->username,$this->password);
			break;
			case 'new_client_self':
				$this->mail_info = $this->email_new_client_self($this->username,$this->name,$this->memberships);
			break;
			case 'client_approve':
				$this->mail_info = $this->email_account_approve($this->username,$this->name,$this->memberships);
			break;
			case 'client_deny':
				$this->mail_info = $this->email_account_deny($this->username,$this->name);
			break;
			case 'new_user':
				$this->mail_info = $this->email_new_user($this->username,$this->password);
			break;
			case 'password_reset':
				$this->mail_info = $this->email_password_reset($this->username,$this->token);
			break;
			case 'client_edited':
				$this->mail_info = $this->email_client_edited($this->username,$this->name,$this->memberships);
			break;
		}

		/**
		 * Replace the default info on the footer
		 */
		$this->mail_info['body'] = str_replace(
									array(
										'%FOOTER_SYSTEM_URI%',
										'%FOOTER_URI%'
									),
									array(
										SYSTEM_URI,
										BASE_URI
									),
									$this->mail_info['body']
								);

		/**
		 * If we are generating a preview, just return the html content
		 */
		if ( $this->preview == true ) {
			return $this->mail_info['body'];
		}
		else {

			/**
			 * phpMailer
			 */
			$this->send_mail = new PHPMailer();
			switch (MAIL_SYSTEM) {
				case 'smtp':
						$this->send_mail->IsSMTP();
						$this->send_mail->Host = SMTP_HOST;
						$this->send_mail->Port = SMTP_PORT;
						$this->send_mail->Username = SMTP_USER;
						$this->send_mail->Password = SMTP_PASS;

						if ( defined('SMTP_AUTH') && SMTP_AUTH != 'none' ) {
							$this->send_mail->SMTPAuth = true;
							$this->send_mail->SMTPSecure = SMTP_AUTH;
						}
						else {
							$this->send_mail->SMTPAuth = false;
						}
					break;
				case 'gmail':
						$this->send_mail->IsSMTP();
						$this->send_mail->SMTPAuth = true;
						$this->send_mail->SMTPSecure = "tls";
						$this->send_mail->Host = 'smtp.gmail.com';
						$this->send_mail->Port = 587;
						$this->send_mail->Username = SMTP_USER;
						$this->send_mail->Password = SMTP_PASS;
					break;
				case 'sendmail':
						$this->send_mail->IsSendmail();
					break;
			}

			$this->send_mail->CharSet = EMAIL_ENCODING;

			$this->send_mail->Subject = $this->mail_info['subject'];
			$this->send_mail->MsgHTML($this->mail_info['body']);
			$this->send_mail->AltBody = __('This email contains HTML formatting and cannot be displayed right now. Please use an HTML compatible reader.','cftp_admin');

			$this->send_mail->SetFrom(ADMIN_EMAIL_ADDRESS, MAIL_FROM_NAME);
			$this->send_mail->AddReplyTo(ADMIN_EMAIL_ADDRESS, MAIL_FROM_NAME);

			$this->send_mail->AddAddress($this->addresses);

			/**
			 * Check if BCC is enabled and get the list of
			 * addresses to add, based on the email type.
			 */
			if ($this->try_bcc === true) {
				$this->add_bcc_to = array();
				if (COPY_MAIL_MAIN_USER == '1') {
					$this->add_bcc_to[] = ADMIN_EMAIL_ADDRESS;
				}
				$this->more_addresses = COPY_MAIL_ADDRESSES;
				if (!empty($this->more_addresses)) {
					$this->more_addresses = explode(',',$this->more_addresses);
					foreach ($this->more_addresses as $this->add_bcc) {
						$this->add_bcc_to[] = $this->add_bcc;
					}
				}
				/**
				 * Add the BCCs with the compiled array.
				 * First, clean the array to make sure the admin
				 * address is not written twice.
				 */
				if (!empty($this->add_bcc_to)) {
					$this->add_bcc_to = array_unique($this->add_bcc_to);
					foreach ($this->add_bcc_to as $this->set_bcc) {
						$this->send_mail->AddBCC($this->set_bcc);
					}
				}

			}
			
			/** Debug by echoing the email on page */
			//echo $this->mail_info['body'];
			//die();

			/**
			 * Finally, send the e-mail.
			 */
			if($this->send_mail->Send()) {
				return 1;
			}
			else {
				return 2;
			}
		}
	}
}
