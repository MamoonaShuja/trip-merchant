<?php

namespace Modules\Admin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\User\Enum\UserType;
use Symfony\Component\Console\Input\InputOption;
use Modules\User\Contracts\Repositories\UserRepositoryContract;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating Admin.';

    /**
     * @param UserRepositoryContract $objUserRepository
     */
    public function __construct(private readonly UserRepositoryContract $objUserRepository)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $first_name = $this->askValid('Enter First Name' , 'First Name'  , ['required','min:3']);
        $last_name = $this->askValid('Enter Last Name' , 'Last Name'  , ['required','min:3']);
        $email = $this->askValid('Enter Email' , 'Email'  , ['required','email' , "unique:users"]);
        $password = $this->askValid('Enter Password' , 'Password'  , ['required','min:6'] , true);
        $this->objUserRepository->create($first_name,$last_name , $email , Hash::make($password) , null , null , null , null , null  , UserType::ADMIN);
        echo "Admin created Successfully\n";
    }

    /**
     * @param $question
     * @param $field
     * @param $rules
     * @param $isSecret
     * @return mixed
     */
    protected function askValid($question, $field, $rules , $isSecret = false)
    {
        $isSecret ? $value = $this->secret($question) : $value = $this->ask($question);

        if($message = $this->validateInput($rules, $field, $value)) {
            $this->error($message);
            return $this->askValid($question, $field, $rules , $isSecret);
        }

        return $value;
    }

    /**
     * @param $rules
     * @param $fieldName
     * @param $value
     * @return string|null
     */
    protected function validateInput($rules, $fieldName, $value)
    {
        $validator = Validator::make([
            $fieldName => $value
        ], [
            $fieldName => $rules
        ],
            [
                $fieldName.".min" => $fieldName." should be at least :min characters",
                $fieldName.".required" => $fieldName." is required",
                $fieldName.".email" => $fieldName." should be a valid email",
                $fieldName.".unique" => $fieldName." should be unique",
            ]
        );

        return $validator->fails()
            ? $validator->errors()->first($fieldName)
            : null;
    }
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['name', null, InputOption::VALUE_OPTIONAL, 'A option.', null],
        ];
    }
}
