<?php

namespace Task;

use DateTime;
use Task\DataBase\Db;
use Task\Validation\Validation;

/**
 * User
 */
class User
{
    /**
     * Full user age
     *
     * @var integer
     */
    private int $fullAge = 0;

    /**
     * Сonstruct function
     *
     * @param integer $id
     * @param string $firstName
     * @param string $lastName
     * @param string $birthdate
     * @param integer $gender
     * @param string $city
     */
    public function __construct(
        public int $id,
        public string $firstName = 'Имя',
        public string $lastName = 'Фамилия',
        public string $birthdate = '2000-12-12',
        public int|string $gender = 0,
        public string $city = 'Минск'
    ) {
        $validation = new Validation;
        $validation->сyrillic($firstName);
        $validation->сyrillic($lastName);
        $validation->date($birthdate);
        $validation->binary($gender);
        $validation->сyrillic($city);

        $this->checkOrCreate();
    }

    /**
     * User verification and creation function
     * 
     * If the user exists, we get his data
     * If the user does not exist, we create it
     * 
     * @return void
     */
    private function checkOrCreate(): void
    {
        $user = DB::query()->select([$this->id]);
        if ($user) {
            $this->firstName = $user['firstname'];
            $this->lastName = $user['lastname'];
            $this->birthdate = $user['birthdate'];
            $this->gender = $user['gender'];
            $this->city = $user['city'];
        } else {
            $this->create();
        }
    }

    /**
     * Create user function
     *
     * @return void
     */
    private function create(): void
    {
        DB::query()->insert([
            $this->id,
            $this->firstName,
            $this->lastName,
            $this->birthdate,
            $this->gender,
            $this->city
        ]);
    }

    /**
     * User deletion function
     *
     * @return void
     */
    public function delete(): void
    {
        DB::query()->delete([$this->id]);
    }

    /**
     * Function for formatting date of birth to full age
     *
     * @param string $birthdate
     * @return string
     */
    private static function formattingBirthdate(string $birthdate): string
    {
        $date = new DateTime($birthdate);
        $dateNow = new DateTime("now");
        $fullAge = $date->diff($dateNow);

        return $fullAge->y;
    }

    /**
     * Formatting the gender from binary to text system
     *
     * @param integer $gender
     * @return string
     */
    private static function formattingGender(int $gender): string
    {
        return match ($gender) {
            0 => 'муж',
            1 => 'жен'
        };
    }

    /**
     * Function for formatting the user by parameters
     *
     * @param string $formatType "age" or "gender"
     * 
     * @return User
     */
    public function formatting(string $formatType = 'default'): User
    {
        switch ($formatType) {
            case "age":
                $this->fullAge = self::formattingBirthdate($this->birthdate);
                break;
            case "gender":
                $this->gender = self::formattingGender($this->gender);
                break;
            default:
                $this->fullAge = self::formattingBirthdate($this->birthdate);
                $this->gender = self::formattingGender($this->gender);
                break;
        }

        return new User($this->id);
    }

    /**
     * Function for obtaining class properties for a test
     *
     * @param string $name
     * @return void
     */
    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }
}
