<?php

namespace MacsiDigital\Zoom;

use Exception;
use MacsiDigital\Zoom\Support\Model;
use MacsiDigital\Zoom\Support\Response;

class Group extends Model
{
    public const ENDPOINT = 'groups';
    public const NODE_NAME = 'group';
    public const KEY_FIELD = 'id';

    protected $methods = ['get', 'post', 'patch', 'put', 'delete'];

    protected $attributes = [
        'name' => '', //string
        'id' => '',
    ];

    protected $createAttributes = [
        'name',
    ];

    protected $updateAttributes = [
        'name',
    ];

    /** @var Response */
    public $response;

    public function save()
    {
        $idField = self::GetKey();
        if ($this->hasID()) {
            if (in_array('put', $this->methods, true)) {
                $this->response = $this->client->patch(self::getEndpoint() . '/' . $this->id, $this->updateAttributes());
                if ($this->response->getStatusCode() === '204') {
                    return $this->response->getContents();
                }

                throw new Exception($this->response->getStatusCode() . ' status code');
            }
        } elseif (in_array('post', $this->methods, true)) {
            $this->response = $this->client->post(self::getEndpoint(), $this->createAttributes());
            if ($this->response->getStatusCode() === '201') {
                $result = $this->collect($this->response->getContents())->first();
                $this->{$idField} = $result->{$idField};

                return $this->response->getContents();
            }

            throw new Exception($this->response->getStatusCode() . ' status code');
        }
    }

    /**
     * @param User[] $users
     *
     * @throws Exception
     */
    public function addMembers(array $users): void
    {
        if (!$this->hasID()) {
            throw new Exception('can\'t add members to group without id(probably need save group before)');
        }

        $userIds = array_map(function (User $user) {
            return $user->getID();
        }, $users);

        $this->response = $this->client->post(self::getEndpoint() . '/' . $this->getID() . '/members', $userIds);

        if ($this->response->getStatusCode() === '201') {
            return $this->response->getContents();
        }

        throw new Exception($this->response->getStatusCode() . ' status code');
    }
}
