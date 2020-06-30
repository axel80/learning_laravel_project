<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Step 1
        Storage::deleteDirectory('courses');
        Storage::deleteDirectory('users');

        // Step 2
        Storage::makeDirectory('courses');
        Storage::makeDirectory('users');

        factory(\App\Role::class,1)->create(['name' => 'admin']);
        factory(\App\Role::class,1)->create(['name' => 'teacher']);
        factory(\App\Role::class,1)->create(['name' => 'student']);

        factory(\App\User::class,1)->create([
            'name'      => 'admin',
            'email'     => 'admin@mail.com',
            'password'  => bcrypt('secret'),
            'role_id'   => \App\Role::ADMIN
        ])
        ->each(function(\App\User $user){
            factory(\App\Student::class,1)->create(['user_id' => $user->id]);
        });
        
        factory(\App\User::class,10)->create()
            ->each(function(\App\User $user){
                factory(\App\Student::class, 1)->create(['user_id' => $user->id]);
                });
        factory(\App\User::class,10)->create()
            ->each(function(\App\User $user){
                factory(\App\Teacher::class, 1)->create(['user_id' => $user->id]);
                factory(\App\Student::class, 1)->create(['user_id' => $user->id]);
            });

        factory(\App\Level::class,1)->create(['name' => 'Beginner']);
        factory(\App\Level::class,1)->create(['name' => 'Intermediate']);
        factory(\App\Level::class,1)->create(['name' => 'Advance']);
        factory(\App\Category::class,5)->create();

        factory(\App\Course::class, 50)
            ->create()
            ->each(function (\App\Course $c) {
                $c->goals()->saveMany(factory(\App\Goal::class, 2)->create());
                $c->requirements()->saveMany(factory(\App\Requirement::class, 4)->create());
            });




    }
}
