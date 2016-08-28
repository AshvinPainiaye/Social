<?php

namespace Social\Bundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @Vich\Uploadable
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


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="user_profile", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;


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
     * @return User
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
}
