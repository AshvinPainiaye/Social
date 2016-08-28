<?php

/*
* This file is part of the FOSUserBundle package.
*
* (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Social\Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Vich\UploaderBundle\Form\Type\VichImageType;

class RegistrationFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('imageFile', VichImageType::class, array('label' => ' ', 'required' => false))
    ;
  }

  public function getParent()
  {
    return 'FOS\UserBundle\Form\Type\RegistrationFormType';
  }

  public function getBlockPrefix()
  {
    return 'app_user_registration';
  }

  // For Symfony 2.x
  public function getName()
  {
    return $this->getBlockPrefix();
  }
}
