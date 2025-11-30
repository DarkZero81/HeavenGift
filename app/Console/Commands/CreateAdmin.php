<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create';
    protected $description = 'Create an admin user';

    public function handle()
    {
        $name = 'مدير النظام';
        $email = 'admin@gifthaven.com';
        $password = 'admin123';

        // تحقق إذا المستخدم موجود مسبقاً
        if (User::where('email', $email)->exists()) {
            $this->error('⚠️  المستخدم موجود مسبقاً!');
            return;
        }

        // إنشاء المستخدم
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => true,
        ]);

        $this->info('✅ تم إنشاء مدير النظام بنجاح!');
        $this->line('📧 البريد الإلكتروني: ' . $email);
        $this->line('🔐 كلمة المرور: ' . $password);

        return 0;
    }
}
