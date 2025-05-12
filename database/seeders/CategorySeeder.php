<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Law', 'Labour', 'Information Technology (IT)', 'Healthcare', 'Education',
            'Engineering', 'Finance', 'Marketing', 'Sales', 'Human Resources',
            'Construction', 'Customer Service', 'Hospitality', 'Manufacturing', 'Creative Arts',
            'Retail', 'Transportation', 'Real Estate', 'Science and Research', 'Design',
            'Consulting', 'Administration', 'Telecommunications', 'Social Services', 'Logistics',
            'Media and Journalism', 'Aviation', 'Tourism', 'Government and Public Sector'
        ];


        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
            ]);
        }
    }
}
