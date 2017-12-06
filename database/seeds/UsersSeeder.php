<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{

    protected $count = 20;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DEFAULT USER
        $this->createDefaultUser();

        factory(\User::class, $this->count)->create();
    }

    protected function createDefaultUser()
    {
        $login = env('DEFAULT_USER_LOGIN');
        $email = env('DEFAULT_USER_EMAIL');
        $pass  = env('DEFAULT_USER_PASSWORD');

        $data = [];

        if ($login) {
            $data['login'] = $login;
        }

        if ($email) {
            $data['email'] = $email;
        }

        if ($pass) {
            $data['password'] = bcrypt($pass);
        }

        /** @var \App\Models\User $user */
        $user = factory(\User::class)->create($data);

        $this->command->info('Default data');
        $this->command->table(
            ['Name', 'Surname', 'Login', 'Email', 'Password'],
            [[ $user->first_name, $user->last_name, $user->login, $user->email, $pass ?: 'secret' ]]
        );
    }
}
