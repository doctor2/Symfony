<?php

namespace  Application\Sonata\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;

use Application\Sonata\CompanyBundle\Entity\Сompany;

use Application\UserBundle\Entity\User;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationCompanyType extends AbstractType
{
       /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    // public function getParent()
    // {
    //     return 'fos_user_registration';
    // }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('users', EntityType::class, array(
                        'class' => 'ApplicationUserBundle:User',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('u')
                                ->orderBy('u.name', 'ASC');
                        },
                        'choice_label' => 'name',
                    ));
            
           
             // ->add('city', new EntityType(), array(
             //    'class' => 'GiviAdviceGiviBundle:City',
             //    'choice_label' => 'name',))
             // ->add('city', new CityType)
            // ->add('City', ChoiceType::class, 
            //      array(
            //             'choices' => array(
            //             'city' => 'cityid',
            //             ))
            //      )
            //     array(
            // ->add('City', ChoiceType::class, 
            //     array(
            //             'choices' => array(
            //             'English' => 'en',
            //             'Spanish' => 'es',
            //             'Bork'   => 'muppets',
            //             'Pirate' => 'arr'
            //          )
            //         )
            //     )
            // ->add('created')
            // ->add('ciityd')
            // ->add('avatar')
            // ->add('comid')
            // ->add('city')
            // ->add('file')
            // ->add('company')
            // ->add('attemped', CheckboxType::class, array(
            //     'mapped' => false,
            //     'constraints' => new IsTrue(),
            //     'label'=> 'Принимаю условия пользовательского соглашения',
            // ))
        ;
        // $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
        //     $user = $event->getData();
        // $form = $event->getForm();
        // check if the user object is "new"
        // If no data is passed to the form, the data is "null".
        // This should be considered a new "user"
        // if (!$user || null === $user->getId()) {
        //     $form->add('name', TextType::class);
        // }
        // });
    }

     public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Sonata\UserBundle\Entity\User',
            'csrf_token_id' => 'transaction',
            // BC for SF < 2.8
            'intention'  => 'transaction',
        ));
    }

    // BC for SF < 2.7
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    // BC for SF < 3.0
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    public function getBlockPrefix()
    {
        return 'app_user_transaction';
    }
}
