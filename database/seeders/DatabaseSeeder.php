<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed categories
        $categories = [
            ['name' => 'Développement web', 'slug' => 'dev-web', 'icon' => '💻'],
            ['name' => 'Design & Graphisme', 'slug' => 'design', 'icon' => '🎨'],
            ['name' => 'Rédaction & Traduction', 'slug' => 'redaction', 'icon' => '✍️'],
            ['name' => 'Marketing Digital', 'slug' => 'marketing', 'icon' => '📱'],
            ['name' => 'Vidéo & Animation', 'slug' => 'video', 'icon' => '🎬'],
            ['name' => 'Comptabilité & Finance', 'slug' => 'comptabilite', 'icon' => '📊'],
            ['name' => 'IT & Systèmes', 'slug' => 'it-systemes', 'icon' => '🔧'],
            ['name' => 'Service client', 'slug' => 'service-client', 'icon' => '📞'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }

        // Test client user
        User::factory()->create([
            'name' => 'Mamadou Diallo',
            'email' => 'client@workconnect.sn',
            'role' => 'client',
            'phone' => '+221771234567',
            'location' => 'Dakar, Sénégal',
        ]);

        // Test freelance user
        User::factory()->create([
            'name' => 'Aissatou Ba',
            'email' => 'freelance@workconnect.sn',
            'role' => 'freelance',
            'phone' => '+221779876543',
            'location' => 'Dakar, Sénégal',
            'bio' => 'Développeuse web fullstack avec 5 ans d\'expérience. Spécialisée Laravel et Vue.js.',
            'skills' => ['Laravel', 'Vue.js', 'MySQL', 'TailwindCSS'],
        ]);
    }
}
