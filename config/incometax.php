<?php
return [
    "male" => [
        "minStartAmount"                    => 300000,
        "minStartAmountForDisabledChild"    => 350000,
        "minStartAmountForDisabled"         => 450000,
        "minStartAmountForFreedomFighter"   => 475000,
        "slave" =>  [
            [
                'amount'        => 100000,
                'percentage'    => 5,
                'tax'           => 5000,
            ],
            [
                'amount'        => 300000,
                'percentage'    => 10,
                'tax'           => 30000,
            ],
            [
                'amount'        => 400000,
                'percentage'    => 15,
                'tax'           => 60000,
            ],
            [
                'amount'        => 500000,
                'percentage'    => 20,
                'tax'           => 100000,
            ],
            [
                'amount'        => 'last',
                'percentage'    => 25,
                'tax'           => 0,
            ]
        ]
    ],
    "female" => [
        "minStartAmount"                    => 350000,
        "minStartAmountForDisabledChild"    => 400000,
        "minStartAmountForDisabled"         => 450000,
        "minStartAmountForFreedomFighter"   => 475000,
        "slave" => [
            [
                'amount'        => 100000,
                'percentage'    => 5,
                'tax'           => 5000,
            ],
            [
                'amount'        => 300000,
                'percentage'    => 10,
                'tax'           => 30000,
            ],
            [
                'amount'        => 400000,
                'percentage'    => 15,
                'tax'           => 60000,
            ],
            [
                'amount'        => 500000,
                'percentage'    => 20,
                'tax'           => 100000,
            ],
            [
                'amount'        => 'last',
                'percentage'    => 25,
                'tax'           => 0,
            ]
        ]
    ],
    'old_calculation_06_2020' => [
        "male" => [
            "minStartAmount" => 250000,
            "minStartAmountForDisabledChild" => 300000,
            "minStartAmountForDisabled" => 400000,
            "minStartAmountForFreedomFighter" => 425000,
            "max_taxable_income" => 5000000,
            "max_tax_amount" => 1060000,
            "slave" =>  [

                [
                    'amount'=>400000,
                    'percentage'=>10,
                    'tax'=>40000,
                ],
                [
                    'amount'=>500000,
                    'percentage'=>15,
                    'tax'=>75000,
                ],
                [
                    'amount'=>600000,
                    'percentage'=>20,
                    'tax'=>120000,
                ],
                [
                    'amount'=>3000000,
                    'percentage'=>25,
                    'tax'=>750000,
                ],
                [
                    'amount'=>250000,
                    'percentage'=>30,
                    'tax'=>75000,
                ]
            ]
        ],
        "female" => [
            "minStartAmount" => 300000,
            "minStartAmountForDisabledChild" => 350000,
            "minStartAmountForDisabled" => 400000,
            "minStartAmountForFreedomFighter" => 425000,
            "max_taxable_income" => 5000000,
            "max_tax_amount" => 1045000,
            "slave" => [
                [
                    'amount'=>400000,
                    'percentage'=>10,
                    'tax'=>40000,
                ],
                [
                    'amount'=>500000,
                    'percentage'=>15,
                    'tax'=>75000,
                ],
                [
                    'amount'=>600000,
                    'percentage'=>20,
                    'tax'=>120000,
                ],
                [
                    'amount'=>3000000,
                    'percentage'=>25,
                    'tax'=>750000,
                ],
                [
                    'amount'=>200000,
                    'percentage'=>30,
                    'tax'=>60000,
                ]
            ]
        ]
    ]
];