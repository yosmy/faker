<?php

namespace Yosmy;

use Faker;

/**
 * @di\service()
 */
class GenerateFake
{
    const COUNTRY_CODE_2 = 'cca2';
    const COUNTRY_CALLING_CODE = 'callingCode';

    /**
     * @var Faker\Generator
     */
    private $faker;

    /**
     */
    public function __construct()
    {
        $this->faker = Faker\Factory::create();;
    }

    /**
     * @param string $field
     *
     * @return array
     */
    public function generateCountries($field)
    {
        $items = json_decode(
            file_get_contents(sprintf('%s/../data/countries.json', __DIR__)),
            true
        );

        $countries = [];
        foreach ($items as $item) {
            $country = null;
            if ($field == self::COUNTRY_CODE_2) {
                $country = $item[$field];
            } else if ($field == self::COUNTRY_CALLING_CODE) {
                $country = $item[$field][0];
            }

            if ($country !== null) {
                $countries[] = $country;
            }
        }

        return $countries;
    }

    /**
     * @param int|null $digits
     *
     * @return int
     */
    public function generateInteger($digits = null)
    {
        return $this->faker->randomNumber($digits);
    }

    /**
     * @param int|null $decimals
     * @param float|null $min
     * @param float|null $max
     *
     * @return float
     */
    public function generateFloat($decimals = null, $min = null, $max = null)
    {
        return $this->faker->randomFloat($decimals, $min, $max);
    }

    /**
     * @return string
     */
    public function generateWord()
    {
        return $this->faker->word;
    }

    /**
     * @return string
     */
    public function generateName()
    {
        return $this->faker->name;
    }

    /**
     * @param string|null $country
     *
     * @return string
     */
    public function generatePhoneNumber($country = null)
    {
        if ($country === null) {
            $countries = $this->generateCountries(self::COUNTRY_CALLING_CODE);
            $country = $countries[rand(0, count($countries) - 1)];
        }

        return $this->faker->numerify(sprintf('+%s##########', $country));
    }

    /**
     * @param string|null $from
     *
     * @return int
     */
    public function generateTimestamp($from = null)
    {
        return $this->faker->dateTimeBetween($from)->getTimestamp();
    }
}