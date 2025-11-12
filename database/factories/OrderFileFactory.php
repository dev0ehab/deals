<?php

namespace Database\Factories\Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Orders\Entities\Order;

class OrderFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fileTypes = ['pdf', 'doc', 'docx', 'txt', 'jpg', 'png', 'gif'];
        $mimeTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'text/plain',
            'image/jpeg',
            'image/png',
            'image/gif'
        ];

        $fileType = $this->faker->randomElement($fileTypes);
        $mimeType = $this->faker->randomElement($mimeTypes);
        $fileName = $this->faker->word . '.' . $fileType;

        return [
            'order_id' => Order::factory(),
            'file_name' => $fileName,
            'file_path' => 'orders/' . $this->faker->uuid . '/' . $fileName,
            'file_type' => $fileType,
            'file_size' => $this->faker->numberBetween(1024, 10485760), // 1KB to 10MB
            'mime_type' => $mimeType,
            'description' => $this->faker->optional()->sentence(),
            'is_processed' => $this->faker->boolean(70), // 70% chance of being processed
        ];
    }

    /**
     * Indicate that the file is processed.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function processed()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_processed' => true,
            ];
        });
    }

    /**
     * Indicate that the file is unprocessed.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unprocessed()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_processed' => false,
            ];
        });
    }

    /**
     * Indicate that the file is an image.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function image()
    {
        return $this->state(function (array $attributes) {
            $imageTypes = ['jpg', 'png', 'gif', 'webp'];
            $imageMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

            $fileType = $this->faker->randomElement($imageTypes);
            $mimeType = $this->faker->randomElement($imageMimeTypes);
            $fileName = $this->faker->word . '.' . $fileType;

            return [
                'file_name' => $fileName,
                'file_type' => $fileType,
                'mime_type' => $mimeType,
            ];
        });
    }

    /**
     * Indicate that the file is a document.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function document()
    {
        return $this->state(function (array $attributes) {
            $docTypes = ['pdf', 'doc', 'docx', 'txt'];
            $docMimeTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'text/plain'
            ];

            $fileType = $this->faker->randomElement($docTypes);
            $mimeType = $this->faker->randomElement($docMimeTypes);
            $fileName = $this->faker->word . '.' . $fileType;

            return [
                'file_name' => $fileName,
                'file_type' => $fileType,
                'mime_type' => $mimeType,
            ];
        });
    }
}
