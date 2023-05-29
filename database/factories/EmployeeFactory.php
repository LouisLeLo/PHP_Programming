<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hoten' => $this->faker->name(),
            'gioitinh' => $this->faker->randomElement(['nam','nu','khac']),
            'ngaysinh' => $this->faker->date('Y-m-d', $max = 'now'),
            'dtb'   => $this->faker->randomFloat($nbMaxDecimals = 1 ,$min = 0, $max = 10),
            'diachi' => $this->faker->address(),            
        ];
    }
}
