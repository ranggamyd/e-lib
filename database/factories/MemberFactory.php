<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Member::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = ['Male', 'Female', 'Others'];
        return [
            'member_code' => uniqid(),
            'name' => $this->faker->name(),
            'npm' => hexdec(uniqid()),
            'subject_id' => mt_rand(1, 5),
            'birth' => $this->faker->date(),
            'gender' => $gender[array_rand($gender)],
            'address' => $this->faker->address(),
            'username' => $this->faker->userName(),
            'email' => $this->faker->email(),
            'password' => Hash::make('password')
        ];
    }
}
