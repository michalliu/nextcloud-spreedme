<?php
/**
 * ownCloud - spreedwebrtc
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Leon <leon@struktur.de>
 * @copyright Leon 2015
 */

namespace OCA\SpreedWebRTC\Controller;

use OCA\SpreedWebRTC\Config\Config;
use OCA\SpreedWebRTC\Helper\Helper;
use OCA\SpreedWebRTC\User\User;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class ApiController extends Controller {

	private $user;

	public function __construct($appName, IRequest $request, $userId) {
		parent::__construct($appName, $request);
		if (!empty($userId)) {
			$this->user = new User($userId);
		} else {
			$this->user = new User();
		}
	}

	/**
	 * @NoAdminRequired
	 */
	public function getUserConfig() {
		$_response = array('success' => false);
		try {
			$_response = array_merge($_response, $this->user->getInfo());
			$_response['success'] = true;
		} catch (\Exception $e) {
			$_response['error'] = $e->getCode();
		}

		return new DataResponse($_response);
	}

	/**
	 * @NoAdminRequired
	 */
	public function getLogin() {
		$_response = array('success' => false);
		try {
			$_response = array_merge($_response, $this->user->getSignedCombo());
			$_response['success'] = true;
		} catch (\Exception $e) {
			$_response['error'] = $e->getCode();
		}

		return new DataResponse($_response);
	}

	/**
	 * @NoAdminRequired
	 */
	public function downloadFile() {
		// TODO(leon): Make this RESTy
		$url = '/remote.php/webdav/' . urldecode($_GET['file']);

		return new \OCP\AppFramework\Http\RedirectResponse($url);
	}

}
