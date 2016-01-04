<?php

namespace Aedes\AedewBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aedes\AedewBundle\Entity\File
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class File
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    public $title;

    /**
     * @var text $subject
     *
     * @ORM\Column(name="subject", type="text", nullable=true)
     */
    public $subject;

    /**
     * @var text $content
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    public $content;

    /**
     * only [file, dir, img]
     * type 如果是 img 代表著是放在網頁形象圖
     *
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=5)
     */
    public $type;

    /**
     * acc id
     *
     * @var integer $own
     *
     * @ORM\Column(name="own", type="integer")
     */
    public $own;

    /**
     * file id
     * parent 設定 0 代表著該用戶網頁的根目錄
     *
     * @var integer $parent
     *
     * @ORM\Column(name="parent", type="integer")
     */
    public $parent;

    /**
     * @var datetime $addTime
     *
     * @ORM\Column(name="addTime", type="datetime")
     */
    public $addTime;

    /**
     * 排列順序
     *
     * @var integer $sort
     *
     * @ORM\Column(name="sort", type="integer", nullable=true)
     */
    public $sort;

    /**
     * @var text $css
     *
     * @ORM\Column(name="css", type="text", nullable=true)
     */
    public $css;

    /**
     * @var boolean $isHideContact
     *
     * @ORM\Column(name="isHideContact", type="boolean")
     */
    public $isHideContact;

    /**
     * @var boolean $shareButton
     *
     * @ORM\Column(name="shareButton", type="boolean")
     */
    public $shareButton;

    /**
     * @var boolean $facebookComment
     *
     * @ORM\Column(name="facebookComment", type="boolean")
     */
    public $facebookComment;

    /**
     * @var string $style
     *
     * @ORM\Column(name="style", type="string", length=255)
     */
    public $style;

    /**
     * @var integer $color
     *
     * @ORM\Column(name="color", type="array", nullable=true)
     */
    public $color;


    public function __construct()
    {
        $this->addTime         = new \DateTime("now");
        $this->shareButton     = true;
        $this->facebookComment = true;
        $this->parent          = 0;
        $this->isHideContact   = false;
        $this->type            = "file";
    }

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
     * Set subject
     *
     * @param text $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Get subject
     *
     * @return text
     */
    public function getSubject()
    {
        return $this->subject;
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

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $fileType = array("img", "file", "dir", "msg", "map", "qr");

        if(!in_array($type, $fileType))
            throw new \Exception("file type only can be img, file, dir, msg, map, qr");

        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * Set parent
     *
     * @param integer $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return integer
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * Get sort
     *
     * @return integer
     */
    public function getSort()
    {
        return $this->sort;
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
     * Set css
     *
     * @param text $css
     */
    public function setCss($css)
    {
        $this->css = $css;
    }

    /**
     * Get css
     *
     * @return text
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * Set isHide
     *
     * @param boolean $isHideContact
     */
    public function setIsHideContact($isHideContact)
    {
        $this->isHideContact = $isHideContact;
    }

    /**
     * Get isHide
     *
     * @return boolean
     */
    public function getIsHideContact()
    {
        return $this->isHideContact;
    }

    /**
     * Set shareButton
     *
     * @param boolean $shareButton
     */
    public function setShareButton($shareButton)
    {
        $this->shareButton = $shareButton;
    }

    /**
     * Get shareButton
     *
     * @return boolean
     */
    public function getShareButton()
    {
        return $this->shareButton;
    }

    /**
     * Set facebookComment
     *
     * @param boolean $facebookComment
     */
    public function setFacebookComment($facebookComment)
    {
        $this->facebookComment = $facebookComment;
    }

    /**
     * Get facebookComment
     *
     * @return boolean
     */
    public function getFacebookComment()
    {
        return $this->facebookComment;
    }

    public function isDir()
    {
        if($this->getType() !== "dir")
            return false;

        return true;
    }

    public function isMsg()
    {
        if($this->getType() !== "msg")
            return false;

        return true;
    }

    public function isMap()
    {
        if($this->getType() !== "map")
            return false;

        return true;
    }

    public function isQR()
    {
        if($this->getType() !== "qr")
            return false;

        return true;
    }

    /**
     * Set style
     *
     * @param text $style
     */
    public function setStyle($style)
    {
        $this->style = $style;
    }

    /**
     * Get style
     *
     * @return text
     */
    public function getStyle()
    {
        return $this->style;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getColorTitle($sum)
    {
        $color = $this->color;

        if(isset($color[$sum]))
            return $color[$sum]['title'];

        return "";
    }

    public function getColorContent($sum)
    {
        $color = $this->color;

        if(isset($color[$sum]))
            return $color[$sum]['content'];

        return "";
    }

    public function getColorTitle0(){ return $this->getColorTitle(0); }
    public function getColorContent0(){ return $this->getColorContent(0); }
    public function getColorTitle1(){ return $this->getColorTitle(1); }
    public function getColorContent1(){ return $this->getColorContent(1); }
    public function getColorTitle2(){ return $this->getColorTitle(2); }
    public function getColorContent2(){ return $this->getColorContent(2); }
    public function getColorTitle3(){ return $this->getColorTitle(3); }
    public function getColorContent3(){ return $this->getColorContent(3); }
    public function getColorTitle4(){ return $this->getColorTitle(4); }
    public function getColorContent4(){ return $this->getColorContent(4); }
    public function getColorTitle5(){ return $this->getColorTitle(5); }
    public function getColorContent5(){ return $this->getColorContent(5); }
    public function getColorTitle6(){ return $this->getColorTitle(6); }
    public function getColorContent6(){ return $this->getColorContent(6); }
    public function getColorTitle7(){ return $this->getColorTitle(7); }
    public function getColorContent7(){ return $this->getColorContent(7); }
    public function getColorTitle8(){ return $this->getColorTitle(8); }
    public function getColorContent8(){ return $this->getColorContent(8); }
    public function getColorTitle9(){ return $this->getColorTitle(9); }
    public function getColorContent9(){ return $this->getColorContent(9); }
    public function getColorTitle10(){ return $this->getColorTitle(10); }
    public function getColorContent10(){ return $this->getColorContent(10); }
    public function getColorTitle11(){ return $this->getColorTitle(11); }
    public function getColorContent11(){ return $this->getColorContent(11); }
    public function getColorTitle12(){ return $this->getColorTitle(12); }
    public function getColorContent12(){ return $this->getColorContent(12); }
    public function getColorTitle13(){ return $this->getColorTitle(13); }
    public function getColorContent13(){ return $this->getColorContent(13); }
    public function getColorTitle14(){ return $this->getColorTitle(14); }
    public function getColorContent14(){ return $this->getColorContent(14); }
    public function getColorTitle15(){ return $this->getColorTitle(15); }
    public function getColorContent15(){ return $this->getColorContent(15); }

    public function setColorTitle0(){}
    public function setColorContent0(){}
    public function setColorTitle1(){}
    public function setColorContent1(){}
    public function setColorTitle2(){}
    public function setColorContent2(){}
    public function setColorTitle3(){}
    public function setColorContent3(){}
    public function setColorTitle4(){}
    public function setColorContent4(){}
    public function setColorTitle5(){}
    public function setColorContent5(){}
    public function setColorTitle6(){}
    public function setColorContent6(){}
    public function setColorTitle7(){}
    public function setColorContent7(){}
    public function setColorTitle8(){}
    public function setColorContent8(){}
    public function setColorTitle9(){}
    public function setColorContent9(){}
    public function setColorTitle10(){}
    public function setColorContent10(){}
    public function setColorTitle11(){}
    public function setColorContent11(){}
    public function setColorTitle12(){}
    public function setColorContent12(){}
    public function setColorTitle13(){}
    public function setColorContent13(){}
    public function setColorTitle14(){}
    public function setColorContent14(){}
    public function setColorTitle15(){}
    public function setColorContent15(){}

}