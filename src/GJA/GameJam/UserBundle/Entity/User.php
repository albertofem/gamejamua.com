<?php

/*
 * This file is part of gamejamua.com
 *
 * (c) Alberto Fernández <albertofem@gmail.com>
 *
 * For the full copyright and license information, please read
 * the LICENSE file that was distributed with this source code.
 */

namespace GJA\GameJam\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use FOS\UserBundle\Model\User as BaseUser;
use GJA\GameJam\CompoBundle\Entity\Achievement;
use GJA\GameJam\CompoBundle\Entity\Compo;
use GJA\GameJam\CompoBundle\Entity\CompoApplication;
use GJA\GameJam\CompoBundle\Entity\Notification;
use GJA\GameJam\CompoBundle\Entity\Team;
use GJA\GameJam\CompoBundle\Entity\Activity;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="GJA\GameJam\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="gamejam_users")
 */
class User extends BaseUser implements EncoderAwareInterface
{
    const SEX_MALE = 0;
    const SEX_FEMALE = 1;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $registeredAt;

    /**
     * @ORM\OneToMany(targetEntity="GJA\GameJam\GameBundle\Entity\Game", mappedBy="user")
     */
    protected $games;

    /**
     * @ORM\ManyToMany(targetEntity="GJA\GameJam\CompoBundle\Entity\Team", inversedBy="users", fetch="EAGER")
     * @ORM\JoinTable(name="gamejam_users_teams")
     */
    protected $teams;

    /**
     * @ORM\OneToMany(targetEntity="GJA\GameJam\CompoBundle\Entity\CompoApplication", mappedBy="user")
     */
    protected $applications;

    /**
     * @ORM\OneToMany(targetEntity="GJA\GameJam\CompoBundle\Entity\Activity", mappedBy="user")
     * @ORM\OrderBy({"date"="DESC"})
     */
    protected $activity;

    /**
     * @ORM\ManyToMany(targetEntity="GJA\GameJam\CompoBundle\Entity\Notification", mappedBy="users")
     */
    protected $notifications;

    /**
     * @ORM\OneToMany(targetEntity="AchievementGranted", mappedBy="user")
     */
    protected $achievements;

    /**
     * @ORM\Column(type="integer")
     */
    protected $coins = 0;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $nickname;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $avatarUrl;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $birthDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $sex;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $siteUrl;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $presentation;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $publicProfile = true;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $publicEmail = false;

    /**
     * @ORM\ManyToMany(targetEntity="GJA\GameJam\CompoBundle\Entity\Notification", mappedBy="usersRead")
     */
    protected $readNotifications;

    /**
     * @Assert\NotBlank
     * @Assert\True
     */
    protected $termsAccepted = true;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $allowCommunications = true;

    /**
     * @ORM\Column(type="json_array")
     */
    protected $oauthTokens = array();

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $twitter;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $legacyPassword = false;

    /**
     * @param mixed $achievements
     */
    public function setAchievements($achievements)
    {
        $this->achievements = $achievements;
    }

    /**
     * @return AchievementGranted[]
     */
    public function getAchievements()
    {
        return $this->achievements;
    }

    /**
     * @param mixed $activity
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
    }

    /**
     * @return mixed
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param mixed $avatarUrl
     */
    public function setAvatarUrl($avatarUrl)
    {
        $this->avatarUrl = $avatarUrl;
    }

    /**
     * @return mixed
     */
    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $coins
     */
    public function setCoins($coins)
    {
        $this->coins = $coins;
    }

    /**
     * @return mixed
     */
    public function getCoins()
    {
        return $this->coins;
    }

    /**
     * @param mixed $games
     */
    public function setGames($games)
    {
        $this->games = $games;
    }

    public function getGames()
    {
        return $this->games;
    }

    /**
     * @return mixed
     */
    public function getAllGames()
    {
        $games = new ArrayCollection();

        foreach($this->getTeams() as $team)
        {
            foreach($team->getGames() as $game)
            {
                $games->add($game);
            }
        }

        foreach($this->getGames() as $game)
        {
            $games->add($game);
        }

        return $games;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname ?: $this->username;
    }

    /**
     * @param mixed $notifications
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * @return mixed
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param mixed $presentation
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;
    }

    /**
     * @return mixed
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * @param mixed $publicEmail
     */
    public function setPublicEmail($publicEmail)
    {
        $this->publicEmail = $publicEmail;
    }

    /**
     * @return mixed
     */
    public function getPublicEmail()
    {
        return $this->publicEmail;
    }

    /**
     * @param mixed $publicProfile
     */
    public function setPublicProfile($publicProfile)
    {
        $this->publicProfile = $publicProfile;
    }

    /**
     * @return mixed
     */
    public function getPublicProfile()
    {
        return $this->publicProfile;
    }

    /**
     * @param mixed $readNotifications
     */
    public function setReadNotifications($readNotifications)
    {
        $this->readNotifications = $readNotifications;
    }

    /**
     * @return mixed
     */
    public function getReadNotifications()
    {
        return $this->readNotifications;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $siteUrl
     */
    public function setSiteUrl($siteUrl)
    {
        $this->siteUrl = $siteUrl;
    }

    /**
     * @return mixed
     */
    public function getSiteUrl()
    {
        return $this->siteUrl;
    }

    /**
     * @param mixed $teams
     */
    public function setTeams($teams)
    {
        $this->teams = $teams;
    }

    /**
     * @return Team[]
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @param mixed $registeredAt
     */
    public function setRegisteredAt($registeredAt)
    {
        $this->registeredAt = $registeredAt;
    }

    /**
     * @return mixed
     */
    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }

    public function __toString()
    {
        return $this->getNickname();
    }

    public function getShouts()
    {
        return $this->getActivity()->filter(function(Activity $activity)
        {
            return $activity->getType() == Activity::TYPE_SHOUT;
        });
    }

    /**
     * @param mixed $termsAccepted
     */
    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = $termsAccepted;
    }

    /**
     * @return mixed
     */
    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    /**
     * @param CompoApplication[] $applications
     */
    public function setApplications($applications)
    {
        $this->applications = $applications;
    }

    /**
     * @return CompoApplication[]
     */
    public function getApplications()
    {
        return $this->applications;
    }

    public function hasAppliedTo(Compo $compo)
    {
        foreach($this->getApplications() as $application)
        {
            if($compo === $application->getCompo())
            {
                if($application->isCompleted())
                    return true;
                else
                    return false;
            }
        }

        return false;
    }

    public function getApplicationTo(Compo $compo)
    {
        foreach($this->getApplications() as $application)
        {
            if($compo === $application->getCompo())
            {
                if($application->isCompleted())
                    return $application;
            }
        }

        return null;
    }

    public function getOpenApplicationTo(Compo $compo)
    {
        foreach($this->getApplications() as $application)
        {
            if($compo === $application->getCompo())
            {
                if(!$application->isCompleted())
                    return $application;
            }
        }

        return null;
    }

    public function hasAchievement(Achievement $achievement)
    {
        foreach($this->getAchievements() as $achievementGranted)
        {
            if($achievementGranted->getAchievement() === $achievement)
                return true;
        }

        return false;
    }

    public function isMember()
    {
        if($this->hasRole("ROLE_MEMBER"))
        {
            return true;
        }

        return false;
    }

    /**
     * @param mixed $allowCommunications
     */
    public function setAllowCommunications($allowCommunications)
    {
        $this->allowCommunications = $allowCommunications;
    }

    /**
     * @return mixed
     */
    public function getAllowCommunications()
    {
        return $this->allowCommunications;
    }

    public static function getAvailableSexes()
    {
        return [
            self::SEX_MALE => 'Hombre',
            self::SEX_FEMALE => 'Mujer'
        ];
    }

    /**
     * @param mixed $oauthTokens
     */
    public function setOauthTokens($oauthTokens)
    {
        $this->oauthTokens = $oauthTokens;
    }

    /**
     * @return mixed
     */
    public function getOauthTokens()
    {
        return $this->oauthTokens;
    }

    public function setOAuthAccountUserId($service, $username)
    {
        $this->oauthTokens[$service]['username'] = $username;
    }

    public function setOauthAccountAccessToken($service, $token)
    {
        $this->oauthTokens[$service]['token'] = $token;
    }

    public function hasOauthServiceConnected($service)
    {
        return isset($this->oauthTokens[$service]);
    }

    public function getOauthTwitterUsername()
    {
        if(isset($this->oauthTokens['twitter']['username']))
            return $this->oauthTokens['twitter']['username'];

        return null;
    }

    /**
     * @param mixed $twitter
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * @return mixed
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param mixed $legacyPassword
     */
    public function setLegacyPassword($legacyPassword)
    {
        $this->legacyPassword = $legacyPassword;
    }

    /**
     * @return mixed
     */
    public function getLegacyPassword()
    {
        return $this->legacyPassword;
    }

    public function getEncoderName()
    {
        if($this->legacyPassword)
            return 'legacy_encoder';

        return null;
    }

    public function getAge()
    {
        $now = new \DateTime("now");

        return $now->diff($this->getBirthDate())->format("%Y");
    }

    public function hasReadNotification(Notification $notification)
    {
        return $this->readNotifications->contains($notification);
    }

    public function getTeamForCompo(Compo $compo)
    {
        foreach($this->getTeams() as $team)
        {
            if($team->getCompo() === $compo)
                return $team;
        }

        return null;
    }

    public function addToTeam(Team $team)
    {
        $this->teams[] = $team;
    }
}