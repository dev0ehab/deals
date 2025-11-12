<?php

namespace Database\Factories\Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Orders\Entities\OrderFile;

class FileAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $attributeTypes = ['text', 'number', 'boolean', 'json'];
        $attributeType = $this->faker->randomElement($attributeTypes);

        return [
            'order_file_id' => OrderFile::factory(),
            'attribute_name' => $this->faker->word,
            'attribute_value' => $this->generateAttributeValue($attributeType),
            'attribute_type' => $attributeType,
        ];
    }

    /**
     * Generate attribute value based on type
     *
     * @param string $type
     * @return mixed
     */
    private function generateAttributeValue($type)
    {
        switch ($type) {
            case 'number':
                return (string) $this->faker->randomFloat(2, 0, 1000);
            case 'boolean':
                return $this->faker->boolean ? '1' : '0';
            case 'json':
                return json_encode([
                    'width' => $this->faker->numberBetween(100, 2000),
                    'height' => $this->faker->numberBetween(100, 2000),
                    'color_space' => $this->faker->randomElement(['RGB', 'CMYK', 'Grayscale']),
                ]);
            default:
                return $this->faker->sentence;
        }
    }

    /**
     * Indicate that the attribute is text type.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function text()
    {
        return $this->state(function (array $attributes) {
            return [
                'attribute_type' => 'text',
                'attribute_value' => $this->faker->sentence,
            ];
        });
    }

    /**
     * Indicate that the attribute is number type.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function number()
    {
        return $this->state(function (array $attributes) {
            return [
                'attribute_type' => 'number',
                'attribute_value' => (string) $this->faker->randomFloat(2, 0, 1000),
            ];
        });
    }

    /**
     * Indicate that the attribute is boolean type.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function boolean()
    {
        return $this->state(function (array $attributes) {
            return [
                'attribute_type' => 'boolean',
                'attribute_value' => $this->faker->boolean ? '1' : '0',
            ];
        });
    }

    /**
     * Indicate that the attribute is json type.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function json()
    {
        return $this->state(function (array $attributes) {
            return [
                'attribute_type' => 'json',
                'attribute_value' => json_encode([
                    'width' => $this->faker->numberBetween(100, 2000),
                    'height' => $this->faker->numberBetween(100, 2000),
                    'color_space' => $this->faker->randomElement(['RGB', 'CMYK', 'Grayscale']),
                ]),
            ];
        });
    }
}
