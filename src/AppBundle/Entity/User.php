<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    const LOGIN_METHOD_SOCIAL   = 'social';
    const LOGIN_METHOD_PASSWORD = 'password';

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="display_name", type="string", length=255, nullable=true)
     */
    protected $displayName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    protected $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=255, nullable=true)
     */
    protected $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=255, nullable=true)
     */
    protected $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="timezone", type="string", length=255, nullable=true)
     */
    protected $timezone;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    protected $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="social_id", type="string", length=255, unique=true, nullable=true)
     */
    protected $socialId;

    /**
     * @var string
     *
     * @ORM\Column(name="social_type", type="string", length=255, nullable=true)
     */
    protected $socialType;

    /**
     * @var array
     */
    protected $socialData;

    /**
     * @var string
     */
    protected $loginMethod = self::LOGIN_METHOD_PASSWORD;

    /**
     * @return string
     */
    public function getSocialId()
    {
        return $this->socialId;
    }

    /**
     * @param string $socialId
     *
     * @return $this
     */
    public function setSocialId($socialId)
    {
        $this->socialId = (string) $socialId;

        return $this;
    }

    /**
     * @return string
     */
    public function getSocialType()
    {
        return $this->socialType;
    }

    /**
     * @param string $socialType
     *
     * @return $this
     */
    public function setSocialType($socialType)
    {
        $this->socialType = (string) $socialType;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = (string) $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = (string) $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = (string) $locale;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param string $timezone
     *
     * @return $this
     */
    public function setTimezone($timezone)
    {
        $this->timezone = (string) $timezone;

        return $this;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     *
     * @return $this
     */
    public function setAvatar($avatar)
    {
        $this->avatar = (string) $avatar;

        return $this;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return $this
     */
    public function setGender($gender)
    {
        $this->gender = (string) $gender;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     *
     * @return $this
     */
    public function setBirthDate(\DateTime $birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return array|mixed
     */
    public function getSocialData($key = null)
    {
        if ($key) {
            return isset($this->socialData[$key]) ? $this->socialData[$key] : null;
        }

        return $this->socialData;
    }

    /**
     * @param array $socialData
     *
     * @return $this
     */
    public function setSocialData(array $socialData)
    {
        $this->socialData = $socialData;

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        if (!$this->displayName) {
            return $this->displayName = $this->firstName ?: $this->username;
        }

        return $this->displayName;
    }

    /**
     * @param string $displayName
     *
     * @return $this
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = (string) $displayName;

        return $this;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     *
     * @return $this
     */
    public function setFullName($firstName, $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName  = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return trim("{$this->firstName} {$this->lastName}");
    }

    /**
     * @return string
     */
    public function getLoginMethod()
    {
        return $this->loginMethod;
    }

    /**
     * @param string $loginMethod
     *
     * @return $this
     */
    public function setLoginMethod($loginMethod)
    {
        $this->loginMethod = (string) $loginMethod;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return self|\FOS\UserBundle\Model\User
     */
    public function setEmail($email)
    {
        $this->username = $email;

        return parent::setEmail($email);
    }

    /**
     * @param string $username
     *
     * @return self|\FOS\UserBundle\Model\User
     */
    public function setUsername($username)
    {
        $username && ($this->email = $username);

        return parent::setUsername($username);
    }
}
