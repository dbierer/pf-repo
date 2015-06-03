<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\PhpEnvironment\Response;
use Doctrine\Common\Util\Debug;
use Application\Listeners\DoctrineListener;

class IndexController extends AbstractActionController
{
    
    const SOME_EVENT = 'some.event';
    
    protected $formAnnotation;
    protected $formFieldset;
    protected $customerEntity;
    protected $repo;
    protected $service;
                
    public function indexAction()
    {
        $leftView = new ViewModel(array('test' => 'LEFT TEST'));
        $leftView->setTemplate('application/index/left');
        $topView  = new ViewModel(array('test' => 'TOP TEST'));
        $topView->setTemplate('application/index/top');
        $mainView = new ViewModel(array('test' => 'MAIN'));
        $mainView->addChild($topView, 'top'); 
        $mainView->addChild($leftView, 'left'); 
        $mainView->setTemplate('application/index/main');
        return $mainView;
    }

    public function formAnnotationAction()
    {
        $data = 'No Data';
        $this->formAnnotation->setAttribute('method', 'post');
        $this->formAnnotation->bind($this->customerEntity);
        if ($this->getRequest()->isPost()) {
            $this->formAnnotation->setData($this->params()->fromPost());
            $this->formAnnotation->isValid();
            $customer = $this->formAnnotation->getData();
            // this is needed because form fieldset data is not coming back as entities
            $customer = $this->repo->hydrateProfile($this->repo->hydratePurchases($customer));
            $data = Debug::dump($customer, 3, FALSE, FALSE);
            $this->repo->getEntityManager()->persist($customer);
            $this->repo->getEntityManager()->flush();
        }
        $viewModel = new ViewModel(array('form' => $this->formAnnotation, 'data' => $data));
        return $viewModel;
    }

    public function formFieldsetAction()
    {
        $data = '';
        $this->formFieldset->bind($this->customerEntity);
        if ($this->getRequest()->isPost()) {
            phpinfo(INFO_VARIABLES);
            $this->formFieldset->isValid();
            $data = Debug::dump($this->formFieldset->getData(), 3, FALSE, FALSE);
        }
        $viewModel = new ViewModel(array('form' => $this->formFieldset, 'dump' => $data));
        return $viewModel;
    }

    public function listenerTestAction()
    {
        $output = '';
        $custId = $this->params()->fromPost('custId') ?: 0;
        if ($custId) {
            $customer = $this->repo->find($custId);
            if ($customer) {
                $output = $this->service->showCustInfo($customer, 'Customer Info');
            }
        }
        $form = $this->service->selectForm($this->repo->findAll(), $custId);
        $viewModel = new ViewModel(array('output' => $output, 'form' => $form));
        $viewModel->setTemplate('application/index/listener-test');
        return $viewModel;
    }
    
    public function getTest()
    {
        return $this->test;
    }

    public function setTest($test)
    {
        $this->test = $test;
    }

    public function getFormAnnotation()
    {
        return $this->formAnnotation;
    }

    public function setFormAnnotation($formAnnotation)
    {
        $this->formAnnotation = $formAnnotation;
    }
    
    public function getCustomerEntity()
    {
        return $this->customerEntity;
    }

    public function setCustomerEntity($customerEntity)
    {
        $this->customerEntity = $customerEntity;
    }
    
    public function getFormFieldset()
    {
        return $this->formFieldset;
    }

    public function setFormFieldset($formFieldset)
    {
        $this->formFieldset = $formFieldset;
    }
    
    public function getRepo()
    {
        return $this->repo;
    }

    public function setRepo($repo)
    {
        $this->repo = $repo;
    }
    
    public function getService()
    {
        return $this->service;
    }

    public function setService($service)
    {
        $this->service = $service;
    }
    
}
