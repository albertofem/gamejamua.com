<?php

/*
 * This file is part of gamejamua.com
 *
 * (c) Alberto Fernández <albertofem@gmail.com>
 *
 * For the full copyright and license information, please read
 * the LICENSE file that was distributed with this source code.
 */

namespace GJA\GameJam\CompoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="gamejam_compos_applications")
 */
class CompoApplication
{
    const MODALITY_NORMAL = 1;
    const MODALITY_OUT_OF_COMPO = 2;
    const MODALITY_FREE = 3;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="Compo", inversedBy="applications")
     */
    protected $compo;

    /**
     * @ORM\ManyToOne(targetEntity="GJA\GameJam\UserBundle\Entity\User", inversedBy="applications")
     */
    protected $user;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $modality;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $nightStay;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $completed = false;

    /**
     * @ORM\OneToOne(targetEntity="GJA\GameJam\UserBundle\Entity\Order", cascade={"persist"}, inversedBy="compoApplication")
     */
    protected $order;

    public function __construct()
    {
        $this->date = new \DateTime("now");
    }

    /**
     * @param mixed $compo
     */
    public function setCompo($compo)
    {
        $this->compo = $compo;
    }

    /**
     * @return mixed
     */
    public function getCompo()
    {
        return $this->compo;
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
     * @param mixed $modality
     */
    public function setModality($modality)
    {
        $this->modality = $modality;
    }

    /**
     * @return mixed
     */
    public function getModality()
    {
        return $this->modality;
    }

    /**
     * @param mixed $nightStay
     */
    public function setNightStay($nightStay)
    {
        $this->nightStay = $nightStay;
    }

    /**
     * @return mixed
     */
    public function getNightStay()
    {
        return $this->nightStay;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    public static function getAvailableModalitites()
    {
        return [
            self::MODALITY_NORMAL => "Participar en el concurso",
            self::MODALITY_OUT_OF_COMPO => "Participar fuera de concurso",
            self::MODALITY_FREE => "Participar de forma libre"
        ];
    }

    public function getModalityAsString()
    {
        return self::getAvailableModalitites()[$this->modality];
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $completed
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;
    }

    public function isCompleted()
    {
        return $this->completed;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }
}
