<?php

namespace Social\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="Social\Bundle\Repository\CommentaireRepository")
 */
class Commentaire
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
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255)
     */
    private $commentaire;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="commentaire")
    * @ORM\JoinColumn(name="users_id", referencedColumnName="id")
    */
    private $user;

    /**
    * @ORM\ManyToOne(targetEntity="Post", inversedBy="commentaire")
    * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
    */
    private $post;

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
     * Set commentaire
     *
     * @param string $commentaire
     * @return Commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set user
     *
     * @param \Social\Bundle\Entity\User $user
     * @return Commentaire
     */
    public function setUser(\Social\Bundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Social\Bundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set post
     *
     * @param \Social\Bundle\Entity\Post $post
     * @return Commentaire
     */
    public function setPost(\Social\Bundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \Social\Bundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }
}
