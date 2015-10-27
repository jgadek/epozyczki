<?php

namespace App\ApiBundle\Controller;

use App\ApiBundle\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use App\GuardBundle\Entity\GuardUser;
use Acme\Utils\Cleaner;

class UserController extends ApiController
{

    /**
     * The method returns a collection of users
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get users",
     *  requirements={
     *      { "name"="api_key", "dataType"="string", "requirement"=".+", "description"="Api key" },
     *      { "name"="_format", "dataType"="string", "requirement"="xml|json", "description"="Returned data format" },
     *  },
     *  parameters={
     *      { "name"="limit", "dataType"="integer", "required"="true", "format"="\d+", "description"="Limit of users (default 10)" },
     *      { "name"="page", "dataType"="integer", "required"="true", "format"="\d+", "description"="Page (default 1)" },
     *  },
     *  filters={
     *      { "name"="id", "dataType"="integer", "description"="Filter by ID" },
     *      { "name"="username", "dataType"="string", "description"="Filter by Username" },
     *      { "name"="email", "dataType"="string", "description"="Filter by Email" },
     *      { "name"="count", "dataType"="boolean", "description"="Get number of users" },
     *      { "name"="orderBy", "dataType"="string", "pattern"="(id|username|email) ASC|DESC", "description"="Sort by parameter (default id ASC)" },
     *  },
     * )
     */
    public function getUsersAction(Request $request)
    {
        if (!$this->getApiEvent()->isHttpStatus(Response::HTTP_OK)) {
            return $this->send();
        }
        $page = $request->get('page');
        $limit = $request->get('limit');
        $arrFilter = array(
            'id' => $request->get('id'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'count' => $request->get('count'),
        );
        $orderBy = $request->get('orderBy');

        $m = $this->getDoctrine()->getManager();

        $m->getRepository('AppGuardBundle:GuardUser');

        $this->setData($m->getRepository('AppGuardBundle:GuardUser')->getData($arrFilter, $orderBy, $page, $limit));
        return $this->send();
    }

    /**
     * The method return a object of user by ID
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get user",
     *  requirements={
     *      { "name"="api_key", "dataType"="string", "requirement"=".+", "description"="Api key" },
     *      { "name"="id", "dataType"="integer", "requirement"="\d+", "description"="User ID" },
     *      { "name"="_format", "dataType"="string", "requirement"="xml|json", "description"="Returned data format" },
     *  },
     * )
     */
    public function getUserAction(Request $request, $id)
    {
        if (!$this->getApiEvent()->isHttpStatus(Response::HTTP_OK)) {
            return $this->send();
        }
        $objGuardUser = $this->getDoctrine()->getManager()->getRepository('AppGuardBundle:GuardUser')->find($id);
        if (!($objGuardUser instanceof GuardUser)) {
            $this->setData(array(
                'error' => 'User not exists'
            ));
            $this->setHttpStatus(Response::HTTP_NOT_FOUND);
        } else {
            $this->setData($objGuardUser);
        }
        return $this->send();
    }

    /**
     * 
     * The method to delete user
     * 
     * @ApiDoc(
     *  resource=true,
     *  description="Delete user",
     *  requirements={ 
     *      { "name"="api_key", "dataType"="string", "requirement"=".+", "description"="Api key" },
     *      { "name"="id", "dataType"="integer", "requirement"="\d+", "description"="User ID" },
     *      { "name"="_format", "dataType"="string", "requirement"="xml|json", "description"="Returned data format" },
     *  },
     * )
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param integer $id
     * @return type
     */
    public function deleteUserAction(Request $request, $id)
    {
        if (!$this->getApiEvent()->isHttpStatus(Response::HTTP_OK)) {
            return $this->send();
        }
        $m = $this->getDoctrine()->getManager();
        $objGuardUser = $m->getRepository('AppGuardBundle:GuardUser')->find($id);
        if (!($objGuardUser instanceof GuardUser)) {
            $this->setData(array(
                'error' => 'User not exists'
            ));
            $this->setHttpStatus(Response::HTTP_NOT_FOUND);
            return $this->send();
        }

        $objGuardUser->remove();
        $m->remove($objGuardUser);
        $m->flush();
        $this->setHttpStatus(Response::HTTP_NO_CONTENT);
        return $this->send();
    }

    /**
     * The method to update user
     * 
     * @ApiDoc(
     *  resource=true,
     *  description="Update user",
     *  requirements={ 
     *      { "name"="api_key", "dataType"="string", "requirement"=".+", "description"="Api key" },
     *      { "name"="id", "dataType"="integer", "requirement"="\d+", "description"="User ID" },
     *      { "name"="_format", "dataType"="string", "requirement"="xml|json", "description"="Returned data format" },
     *  },
     *  parameters={
     *      { "name"="username", "dataType"="integer", "required"="false", "format"=".+", "description"="Set username" },
     *  },
     * )
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param integer $id
     */
    public function patchUserAction(Request $request, $id)
    {
        if (!$this->getApiEvent()->isHttpStatus(Response::HTTP_OK)) {
            return $this->send();
        }
        return $this->send();
    }

    /**
     * The method to create user
     * 
     * @ApiDoc(
     *  description="Create new user",
     *  requirements={
     *      { "name"="api_key", "dataType"="string", "requirement"=".+", "description"="Api key" },
     *      { "name"="username", "dataType"="string", "requirement"=".+", "description"="Username" },
     *      { "name"="email", "dataType"="string", "requirement"="email parser", "description"="Email" },
     *      { "name"="password", "dataType"="string", "requirement"="password parser", "description"="Password" },
     *      { "name"="roles", "dataType"="array", "requirement"="array", "description"="Roles" },
     *      { "name"="_format", "dataType"="string", "requirement"="xml|json", "description"="Returned data format" },
     *  },
     * )
     */
    public function postUserAction(Request $request)
    {
        if (!$this->getApiEvent()->isHttpStatus(Response::HTTP_OK)) {
            return $this->send();
        }
        $username = Cleaner::String($request->get('username'));
        $email = Cleaner::String($request->get('email'));
        $plainPassword = Cleaner::String($request->get('password'));
        $roles = $request->get('roles');
        if (!$username || !$email || !$plainPassword) {
            $this->setHttpStatus(Response::HTTP_BAD_REQUEST);
            $this->setData(array(
                'Bad data' => 'Please send username, email and password'
            ));
        }
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        
        /* @var $guardUser GuardUser */
        $guardUser = $userManager->createUser();
        $guardUser->setEnabled(false);

        $guardUser
                ->setUsername($username)
                ->setEmail($email)
                ->setPlainPassword($plainPassword)
        ;
        foreach ($roles as $role) {
            $guardUser->addRole($role);
        }

        if (!$guardUser->isValid($this->getDoctrine()->getManager())) {
            $this->setData($guardUser->getErrors());
            $this->setHttpStatus(Response::HTTP_NOT_FOUND);
            return $this->send();
        }


        $userManager->updateUser($guardUser);
        $this->setHttpStatus(Response::HTTP_CREATED);
        return $this->send();
    }

    /**
     * @Post("/login")
     */
    public function postLoginAction(Request $request)
    {
        if (!$this->getApiEvent()->isHttpStatus(Response::HTTP_OK)) {
            return $this->send();
        }
        return $this->send();
    }

}
