<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Entity\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\ReviewForm;
use Application\Form\UserForm;
use Application\Entity\Review;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{
    protected $em;

    public function indexAction()
    {
        return new ViewModel(array(
            'reviews' => $this->getEntityManager()->getRepository('Application\Entity\Review')->findAll()
        ));
    }
    public function reviewAction()
    {

    }
    public function fromuserAction()
    {
        $id = $this->params()->fromRoute('id');
        if($id)
        {
            return new ViewModel(array(
                'reviews' => $this->getEntityManager()->getRepository('Application\Entity\Review')->findBy(array(
                    'userId' => $id)
                )
            ));
        }
    }
    public function addUserAction()
    {
        $session = new Container('authent');
        $form = new UserForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {

            $userFilter = new User();
            $form->setInputFilter($userFilter->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $userId = $request->getPost();
                $user = $this->getEntityManager()->getRepository('Application\Entity\User')->findBy(array(
                        'userId' => $userId['userId'])
                );

                if(!$user)
                {
                    $user = new User();
                    $user->populate($form->getData());
                    $this->getEntityManager()->persist($user);
                    $this->getEntityManager()->flush();
                    $session = new Container('authent');
                    $_SESSION['user'] = $user->getUserId();

                    return $this->redirect()->toRoute('home');
                }

                $user[0]->populate($form->getData());
                $this->getEntityManager()->flush();
                $this->getEntityManager()->merge($user[0]);

                $_SESSION['user'] = $user[0]->getUserId();

                return $this->redirect()->toRoute('home');
            }
        }
        return array('form' => $form);
    }
    public function addReviewAction()
    {
        $session = new Container('authent');

        if($this->checkLogedIn())
        {
            $form = new ReviewForm();
            $form->get('submit')->setValue('Add');

            $request = $this->getRequest();
            if ($request->isPost()) {
                $review = new Review();

                $form->setInputFilter($review->getInputFilter());
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    $review->populate($form->getData());
                    $this->getEntityManager()->persist($review);
                    $this->getEntityManager()->flush();

                    // Redirect to list of albums
                    return $this->redirect()->toRoute('home');
                }
            }
            return array('form' => $form);
        }

        return array('message' => 'You have to log in with facebook to write new review');
    }

    public function logoutAction()
    {
        $session = new Container('authent');
        if($this->getRequest()->isPost())
        {
            unset($_SESSION['user']);
        }

    }

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function checkLogedIn()
    {
        $user = $this->getEntityManager()->getRepository('Application\Entity\User')->findBy(array(
                'userId' => $_SESSION['user'])
        );
        if($user)
        {
            return true;
        }else
        {
            return false;
        }
    }

}
