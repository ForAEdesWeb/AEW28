<?php

namespace Aedes\AedewBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aedes\AedewBundle\Entity\Acc
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Acc
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
     * 業務用, 登記哪個業務的客人
     *
     * @var string $addBy
     *
     * @ORM\Column(name="addBy", type="string", length=255, nullable=true)
     */
    public $addBy;

    /**
     * 業務用, 聯絡人
     *
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    public $name;

    /**
     * 業務用, 聯絡人
     *
     * @var string $mail
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=true)
     */
    public $mail;

    /**
     * 業務用, 聯絡人, Mobile use to call
     *
     * @var string $phone
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    public $phone;

    /**
     * 業務用, 聯絡人, Mobile map
     *
     * @var string $address
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    public $address;

    /**
     * 業務用, 登記時間
     *
     * @var date $addTime
     *
     * @ORM\Column(name="addTime", type="date")
     */
    public $addTime;

    /**
     * 業務用, 剩餘時間
     *
     * @var date $endTime
     *
     * @ORM\Column(name="endTime", type="date")
     */
    public $endTime;

    /**
     * 網頁用 顯示網頁名
     *
     * @var string $company
     *
     * @ORM\Column(name="company", type="string", length=255)
     */
    public $company;

    /**
     * 網頁用 顯示網頁名
     *
     * @var string $logo
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    public $logo;

    /**
     * @var string $subject
     *
     * @ORM\Column(name="subject", type="string", length=255, nullable=true)
     */
    public $subject;

    /**
     * 登入時也使用網域名登入
     *
     * @var string $domain
     *
     * @ORM\Column(name="domain", type="string", length=255)
     */
    public $domain;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var text $footer
     *
     * @ORM\Column(name="footer", type="text", nullable=true)
     */
    public $footer;

    /**
     * @var integer $defaultFile
     *
     * @ORM\Column(name="defaultFile", type="integer")
     */
    public $defaultFile;

    /**
     * @var integer $menu
     *
     * @ORM\Column(name="menu", type="integer")
     */
    public $menu;

    /**
     * @var string $style
     *
     * @ORM\Column(name="style", type="string", length=255)
     */
    public $style;

    /**
     * @var string $mobileStyle
     *
     * @ORM\Column(name="mobileStyle", type="string", length=255)
     */
    public $mobileStyle;


    public function __construct()
    {
        $now = new \DateTime("now");

        $this->addTime = $now;
        $this->endTime = $now;
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
     * Set addBy
     *
     * @param string $addBy
     */
    public function setAddBy($addBy)
    {
        $this->addBy = $addBy;
    }

    /**
     * Get addBy
     *
     * @return string
     */
    public function getAddBy()
    {
        return $this->addBy;
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
     * Set mail
     *
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
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
     * Set address
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set addTime
     *
     * @param date $addTime
     */
    public function setAddTime($addTime)
    {
        $this->addTime = $addTime;
    }

    /**
     * Get addTime
     *
     * @return date
     */
    public function getAddTime()
    {
        return $this->addTime;
    }

    /**
     * Set endTime
     *
     * @param date $endTime
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     * Get endTime
     *
     * @return date
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set company
     *
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set logo
     *
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set subject
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set domain
     *
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * Get domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = md5($password);
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set footer
     *
     * @param text $footer
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
    }

    /**
     * Get footer
     *
     * @return text
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * Set defaultFile
     *
     * @param text $defaultFile
     */
    public function setDefaultFile($defaultFile)
    {
        $this->defaultFile = $defaultFile;
    }

    /**
     * Get defaultFile
     *
     * @return text
     */
    public function getDefaultFile()
    {
        return $this->defaultFile;
    }

    /**
     * Set menu
     *
     * @param text $menu
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;
    }

    /**
     * Get menu
     *
     * @return text
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * extend end time
     *
     * @param type $day int
     */
    public function extend($day)
    {
        $day = intval($day);

        $this->endTime->modify($day . " day");
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

    /**
     * Set mobile style
     *
     * @param text $mobileStyle
     */
    public function setMobileStyle($mobileStyle)
    {
        $this->mobileStyle = $mobileStyle;
    }

    /**
     * Get mobile style
     *
     * @return text
     */
    public function getMobileStyle()
    {
        return $this->mobileStyle;
    }
}