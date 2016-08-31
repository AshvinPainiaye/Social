<?php

namespace Social\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
* Post
*
* @ORM\Table(name="post")
* @ORM\Entity(repositoryClass="Social\Bundle\Repository\PostRepository")
* @Vich\Uploadable
*/
class Post
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
  * @ORM\Column(name="Statut", type="string", length=255)
  */
  private $statut;

  /**
  * @ORM\ManyToOne(targetEntity="User", inversedBy="statut")
  * @ORM\JoinColumn(name="users_id", referencedColumnName="id")
  */
  private $user;

  /**
  * @ORM\OneToMany(targetEntity="Commentaire", mappedBy="post")
  * @ORM\JoinColumn(name="commentaire_id", referencedColumnName="id")
  */
  private $commentaire;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="date", type="datetime")
   */
  private $date;

  /**
  * NOTE: This is not a mapped field of entity metadata, just a simple property.
  *
  * @Vich\UploadableField(mapping="user_post", fileNameProperty="imageName")
  *
  * @var File
  */
  private $imageFile;

  /**
  * @ORM\Column(type="string", length=255, nullable=true)
  *
  * @var string
  */
  private $imageName;

  /**
  * @ORM\Column(type="datetime", nullable=true)
  *
  * @var \DateTime
  */
  private $updatedAt;

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
  * Set statut
  *
  * @param string $statut
  * @return Post
  */
  public function setStatut($statut)
  {
    $this->statut = $statut;

    return $this;
  }

  /**
  * Get statut
  *
  * @return string
  */
  public function getStatut()
  {
    return $this->statut;
  }

  /**
  * Set user
  *
  * @param \Social\Bundle\Entity\User $user
  * @return Post
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
  * Constructor
  */
  public function __construct()
  {
    $this->commentaire = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
  * Add commentaire
  *
  * @param \Social\Bundle\Entity\Commentaire $commentaire
  * @return Post
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


  /**
  * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
  * of 'UploadedFile' is injected into this setter to trigger the  update. If this
  * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
  * must be able to accept an instance of 'File' as the bundle will inject one here
  * during Doctrine hydration.
  *
  * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
  *
  * @return Product
  */
  public function setImageFile(File $image = null)
  {
    $this->imageFile = $image;

    if ($image) {
      // It is required that at least one field changes if you are using doctrine
      // otherwise the event listeners won't be called and the file is lost
      $this->updatedAt = new \DateTime('now');
    }

    return $this;
  }

  /**
  * @return File|null
  */
  public function getImageFile()
  {
    return $this->imageFile;
  }

  /**
  * @param string $imageName
  *
  * @return Product
  */
  public function setImageName($imageName)
  {
    $this->imageName = $imageName;

    return $this;
  }

  /**
  * @return string|null
  */
  public function getImageName()
  {
    return $this->imageName;
  }



    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Post
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Post
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
