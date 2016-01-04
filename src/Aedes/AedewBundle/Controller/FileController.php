<?php

namespace Aedes\AedewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FileController extends Controller
{
    /**
     * from web
     */
    public function indexAction($id)
    {
        $acc = $this->findUser();

        return $this->getWeb($acc, $id, false);
    }

    /**
     * @param type $id integer
     */
    public function jsonFileAction($id)
    {
        $acc = $this->findUser();

        $em = $this->getDoctrine()->getEntityManager();

        $file = $em->getRepository("AedesAedewBundle:File")->findBy(array("id" => $id, "own" => $acc->getId()), array("sort"   => "ASC"));

        if(0 === $id)
            $file = $em->getRepository("AedesAedewBundle:File")->findBy(array("own" => $acc->getId()), array("sort"   => "ASC"));

        return $this->render('::base.json.twig', array("data" => $file));
    }

    /**
     * @param type $id integer
     */
    public function jsonAccAction()
    {
        $acc = $this->findUser();

        return $this->render('::base.json.twig', array("data" => $acc));
    }

    /**
     * mobile web
     */
    public function mobileIndexAction($id)
    {
        $acc = $this->findUser();

        return $this->getWeb($acc, $id, false, true);
    }

    /**
     * get the web by setting.
     *
     * @param \Aedes\AedewBundle\Entity\Acc $acc
     * @param type $id file id
     * @param type $admin enable admin mod
     * @param type $mobile enable mobile mod
     * @return type web
     */
    public function getWeb(\Aedes\AedewBundle\Entity\Acc $acc, $id,
                           $admin = false, $mobile = false)
    {
        $file = $this->findPage($acc, $id);

        $mod = "index";
        $style = $acc->getStyle();

        if($mobile) {
            $mod = "mobile";
            $style = $acc->getMobileStyle();
        }

        return $this->render('AedesAedewBundle:' . $style . ':' . $mod . '.html.twig',
                             array(
                                   'acc'      => $acc,
                                   'rootMenu' => $this->getRoot($acc),
                                   'menu'     => $this->getMenu($acc),
                                   'file'     => $file,
                                   'child'    => $this->getChild($acc, $file),
                                   'img'      => $this->getImg($acc),
                                   'admin'    => $admin,
                                   'mobile'   => $mobile
                                  )
                            );
    }

    /**
     * contact form
     */
    public function contactAction($id)
    {
        return $this->contactForm($id);
    }

    /**
     * mobile contact form
     */
    public function mobileContactAction($id)
    {
        return $this->contactForm($id, true);
    }

    /**
     * new contact form
     *
     * @param type $id the taget file id
     * @param type $mobile mobile mod
     * @return type form web
     */
    public function contactForm($id, $mobile = false)
    {
        $acc = $this->findUser();

        $msg = new \Aedes\AedewBundle\Entity\Msg;
        $msg->setTaget($id);

        $form = $this->createFormBuilder($msg)
                     ->add("title", 'choice', array('choices' => array(
                              "定位" => "定位",
                              "定餐" => "定餐",
                              "訂房" => "訂房",
                              "預約" => "預約",
                              "其他" => "其他")
                          ))
                     ->add("name",  "text")
                     ->add("phone", "text")
                     ->add("taget", 'choice', array('choices' => $this->fileArray($acc)))
                     ->add('content', 'textarea')
                     ->getForm();

        $formView = $this->render('AedesAedewBundle:' . $acc->getStyle() . ':contact.html.twig',
                                  array('acc' => $acc, 'form' => $form->createView(), 'mobile' => $mobile));

        $request = $this->getRequest();

        if($request->getMethod() !== 'POST')
            return $formView;

        $form->bindRequest($request);

        if(!$form->isValid())
            return $formView;

        $post = $request->request->get("form");

        $endSend = "file";
        if($mobile)
            $endSend = "mobileView";

        try {
            $em = $this->getDoctrine()->getEntityManager();

            $msg = new \Aedes\AedewBundle\Entity\Msg;
            $msg->setAddTime(new \DateTime("now"));
            $msg->setName($post['name']);
            $msg->setPhone($post['phone']);
            $msg->setTaget($post['taget']);
            $msg->setTitle($post['title']);
            $msg->setContent($post['content']);
            $msg->setOwn($acc->getId());

            $em->persist($msg);
            $em->flush();

        } catch (\Exception $exc) {
            return $this->redirect($this->generateUrl('error',
                                                      array("error" => $error,
                                                            "sendTo" => $endSend))
                                                     );
        }

        return $this->redirect($this->generateUrl('msg',
                                                      array("msg" => "done",
                                                            "sendTo" => $endSend))
                                                     );
    }

    /**
     * find user acc by domain
     *
     * @return type \Aedes\AedewBundle\Entity\Acc
     */
    public function findUser()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $domain = $this->get('request')->server->get('HTTP_HOST');

        $user = $em->getRepository("AedesAedewBundle:Acc")
                   ->findOneBy(array("domain" => $domain));

        if($user === null)
            throw new \Exception("Error domain");

        return $user;
    }

    /**
     * find now page.
     *
     * if id is < 1 it will get acc default file id.
     *
     * @param \Aedes\AedewBundle\Entity\Acc $acc
     * @param type $id now page id
     * @return type \Aedes\AedewBundle\Entity\File
     */
    public function findPage(\Aedes\AedewBundle\Entity\Acc $acc, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $id = intval($id);

        if($id < 1)
            $id = $acc->getDefaultFile();

        $file = $em->getRepository("AedesAedewBundle:File")
                   ->find($id);

        if($file === null)
            throw new \Exception("error config");

        if($acc->getId() !== $file->getOwn())
            throw new \Exception("error config");

        return $file;
    }

    /**
     * get file all child.
     * if file is not dir , it will return null array.
     *
     * @param \Aedes\AedewBundle\Entity\Acc $acc
     * @param \Aedes\AedewBundle\Entity\File $file
     * @return type file array
     */
    public function getChild(\Aedes\AedewBundle\Entity\Acc $acc,
                             \Aedes\AedewBundle\Entity\File $file)
    {
        $em = $this->getDoctrine()->getEntityManager();

        if(!$file->isDir())
            return array();

        return $em->getRepository("AedesAedewBundle:File")
                  ->findBy(array("parent" => $file->getId(),
                                 "own" => $acc->getId()),
                           array("sort"   => "ASC"));
    }

    /**
     * get this user all file that type is img.
     *
     * @param \Aedes\AedewBundle\Entity\Acc $acc
     * @return type file array
     */
    public function getImg(\Aedes\AedewBundle\Entity\Acc $acc)
    {
        $em = $this->getDoctrine()->getEntityManager();

        return $em->getRepository("AedesAedewBundle:File")
                  ->findBy(array("own" => $acc->getId(), "type" => "img"),
                           array("sort" => "ASC"));
    }

    /**
     * get file parent is 0 file.
     * 0 mean is on root dir.
     *
     * @param \Aedes\AedewBundle\Entity\Acc $acc
     * @return type file array
     */
    public function getRoot(\Aedes\AedewBundle\Entity\Acc $acc)
    {
        $em = $this->getDoctrine()->getEntityManager();

        return $em->getRepository("AedesAedewBundle:File")
                  ->findBy(array("own" => $acc->getId(), "parent" => 0),
                           array("sort" => "ASC"));
    }

    /**
     * get all this acc's file.
     *
     * @param \Aedes\AedewBundle\Entity\Acc $acc
     * @return type file array
     */
    public function getAllOwn(\Aedes\AedewBundle\Entity\Acc $acc)
    {
        $em = $this->getDoctrine()->getEntityManager();

        return $em->getRepository("AedesAedewBundle:File")
                  ->findBy(array("own" => $acc->getId()),
                           array("sort" => "ASC"));
    }

    /**
     * get file to select by type.
     *
     * @param \Aedes\AedewBundle\Entity\Acc $acc
     * @param type $type string
     * @return type file array
     */
    public function getType(\Aedes\AedewBundle\Entity\Acc $acc, $type)
    {
        $em = $this->getDoctrine()->getEntityManager();

        return $em->getRepository("AedesAedewBundle:File")
                  ->findBy(array("own" => $acc->getId(), "type" => $type),
                           array("sort" => "ASC"));
    }

    /**
     * get acc set menu
     *
     * @param \Aedes\AedewBundle\Entity\Acc $acc
     * @return type
     */
    public function getMenu(\Aedes\AedewBundle\Entity\Acc $acc)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $dir = $em->getRepository("AedesAedewBundle:File")->find($acc->getMenu());

        if(null === $dir)
            return array();

        if(!$dir->isDir())
            return array();

        if($dir->getOwn() != $acc->getId())
            return array();

        return $this->getChild($acc, $dir);
    }

    /**
     * get file array for form use
     *
     * @param \Aedes\AedewBundle\Entity\Acc $acc
     * @return type array
     */
    public function fileArray(\Aedes\AedewBundle\Entity\Acc $acc)
    {
        $file = $this->getType($acc, "file");

        $key = array();
        $val = array();

        $key = array_merge($key, array(0));
        $val = array_merge($val, array("unset"));

        foreach ($file as $value) {
            $key = array_merge($key, array($value->getId()));
            $val = array_merge($val, array($value->getTitle()));
        }

        $both = array_combine($key, $val);

        return $both;
    }
}