<?php
namespace Acelaya\Controller;

class UsersController extends AbstractRestfulController
{
    public function get($id)
    {
        return [
            'user' => [
                'id' => (int) $id,
                'username' => 'jochem',
                'name' => 'Jochem Hilaire'
            ],

            // More staff
        ];
    }

    public function getList()
    {
        return [
            'users' => [
                [
                    'id' => 1,
                    'username' => 'jochem',
                    'name' => 'Jochem Hilaire'
                ], [
                    'id' => 2,
                    'username' => 'enu',
                    'name' => 'Enu Kwesi'
                ], [
                    'id' => 3,
                    'username' => 'desiderio',
                    'name' => 'Desiderio Faraji'
                ],
            ],

            // More staff
        ];
    }

    public function create(array $data)
    {
        return [
            'message' => 'User created!'
        ];
    }

    public function update($id, array $data)
    {
        return [
            'message' => sprintf('User with ID "%s" update!', $id)
        ];
    }

    public function delete($id)
    {
        return [
            'message' => sprintf('User with ID "%s" deleted!', $id)
        ];
    }
}
