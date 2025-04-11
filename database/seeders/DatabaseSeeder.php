<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Project;
use App\Models\Volunteer;
use App\Models\Donation;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // إضافة الأدوار والصلاحيات - تم تعطيلها لأنها موجودة بالفعل
        // $this->call([
        //     RoleSeeder::class,
        // ]);

        // إنشاء المستخدمين
        $admin = User::factory()->create([
            'name' => 'مدير النظام',
            'email' => 'admin@jusoor.com',
        ]);
        $admin->assignRole('admin');

        $projectManager = User::factory()->create([
            'name' => 'مدير المشاريع',
            'email' => 'manager@jusoor.com',
        ]);
        $projectManager->assignRole('moderator');

        $donor = User::factory()->create([
            'name' => 'متبرع',
            'email' => 'donor@jusoor.com',
        ]);
        $donor->assignRole('user');

        // إنشاء 5 مستخدمين إضافيين
        $users = User::factory(5)->create();
        foreach ($users as $user) {
            $user->assignRole('user');
        }

        // إنشاء المشاريع
        $projects = [
            [
                'title' => 'مشروع إعادة بناء مدرسة',
                'description' => 'مشروع لإعادة بناء وتأهيل مدرسة متضررة في حلب، لتمكين الأطفال من العودة للدراسة في بيئة آمنة ومناسبة.',
                'target_amount' => 50000,
                'current_amount' => 15000,
                'location' => 'حلب',
                'status' => 'active',
                'start_date' => '2025-04-01',
                'end_date' => '2025-08-30',
                'image' => 'projects/school.jpg',
                'user_id' => $projectManager->id,
            ],
            [
                'title' => 'توفير المستلزمات الطبية',
                'description' => 'مشروع لتوفير المستلزمات والأجهزة الطبية للمستشفيات المتضررة في دمشق.',
                'target_amount' => 75000,
                'current_amount' => 35000,
                'location' => 'دمشق',
                'status' => 'active',
                'start_date' => '2025-03-15',
                'end_date' => '2025-07-15',
                'image' => 'projects/medical.jpg',
                'user_id' => $projectManager->id,
            ],
            [
                'title' => 'الحفاظ على التراث الثقافي',
                'description' => 'مشروع للحفاظ على المواقع التراثية والثقافية في تدمر وترميمها بعد تعرضها للتدمير.',
                'target_amount' => 120000,
                'current_amount' => 55000,
                'location' => 'تدمر',
                'status' => 'active',
                'start_date' => '2025-05-01',
                'end_date' => '2025-11-30',
                'image' => 'projects/cultural.jpg',
                'user_id' => $projectManager->id,
            ],
            [
                'title' => 'دعم المزارعين المحليين',
                'description' => 'مشروع لدعم المزارعين المحليين في الريف السوري وتزويدهم بالمعدات والبذور للمساعدة في استعادة الإنتاج الزراعي.',
                'target_amount' => 35000,
                'current_amount' => 12000,
                'location' => 'ريف دمشق',
                'status' => 'pending',
                'start_date' => '2025-06-01',
                'end_date' => '2025-10-30',
                'image' => 'projects/agriculture.jpg',
                'user_id' => $users[0]->id,
            ],
            [
                'title' => 'مركز تدريب مهني للشباب',
                'description' => 'مشروع لإنشاء مركز تدريب مهني للشباب في حمص، لتزويدهم بالمهارات اللازمة لسوق العمل.',
                'target_amount' => 85000,
                'current_amount' => 32000,
                'location' => 'حمص',
                'status' => 'active',
                'start_date' => '2025-04-15',
                'end_date' => '2025-09-15',
                'image' => 'projects/training.jpg',
                'user_id' => $projectManager->id,
            ],
        ];

        foreach ($projects as $projectData) {
            Project::create($projectData);
        }

        // إنشاء المتطوعين
        $volunteers = [
            [
                'skills' => 'تصميم جرافيك، تطوير ويب، إدارة مشاريع',
                'availability' => 'متاح أيام السبت والأحد، 5 ساعات يومياً',
                'status' => 'approved',
                'notes' => 'لدي خبرة سابقة في العمل التطوعي في مجال التعليم.',
                'user_id' => $users[1]->id,
                'project_id' => 1,
            ],
            [
                'skills' => 'ممرض مؤهل، إسعافات أولية، رعاية صحية',
                'availability' => 'مساءً من الساعة 5 إلى 9 في أيام الأسبوع',
                'status' => 'pending',
                'notes' => 'أعمل في القطاع الصحي منذ 5 سنوات.',
                'user_id' => $users[2]->id,
                'project_id' => 2,
            ],
            [
                'skills' => 'علم آثار، ترميم، توثيق',
                'availability' => 'متفرغ خلال عطلة الصيف',
                'status' => 'approved',
                'notes' => 'درست علم الآثار وأرغب في المساهمة في الحفاظ على التراث السوري.',
                'user_id' => $users[3]->id,
                'project_id' => 3,
            ],
            [
                'skills' => 'هندسة زراعية، إدارة موارد طبيعية',
                'availability' => 'متاح يومياً من 10 صباحاً حتى 3 عصراً',
                'status' => 'rejected',
                'notes' => 'لدي معرفة بأساليب الزراعة المستدامة.',
                'user_id' => $users[4]->id,
                'project_id' => 4,
            ],
            [
                'skills' => 'تدريس، توجيه مهني، تقنية معلومات',
                'availability' => 'مساءً من الساعة 4 إلى 8 في أيام الأسبوع',
                'status' => 'pending',
                'notes' => 'أرغب في مساعدة الشباب لتطوير مهاراتهم التقنية.',
                'user_id' => $donor->id,
                'project_id' => 5,
            ],
        ];

        foreach ($volunteers as $volunteerData) {
            Volunteer::create($volunteerData);
        }

        // إنشاء التبرعات
        $donations = [
            [
                'amount' => 1000,
                'status' => 'completed',
                'transaction_id' => 'TR' . rand(100000, 999999),
                'payment_method' => 'بطاقة ائتمان',
                'message' => 'أتمنى التوفيق لهذا المشروع الرائع.',
                'user_id' => $donor->id,
                'project_id' => 1,
            ],
            [
                'amount' => 500,
                'status' => 'completed',
                'transaction_id' => 'TR' . rand(100000, 999999),
                'payment_method' => 'PayPal',
                'message' => 'مساهمة متواضعة لدعم القطاع الصحي.',
                'user_id' => $users[1]->id,
                'project_id' => 2,
            ],
            [
                'amount' => 2000,
                'status' => 'completed',
                'transaction_id' => 'TR' . rand(100000, 999999),
                'payment_method' => 'تحويل بنكي',
                'message' => 'الحفاظ على التراث الثقافي واجب علينا جميعاً.',
                'user_id' => $users[2]->id,
                'project_id' => 3,
            ],
            [
                'amount' => 750,
                'status' => 'pending',
                'transaction_id' => 'TR' . rand(100000, 999999),
                'payment_method' => 'بطاقة ائتمان',
                'message' => 'دعم للمزارعين السوريين.',
                'user_id' => $users[3]->id,
                'project_id' => 4,
            ],
            [
                'amount' => 1500,
                'status' => 'completed',
                'transaction_id' => 'TR' . rand(100000, 999999),
                'payment_method' => 'PayPal',
                'message' => 'أتمنى أن يساعد هذا المركز الشباب السوري على تحقيق مستقبل أفضل.',
                'user_id' => $users[4]->id,
                'project_id' => 5,
            ],
        ];

        foreach ($donations as $donationData) {
            Donation::create($donationData);
        }
    }
}
