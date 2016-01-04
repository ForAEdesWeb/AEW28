<?php

namespace Aedes\AedewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class WebAdminController extends \Aedes\AedewBundle\Controller\FileController
{
    public function loginAction()
    {
        $form = $this->createFormBuilder()
                     ->add('username', 'text')
                     ->add('password', 'password')
                     ->getForm();

        $formView = $this->render('AedesAedewBundle:Admin:form.html.twig',
                                  array('form' => $form->createView(), "admin" => true));

        $request = $this->getRequest();

        if($request->getMethod() !== 'POST')
            return $formView;

        $form->bindRequest($request);

        if(!$form->isValid())
            return $formView;

        $post = $request->request->get("form");

        try {
            $this->login($post['username'], $post['password']);
        } catch (\Exception $exc) {
            return $this->redirect($this->generateUrl('error',
                                   array("error" => $exc->getMessage(),
                                         "sendTo" => "login")));
        }

        return $this->redirect($this->generateUrl('success'));
    }

    public function menuAction($id)
    {
        try {
            $acc = $this->login();
        } catch (\Exception $exc) {
            return $this->redirect($this->generateUrl('login', array()));
        }

        try {
            return $this->getWeb($acc, $id, true);
        } catch (\Exception $exc) {
            return $this->redirect($this->generateUrl('userSetAcc', array()));
        }
    }

    /**
     * symfony 產生的表單 不能而外改名稱 不然 input name 會跳掉
     * 所以請用 js 在 view 讀取改成中文 就不會影響到 input
     */
    public function setAccAction()
    {
        try {
            $acc = $this->login();
        } catch (\Exception $exc) {
            return $this->redirect($this->generateUrl('login', array()));
        }

        $em = $this->getDoctrine()->getEntityManager();

        $form = $this->createFormBuilder($acc)
                     ->add('company',     'text')
                     ->add('subject',     'text')
                     ->add('phone',       'text')
                     ->add('address',     'text')
                     ->add('logo',        'textarea')
                     ->add('footer',      'textarea')
                     ->add('defaultFile', 'choice', array('choices' => $this->canDefaultArray($acc)))
                     ->add('style',       'text')
                     ->add('mobileStyle', 'text')
                     ->getForm();

        $formView = $this->render('AedesAedewBundle:Admin:form.html.twig',
                                  array('form' => $form->createView(), "admin" => true));

        $request = $this->getRequest();

        if($request->getMethod() !== 'POST')
            return $formView;

        $form->bindRequest($request);

        if(!$form->isValid())
            return $formView;

        $post = $request->request->get("form");

        try {
            $acc->setCompany($post['company']);
            $acc->setSubject($post['subject']);
            $acc->setPhone($post['phone']);
            $acc->setAddress($post['address']);
            $acc->setLogo($post['logo']);
            $acc->setFooter($post['footer']);
            $acc->setDefaultFile($post['defaultFile']);
            $acc->setStyle($post['style']);
            $acc->setMobileStyle($post['mobileStyle']);

            $em->flush();
        } catch (\Exception $exc) {
            return $this->redirect($this->generateUrl('error',
                                   array("error" => $exc->getMessage(),
                                         "sendTo" => "userSetAcc")));
        }

        return $this->redirect($this->generateUrl('success'));
    }

    public function newFileAction()
    {
        return $this->setFilePage("new");
    }

    public function setFileAction($id)
    {
        return $this->setFilePage($id);
    }

    public function setFilePage($id)
    {
        try {
            $acc = $this->login();
        } catch (\Exception $exc) {
            return $this->redirect($this->generateUrl('login', array()));
        }

        try {
            $file = new \Aedes\AedewBundle\Entity\File();

            if("new" != $id)
                $file = $this->findPage($acc, $id);

        } catch (\Exception $exc) {
            return $this->redirect($this->generateUrl('error',
                                   array("error" => $exc->getMessage(),
                                         "sendTo" => "menu")));
        }

        $em = $this->getDoctrine()->getEntityManager();

        $form = $this->createFormBuilder($file)
                     ->add('title',   'text')
                     ->add('type',    'choice',
                           array('choices' => array("file" => "頁面",
                                                    "dir"  => "資料夾",
                                                    "img"  => "主圖片",
                                                    "msg"  => "聯絡頁面",
                                                    "map"  => "地圖",
                                                    "qr"   => "QR code")
                                ))
                     ->add('parent',  'choice', array('choices' => $this->parentArray($acc)))
                     ->add('sort',    'integer')
                     ->add('subject', 'textarea')
                     ->add('content', 'textarea')
                     ->add('css',     'textarea')
                     ->add('style',       'text')
                     ->add('shareButton',     'choice', array('choices' => array("1" => "on", "0" => "off")))
                     ->add('facebookComment', 'choice', array('choices' => array("1" => "on", "0" => "off")))
                     ->add('isHideContact', 'choice', array('choices' => array("1" => "on", "0" => "off")));


        for($sum = 0; $sum < 16; $sum++)
        {
            $form = $form->add('colorTitle' . $sum, 'text', array("required" => false, "data" => "off"))
                         ->add('colorContent' . $sum, 'textarea', array("data" => ""));
        }

        $form = $form->getForm();


        $formView = $this->render('AedesAedewBundle:Admin:form.html.twig',
                                  array('form' => $form->createView(), "admin" => true));

        $request = $this->getRequest();

        if($request->getMethod() !== 'POST')
            return $formView;

        $form->bindRequest($request);

        if(!$form->isValid())
            return $formView;

        $post = $request->request->get("form");

        try {

            $file->setTitle($post['title']);
            $file->setSubject($post['subject']);
            $file->setContent($post['content']);
            $file->setType($post['type']);
            $file->setParent($post['parent']);
            $file->setSort($post['sort']);
            $file->setCss($post['css']);
            $file->setStyle($post['style']);
            $file->setIsHideContact($post['isHideContact']);
            $file->setShareButton($post['shareButton']);
            $file->setFacebookComment($post['facebookComment']);

            $file->color = array();

            for($sum = 0; $sum < 16; $sum++)
            {
                if("" != $post['colorTitle' . $sum])
                    array_push($file->color, array("rank" => $sum, "title" => $post['colorTitle' . $sum], "content" => $post['colorContent' . $sum]));
            }

            if("new" == $id) {
                $file->setOwn($acc->getId());

                $em->persist($file);
            }

            $em->flush();

        } catch (\Exception $exc) {
            return $this->redirect($this->generateUrl('error',
                                   array("error" => $exc->getMessage(),
                                         "sendTo" => "menu")));
        }

        return $this->redirect($this->generateUrl('success'));
    }

    public function delFileAction($id)
    {
        try {
            $acc = $this->login();
        } catch (\Exception $exc) {
            return $this->redirect($this->generateUrl('login', array()));
        }

        try {
            $file = $this->findPage($acc, $id);
        } catch (\Exception $exc) {
            return $this->redirect($this->generateUrl('error',
                                   array("error" => $exc->getMessage(),
                                         "sendTo" => "menu")));
        }

        $em = $this->getDoctrine()->getEntityManager();

        try {
            $em->remove($file);
            $em->flush();
        } catch (\Exception $exc) {
            return $this->redirect($this->generateUrl('error',
                                   array("error" => $exc->getMessage(),
                                         "sendTo" => "adminMenu")));
        }

        return $this->redirect($this->generateUrl('success'));
    }

    public function errorAction($error, $sendTo)
    {
        return $this->render('AedesAedewBundle:Admin:error.html.twig',
                             array("error" => $error, "sendTo" => $sendTo));
    }

    public function successAction()
    {
        return $this->render('AedesAedewBundle:Admin:complete.html.twig', array());
    }

    public function msgAction($msg, $sendTo)
    {
        return $this->render('AedesAedewBundle:Admin:msg.html.twig', array("msg" => $msg, "sendTo" => $sendTo));
    }

    public function login($username = null, $password = null)
    {
        $session = $this->getRequest()->getSession();

        if(null === $username)
            $username = $session->get("username");

        if(null === $password)
            $password = $session->get("password");

        $em = $this->getDoctrine()->getEntityManager();

        $acc = $em->getRepository("AedesAedewBundle:Acc")
                  ->findOneBy(array("domain"   => $username,
                                    "password" => md5($password)));

        if($acc === null)
            throw new \Exception("acc not found");

        $session->set("username", $username);
        $session->set("password", $password);

        return $acc;
    }

    public function logoutAction()
    {
        $session = $this->getRequest()->getSession();

        $session->set("username", null);
        $session->set("password", null);

        return $this->redirect($this->generateUrl('success'));
    }

    public function parentArray(\Aedes\AedewBundle\Entity\Acc $acc)
    {
        $file = $this->getType($acc, "dir");

        $key = array();
        $val = array();

        $key = array_merge($key, array(0));
        $val = array_merge($val, array("rootDir"));

        foreach ($file as $value) {
            $key = array_merge($key, array($value->getId()));
            $val = array_merge($val, array($value->getTitle()));
        }

        $both = array_combine($key, $val);

        return $both;
    }

    public function canDefaultArray(\Aedes\AedewBundle\Entity\Acc $acc)
    {
        $dir  = $this->getType($acc, "dir");
        $file = $this->getType($acc, "file");
        $msg = $this->getType($acc, "msg");

        $defaultFile = array_merge($dir, $file);
        $defaultFile = array_merge($defaultFile, $msg);

        $key = array();
        $val = array();

        if(array() == $defaultFile)
            return array();

        foreach ($defaultFile as $value) {
            $key = array_merge($key, array($value->getId()));
            $val = array_merge($val, array($value->getTitle()));
        }

        $both = array_combine($key, $val);

        return $both;
    }

    public function viewContactAction()
    {
        try {
            $acc = $this->login();
        } catch (\Exception $exc) {
            return $this->redirect($this->generateUrl('login', array()));
        }

        $em = $this->getDoctrine()->getEntityManager();

        $msg = $em->getRepository("AedesAedewBundle:Msg")
                  ->findBy(array("own" => $acc->getId()), array("id" => "DESC"));

        return $this->render('AedesAedewBundle:Admin:contact.html.twig',
                             array("msg" => $msg, "file" => $this->getType($acc, "file"), "admin" => true));
    }

    public function delContactAction($id)
    {
        try {
            $acc = $this->login();
        } catch (\Exception $exc) {
            return $this->redirect($this->generateUrl('login', array()));
        }

        $em = $this->getDoctrine()->getEntityManager();

        $msg = $em->getRepository("AedesAedewBundle:Msg")
                  ->findOneBy(array("own" => $acc->getId(), "id" => $id));

        try {
            $em->remove($msg);
            $em->flush();

        } catch (\Exception $exc) {
            return $this->redirect($this->generateUrl('error',
                                   array("error" => $exc->getMessage(),
                                         "sendTo" => "viewContact")));
        }

        return $this->redirect($this->generateUrl('msg',
                         array("msg" => "success", "sendTo" => "viewContact")));
    }
}