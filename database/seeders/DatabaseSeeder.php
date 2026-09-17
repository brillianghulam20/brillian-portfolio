<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\ProjectCategory;
use App\Models\Setting;
use App\Models\SkillCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminPassword = env('ADMIN_PASSWORD');
        if (! $adminPassword && app()->environment('production')) {
            throw new \RuntimeException('ADMIN_PASSWORD wajib diatur sebelum menjalankan seeder production.');
        }
        User::query()->updateOrCreate(['email' => env('ADMIN_EMAIL', 'admin@brillianghulam.com')], [
            'name' => env('ADMIN_NAME', 'Brillian Ghulam'),
            'password' => Hash::make($adminPassword ?: 'ChangeMe123!'),
        ]);

        $resumePath = 'resume/CV-Brillian-Ghulam.pdf';
        if (file_exists(database_path('seeders/assets/CV-Brillian-Ghulam.pdf'))) {
            Storage::disk('public')->put($resumePath, file_get_contents(database_path('seeders/assets/CV-Brillian-Ghulam.pdf')));
        }
        $photoPath = 'profile/brillian-ghulam.jpg';
        if (file_exists(database_path('seeders/assets/profile.jpg'))) {
            Storage::disk('public')->put($photoPath, file_get_contents(database_path('seeders/assets/profile.jpg')));
        }

        Profile::query()->updateOrCreate(['email' => 'brillianghulam@gmail.com'], [
            'name' => 'Brillian Ghulam Ash Shidiq',
            'title' => 'System Analyst & ERP Implementor',
            'tagline' => 'Saya menganalisis proses bisnis, merancang sistem, dan mengubah kebutuhan menjadi solusi yang dapat digunakan.',
            'summary' => 'System Analyst berlatar belakang Teknik Informatika dengan pengalaman dalam analisis kebutuhan, perancangan proses bisnis, implementasi ERP, pengembangan aplikasi, validasi data, dan koordinasi lintas fungsi. Saya berfokus menjembatani kebutuhan pengguna dengan solusi teknologi yang terukur dan terdokumentasi.',
            'location' => 'Indonesia',
            'phone' => '+62 817-1753-9575',
            'linkedin_url' => 'https://linkedin.com/in/brillian-ghulam/',
            'whatsapp_url' => 'https://wa.me/6281717539575',
            'photo_path' => $photoPath,
            'resume_path' => $resumePath,
        ]);

        $experiences = [
            ['company' => 'PT. BEHAESTEX', 'position' => 'System Analyst', 'started_at' => '2025-10-01', 'is_current' => true, 'description' => 'Menerjemahkan kebutuhan user dan proses bisnis menjadi rancangan sistem, spesifikasi fungsional, serta implementasi yang terukur.', 'responsibilities' => ['Analisis kebutuhan user dan business process untuk pengembangan serta improvement ERP', 'Pembuatan flow process, system requirement, dan functional specification', 'Analisis database, SQL query, validasi data, dan troubleshooting system', 'Koordinasi user, developer, dan stakeholder selama development dan implementasi', 'Penyusunan test case, UAT, trial, training, dan implementasi sistem', 'Perancangan integrasi dan sinkronisasi data antar sistem', 'Pembuatan dashboard, report, monitoring data, SOP, dan user guide'], 'technologies' => ['ERP', 'SQL', 'BPMN', 'UAT'], 'sort_order' => 1],
            ['company' => 'PT. BEHAESTEX', 'position' => 'ERP Implementor', 'started_at' => '2023-10-01', 'ended_at' => '2025-10-01', 'description' => 'Mendampingi pengembangan, pengujian, dan implementasi ERP untuk proses operasional perusahaan.', 'responsibilities' => ['Merancang flow proses untuk pengembangan ERP', 'Test case, trial, training, dan implementasi ERP', 'Membuat bridging data, cron job, dan API', 'Analisis program dan data serta problem solving error ERP'], 'technologies' => ['ERP', 'API', 'SQL', 'Cron'], 'sort_order' => 2],
            ['company' => 'Digital Talent Scholarship - Fresh Graduate Academy', 'position' => 'Data Analyst', 'started_at' => '2022-09-01', 'ended_at' => '2022-10-31', 'description' => 'Pelatihan intensif fundamental Python, SQL, eksplorasi data, dan visualisasi.', 'responsibilities' => ['Python fundamental untuk data science', 'Fundamental SQL', 'Eksplorasi dan analisis data COVID-19 Indonesia'], 'technologies' => ['Python', 'SQL', 'Matplotlib'], 'sort_order' => 3],
            ['company' => 'PSIK FILKOM Universitas Brawijaya', 'position' => 'Website Developer Intern', 'started_at' => '2020-08-01', 'ended_at' => '2020-11-30', 'description' => 'Mengembangkan website YP3B Malang menggunakan pendekatan SDLC waterfall.', 'responsibilities' => ['Analisis kebutuhan website', 'Pengembangan dan pengujian website organisasi'], 'technologies' => ['Laravel', 'WordPress', 'PHP'], 'sort_order' => 4],
        ];
        foreach ($experiences as $experience) {
            Experience::query()->updateOrCreate(['company' => $experience['company'], 'position' => $experience['position']], $experience);
        }

        Education::query()->updateOrCreate(['institution' => 'Universitas Brawijaya'], ['degree' => 'Sarjana', 'major' => 'Teknik Informatika', 'start_year' => 2017, 'end_year' => 2022, 'description' => 'IPK 3.40', 'sort_order' => 1]);
        Education::query()->updateOrCreate(['institution' => 'MA Unggulan Amanatul Ummah'], ['degree' => 'Program Akselerasi', 'major' => 'IPA', 'start_year' => 2015, 'end_year' => 2017, 'sort_order' => 2]);

        $skillGroups = [
            'System Analysis' => ['Requirement Gathering', 'Business Process Analysis', 'BPMN', 'System Design', 'Database Design'],
            'ERP & Implementation' => ['ERP Implementation', 'UAT', 'Training', 'Process Mapping', 'Data Validation'],
            'Development' => ['PHP', 'Laravel', 'JavaScript', 'HTML & CSS', 'REST API'],
            'Data & Automation' => ['SQL', 'PostgreSQL', 'MySQL', 'Python', 'Excel', 'Google Sheets'],
        ];
        foreach ($skillGroups as $index => $skills) {
            $category = SkillCategory::query()->updateOrCreate(['name' => $index], ['sort_order' => array_search($index, array_keys($skillGroups), true) + 1]);
            foreach ($skills as $order => $skill) {
                $category->skills()->updateOrCreate(['name' => $skill], ['sort_order' => $order + 1]);
            }
        }

        foreach (['TOEFL ITP - Score 557' => 'Institutional TOEFL', 'Data Analyst' => 'DQLab', 'Microsoft Office Desktop Application' => 'Microsoft Partner', 'SQL Intermediate' => 'HackerRank', 'Problem Solving Intermediate' => 'HackerRank'] as $name => $issuer) {
            Certificate::query()->updateOrCreate(['name' => $name], ['issuer' => $issuer]);
        }

        $projects = [
            ['category' => 'Automation', 'name' => 'WhatsApp Finance Bot', 'eyebrow' => 'Automation / Personal Finance', 'short_description' => 'Asisten pencatatan finansial berbasis perintah percakapan dengan integrasi spreadsheet.', 'problem' => 'Pencatatan transaksi manual mudah terlewat dan informasi cicilan tersebar, sehingga pengguna sulit memperoleh ringkasan keuangan dengan cepat.', 'objective' => 'Menyederhanakan pencatatan transaksi dan pencarian informasi finansial melalui pola interaksi yang familiar.', 'solution' => 'Bot menerjemahkan perintah singkat menjadi transaksi atau query terstruktur, lalu membaca dan menulis data pada spreadsheet.', 'role' => 'Analisis kebutuhan, perancangan command flow, data structure, automation, dan pengujian.', 'business_process' => 'Pengguna mengirim perintah, sistem memvalidasi intent dan nilai, data diproses, lalu bot mengembalikan konfirmasi atau ringkasan.', 'architecture' => 'WhatsApp interface → command parser → automation service → Google Sheets → formatted response.', 'challenges' => 'Menjaga variasi command tetap mudah digunakan sekaligus dapat divalidasi dengan konsisten.', 'result' => 'Prototype menunjukkan proses pencatatan dan pencarian data dapat dipersingkat melalui percakapan.', 'lessons_learned' => 'Command sederhana dan feedback yang jelas lebih penting daripada menambah banyak variasi sintaks.', 'features' => ['Pencatatan pengeluaran', 'Pengecekan cicilan', 'Filter periode', 'Ringkasan otomatis'], 'technologies' => ['Google Apps Script', 'Google Sheets', 'WhatsApp Bot'], 'platform' => 'Chat automation', 'database' => 'Google Sheets', 'project_year' => 2026],
            ['category' => 'Data Analysis', 'name' => 'Automatic Data Comparison', 'eyebrow' => 'Data Automation / Reconciliation', 'short_description' => 'Alat rekonsiliasi yang menemukan match, mismatch, dan record yang hilang di dua sumber data.', 'problem' => 'Perbandingan dataset operasional berukuran besar secara manual memakan waktu dan berisiko menghasilkan kesalahan.', 'objective' => 'Mempercepat rekonsiliasi dan membuat penyebab perbedaan lebih mudah ditelusuri.', 'solution' => 'Sistem menormalisasi dua sumber, mencocokkan key, mengklasifikasikan hasil, dan menyajikan ringkasan serta detail perbedaan.', 'role' => 'Analisis rule comparison, data mapping, pengembangan proses rekonsiliasi, dan validasi hasil.', 'business_process' => 'Upload source dan comparison → validasi struktur → normalisasi → compare → klasifikasi → export hasil.', 'architecture' => 'File input → validator → normalization service → comparison engine → result dashboard.', 'challenges' => 'Perbedaan tipe data, format tanggal, key tidak unik, dan nilai kosong antar sumber.', 'result' => 'Alur comparison yang repeatable mengurangi pemeriksaan manual dan membuat exception lebih terarah.', 'lessons_learned' => 'Rule normalisasi harus transparan agar hasil rekonsiliasi dapat diaudit.', 'features' => ['Summary hasil', 'Mismatch detection', 'Only source/comparison', 'Detail analysis'], 'technologies' => ['Python', 'SQL', 'DBF', 'Data Analysis'], 'platform' => 'Web / data processing', 'database' => 'File & SQL', 'project_year' => 2026],
            ['category' => 'Enterprise Application', 'name' => 'Document Tracking System', 'eyebrow' => 'Enterprise Application / System Analysis', 'short_description' => 'Sistem pelacakan dokumen dengan QR code, flexible routing, current custodian, dan audit trail.', 'problem' => 'Perpindahan dokumen lintas departemen sulit dilacak dan status kepemilikan terakhir tidak selalu terdokumentasi.', 'objective' => 'Menyediakan jejak perpindahan dokumen yang jelas, fleksibel, dan dapat diaudit.', 'solution' => 'Setiap dokumen memiliki tracking number dan QR code. Serah terima dicatat melalui accept/reject sehingga current custodian dan timeline selalu diperbarui.', 'role' => 'Requirement gathering, business process design, system analysis, database design, testing, UAT, dan implementation support.', 'business_process' => 'Create document → generate QR → handover → accept/reject → update custodian → timeline & audit trail.', 'architecture' => 'User roles → web application → business rules → tracking service → relational database.', 'challenges' => 'Mendukung rute dokumen yang fleksibel tanpa kehilangan kontrol dan auditability.', 'result' => 'Rancangan menyediakan single source of truth untuk posisi dokumen dan histori serah terima.', 'lessons_learned' => 'Status, ownership, dan event history harus dimodelkan terpisah agar tracking tetap akurat.', 'features' => ['Tracking number', 'QR code', 'Universal handover', 'Accept & reject', 'Current custodian', 'Tracking timeline', 'Audit trail'], 'technologies' => ['Laravel', 'PHP', 'PostgreSQL', 'JavaScript'], 'platform' => 'Responsive web application', 'database' => 'PostgreSQL', 'project_year' => 2026],
        ];
        $projectThumbnails = [
            'whatsapp-finance-bot' => 'project-finance-bot.svg',
            'automatic-data-comparison' => 'project-data-comparison.svg',
            'document-tracking-system' => 'project-document-tracking.svg',
        ];
        foreach ($projects as $order => $data) {
            $category = ProjectCategory::query()->firstOrCreate(['slug' => Str::slug($data['category'])], ['name' => $data['category']]);
            unset($data['category']);
            $slug = Str::slug($data['name']);
            $thumbnailPath = 'projects/'.$projectThumbnails[$slug];
            $thumbnailSource = database_path('seeders/assets/'.$projectThumbnails[$slug]);
            if (file_exists($thumbnailSource)) {
                Storage::disk('public')->put($thumbnailPath, file_get_contents($thumbnailSource));
            }
            $category->projects()->updateOrCreate(['slug' => $slug], array_merge($data, ['project_category_id' => $category->id, 'thumbnail_path' => $thumbnailPath, 'publishing_status' => 'published', 'project_status' => 'Case Study', 'is_featured' => true, 'sort_order' => $order + 1, 'seo_title' => $data['name'].' | Brillian Ghulam', 'meta_description' => $data['short_description']]));
        }

        foreach (['site_description' => 'Portfolio Brillian Ghulam, System Analyst dan ERP Implementor yang berfokus pada proses bisnis, sistem, data, dan automation.', 'availability' => 'Terbuka untuk peluang dan kolaborasi profesional'] as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
