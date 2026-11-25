<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'mhs@example.com'],
            [
                'name' => 'Mahasiswa',
                'password' => Hash::make('password'),
            ]
        );

        $data = [
            ['Tugas Case 3 DKP', 'tinggi', 'pending'],
            ['Baca materi Livewire', 'sedang', 'pending'],
            ['Kerjakan laporan praktikum', 'tinggi', 'pending'],
            ['Rapikan catatan kuliah', 'rendah', 'selesai'],
            ['Belajar Tailwind CSS', 'sedang', 'selesai'],
        ];

        foreach ($data as $i => [$title, $priority, $status]) {
            Task::updateOrCreate(
                ['user_id' => $user->id, 'title' => $title],
                [
                    'description' => 'Deskripsi untuk ' . $title,
                    'priority' => $priority,
                    'status' => $status,
                    'deadline' => now()->addDays($i + 1),
                ]
            );
        }
    }
}
