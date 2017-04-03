<?php

namespace CoreShop\Bundle\TaxationBundle\Form\Type;

use CoreShop\Bundle\AddressBundle\Form\Type\CountryChoiceType;
use CoreShop\Bundle\AddressBundle\Form\Type\StateChoiceType;
use CoreShop\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class TaxRuleType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', CountryChoiceType::class, [
                'label' => 'coreshop.form.address.country',
                'active' => true,
                'required' => false
            ])
            ->add('state', StateChoiceType::class, [
                'label' => 'coreshop.form.address.country',
                'active' => true,
                'required' => false
            ])
            ->add('taxRate', TaxRateChoiceType::class, [
                'label' => 'coreshop.form.taxation.tax_rule',
                'active' => true
            ])
            ->add('behavior', ChoiceType::class, [
                'choices' => [
                    'coreshop.form.tax_rule.behaviour.disable' => 0,
                    'coreshop.form.tax_rule.behaviour.combine' => 1,
                    'coreshop.form.tax_rule.behaviour.one_after_another' => 2
                ],
                'choice_translation_domain' => false,
                'label' => 'coreshop.form.taxation.tax_rule',
                'placeholder' => 'coreshop.form.tax_rule.select',
            ]);
    }

    public function getBlockPrefix()
    {
        return 'coreshop_tax_rule';
    }
}