<?php

namespace Social\Bundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @ORM\OneToMany(targetEntity="Post", mappedBy="user")
    * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
    */
    private $statut;

    /**
    * @ORM\OneToMany(targetEntity="Commentaire", mappedBy="user")
    * @ORM\JoinColumn(name="commentaire_id", referencedColumnName="id")
    */
    private $commentaire;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Add statut
     *
     * @param \Social\Bundle\Entity\Post $statut
     * @return User
     */
    public function addStatut(\Social\Bundle\Entity\Post $statut)
    {
        $this->statut[] = $statut;

        return $this;
    }

    /**
     * Remove statut
     *
     * @param \Social\Bundle\Entity\Post $statut
     */
    public function removeStatut(\Social\Bundle\Entity\Post $statut)
    {
        $this->statut->removeElement($statut);
    }

    /**
     * Get statut
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Add commentaire
     *
     * @param \Social\Bundle\Entity\Commentaire $commentaire
     * @return User
     */
    public function addCommentaire(\Social\Bundle\Entity\Commentaire $commentaire)
    {
        $this->commentaire[] = $commentaire;

        return $this;
    }

    /**
     * Remove commentaire
     *
     * @param \Social\Bundle\Entity\Commentaire $commentaire
     */
    public function removeCommentaire(\Social\Bundle\Entity\Commentaire $commentaire)
    {
        $this->commentaire->removeElement($commentaire);
    }

    /**
     * Get commentaire
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }
}
