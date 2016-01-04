<?php

namespace Aedes\AedewBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aedes\AedewBundle\Entity\Msg
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Msg
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     *
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     *
     * @var string $phone
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var integer $taget
     *
     * @ORM\Column(name="taget", type="integer")
     */
    private $taget;

    /**
     * @var datetime $addTime
     *
     * @ORM\Column(name="addTime", type="datetime")
     */
    private $addTime;

    /**
     * acc id
     *
     * @var integer $own
     *
     * @ORM\Column(name="own", type="integer")
     */
    private $own;

    /**
     * @var text $content
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phone
     *
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set taget
     *
     * @param integer $taget
     */
    public function setTaget($taget)
    {
        $this->taget = $taget;
    }

    /**
     * Get taget
     *
     * @return integer
     */
    public function getTaget()
    {
        return $this->taget;
    }

    /**
     * Set addTime
     *
     * @param datetime $addTime
     */
    public function setAddTime($addTime)
    {
        $this->addTime = $addTime;
    }

    /**
     * Get addTime
     *
     * @return datetime
     */
    public function getAddTime()
    {
        return $this->addTime;
    }

    /**
     * Set own
     *
     * @param integer $own
     */
    public function setOwn($own)
    {
        $this->own = $own;
    }

    /**
     * Get own
     *
     * @return integer
     */
    public function getOwn()
    {
        return $this->own;
    }

    /**
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text
     */
    public function getContent()
    {
        return $this->content;
    }
}