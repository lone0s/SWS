<?php

namespace App\Form;

use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $items = $options['data'];
        dump($items);
        foreach($items as $item){
            $builder
                ->add('articles', CollectionType::class, array(
                    'entry_type' => ArticleType::class,
                    'entry_options' => array(),
                ));

        }
        $builder->add('choice' , ChoiceType::class, [
                    'choices' => range(0,10 )
                ]);
        /*foreach($items as $item){
            $builder
                ->add('libelle', TextType::class, [
                    'data' => $item->getLibelle(),
                    'disabled' => true,
                    ])
                ->add('price',TextType::class, [
                    'data' => $item->getPrice(),
                    'disabled' => true,
                ])
                ->add('stock',TextType::class, [
                    'data' => $item->getStock(),
                    'disabled' => true,
                ])
                ->add('choice' , ChoiceType::class, [
                    'choices' => range(0,10 )
                ]);
        }*/

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
