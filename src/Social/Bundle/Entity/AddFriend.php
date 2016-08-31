<?php

namespace Social\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AddFriend
 *
 * @ORM\Table(name="add_friend")
 * @ORM\Entity(repositoryClass="Social\Bundle\Repository\AddFriendRepository")
 */
class AddFriend
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="friendEnvoie")
    */
    private $envoieFriend;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="friendReception")
    */
    private $receptionFriend;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

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
     * Set envoieFriend
     *
     * @param \Social\Bundle\Entity\User $envoieFriend
     * @return AddFriend
     */
    public function setEnvoieFriend(\Social\Bundle\Entity\User $envoieFriend = null)
    {
        $this->envoieFriend = $envoieFriend;

        return $this;
    }

    /**
     * Get envoieFriend
     *
     * @return \Social\Bundle\Entity\User
     */
    public function getEnvoieFriend()
    {
        return $this->envoieFriend;
    }

    /**
     * Set receptionFriend
     *
     * @param \Social\Bundle\Entity\User $receptionFriend
     * @return AddFriend
     */
    public function setReceptionFriend(\Social\Bundle\Entity\User $receptionFriend = null)
    {
        $this->receptionFriend = $receptionFriend;

        return $this;
    }

    /**
     * Get receptionFriend
     *
     * @return \Social\Bundle\Entity\User
     */
    public function getReceptionFriend()
    {
        return $this->receptionFriend;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return AddFriend
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
}
