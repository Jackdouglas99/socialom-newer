<?php

	namespace App\Support\Helpers;

	use Session;

	/**
	 * Created by PhpStorm.
	 * User: sam
	 * Date: 31/05/17
	 * Time: 17:55
	 */
	class NotificationDisplay
	{
		/**
		 * This will prepare all notifications in the session to be rendered
		 */
		public static function displayNotifications()
		{
			$types = ['error', 'info', 'success', 'warning'];
			foreach ($types as $type) {
				if (Session::has($type)) {
					self::renderNotification($type, Session::get($type));
				}
			}
		}

		/**
		 * We wanted to call the "danger" notification type "error" instead.
		 * Could be useful in future cases also.
		 *
		 * @param $type
		 *
		 * @return string
		 */
		public static function changeNotificationType($type)
		{
			switch ($type) {
				case "error":
					return "danger";
				default:
					return $type;
			}
		}

		/**
		 * The "error" notifications title is displayed as "Danger" we use this to convert it back
		 *
		 * @param $type
		 *
		 * @return string
		 */
		public static function changeTitleType($type)
		{
			switch ($type) {
				case "danger":
					return "error";
				default:
					return $type;
			}
		}

		/**
		 * Actually renders the notification message.
		 *
		 * @param $type
		 * @param $message
		 */
		public static function renderNotification($type, $message)
		{
			/*echo '<div class="alert alert-' . self::changeNotificationType($type) . ' alert-dismissable">' .
				'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' .
				'<strong>' . ucfirst(self::changeTitleType($type)) . '</strong> ' .
				$message .
				'</div>';*/
			echo '<script>toastr.'.$type.'("'.$message.'");</script>';
		}

	}


	/**
	 * HOW TO USE IT
	 * Put the snippet below, where ever you want your alerts to be displayed.
	 * You need to place the gist into a folder in App\Support\Helpers for this exact peice to work.
	 */

	/*{!! App\Support\Helpers\NotificationDisplay::displayNotifications() !!}*/


