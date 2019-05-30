<?php
/**
 * This file is part of the Passwords App
 * created by Marius David Wieschollek
 * and licensed under the AGPL.
 */

namespace OCA\Passwords\Controller\Api;

use OCA\Passwords\Db\Keychain;
use OCA\Passwords\Exception\ApiException;
use OCA\Passwords\Services\Object\KeychainService;
use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;

/**
 * Class KeychainApiController
 *
 * @package OCA\Passwords\Controller\Api
 */
class KeychainApiController extends AbstractApiController {

    /**
     * @var KeychainService
     */
    protected $keychainService;

    /**
     * KeychainApiController constructor.
     *
     * @param IRequest        $request
     * @param KeychainService $keychainService
     */
    public function __construct(IRequest $request, KeychainService $keychainService) {
        parent::__construct($request);
        $this->keychainService = $keychainService;
    }

    /**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
     *
     * @return JSONResponse
     * @throws \Exception
     */
    public function list(): JSONResponse {
        $results = $this->keychainService->getClientKeychainArray();

        return $this->createJsonResponse($results);
    }

    /**
     * @CORS
     * @NoCSRFRequired
     * @NoAdminRequired
     *
     * @param string $id
     * @param string $data
     *
     * @return JSONResponse
     * @throws ApiException
     * @throws MultipleObjectsReturnedException
     * @throws \Exception
     */
    public function update(string $id, string $data): JSONResponse {
        try {
            $keychain = $this->keychainService->findByType($id, true);

            if($keychain->getScope() !== $keychain::SCOPE_CLIENT) {
                throw new ApiException('Keychain not found', 404);
            }

            $keychain->setData($data);
        } catch(DoesNotExistException $e) {
            $keychain = $this->keychainService->create($id, $data, Keychain::SCOPE_CLIENT);
        }

        $this->keychainService->save($keychain);

        return $this->createJsonResponse(['id' => $keychain->getType()]);
    }
}