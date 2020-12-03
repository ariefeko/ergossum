<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $company = Company::factory(1)->create()->first();
        return [
            'fname' => $this->faker->firstName,
            'lname' => $this->faker->lastName,
            'company_id' => $company->id,
            'email' => $this->faker->email,
            'phone' => $this->faker->e164PhoneNumber,
        ];
    }
}
