<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CheckItem;

class CheckItemSeeder extends Seeder
{
    public function run(): void
    {
        CheckItem::truncate();

        $items = [
            // MAN
            ['category' => 'MAN', 'item_number' => 1,  'item_name' => 'Seragam',                     'standard' => 'Menggunakan Seragam resmi Perusahaan'],
            ['category' => 'MAN', 'item_number' => 2,  'item_name' => 'Sepatu Safety',                'standard' => 'Menggunakan sepatu safety'],
            ['category' => 'MAN', 'item_number' => 3,  'item_name' => 'Helmet',                       'standard' => 'Mengenakan helm safety'],
            ['category' => 'MAN', 'item_number' => 4,  'item_name' => 'Sarung Tangan',                'standard' => 'Mengenakan sarung tangan'],
            // Machine
            ['category' => 'Machine', 'item_number' => 5,  'item_name' => 'Lampu Utama (L/R)',            'standard' => 'Menyala (tidak redup)'],
            ['category' => 'Machine', 'item_number' => 6,  'item_name' => 'Lampu Sen Depan (L/R)',        'standard' => 'Menyala (tidak redup)'],
            ['category' => 'Machine', 'item_number' => 7,  'item_name' => 'Lampu Sen Belakang (L/R)',     'standard' => 'Menyala (tidak redup)'],
            ['category' => 'Machine', 'item_number' => 8,  'item_name' => 'Lampu Kabin Wing Box',         'standard' => 'Wajib ada & berfungsi dengan baik'],
            ['category' => 'Machine', 'item_number' => 9,  'item_name' => 'Buzzer Mundur',                'standard' => 'Bunyi terdengar dengan jelas'],
            ['category' => 'Machine', 'item_number' => 10, 'item_name' => 'Stopper Bak Truk',             'standard' => 'Proporsional dengan ban carrier (2-3 cm)'],
            ['category' => 'Machine', 'item_number' => 11, 'item_name' => 'Stopper Ban',                  'standard' => 'Dipasang (min bagian depan, 2 unit)'],
            ['category' => 'Machine', 'item_number' => 12, 'item_name' => 'Wing Box',                     'standard' => 'Tidak ada kebocoran'],
            ['category' => 'Machine', 'item_number' => 13, 'item_name' => 'Sensor Wing',                  'standard' => 'Berfungsi (Ada Bunyi)'],
            ['category' => 'Machine', 'item_number' => 14, 'item_name' => 'Wing Clamp (Toggle)',           'standard' => 'Bisa dibuka dan dikunci (tidak seret)'],
            ['category' => 'Machine', 'item_number' => 15, 'item_name' => 'Pintu-Pintu Truk',             'standard' => 'Bisa dibuka dan dikunci (tidak seret)'],
            ['category' => 'Machine', 'item_number' => 16, 'item_name' => 'Kondisi Ban (Fr/Rr)',           'standard' => 'Layak pakai, tidak botak, tidak kempes'],
            ['category' => 'Machine', 'item_number' => 17, 'item_name' => 'Ban Cadangan',                  'standard' => 'Layak pakai, tidak botak, tidak kempes'],
            ['category' => 'Machine', 'item_number' => 18, 'item_name' => 'Brake',                        'standard' => 'Tidak blong'],
            ['category' => 'Machine', 'item_number' => 19, 'item_name' => 'Handle Brake',                 'standard' => 'Tidak blong (Maksimal Tuas 30 derajat)'],
            ['category' => 'Machine', 'item_number' => 20, 'item_name' => 'Steering (Kemudi)',             'standard' => 'Balance, tidak seret'],
            ['category' => 'Machine', 'item_number' => 21, 'item_name' => 'Kaca Spion L/R',               'standard' => 'Dapat melihat blank spot'],
            ['category' => 'Machine', 'item_number' => 22, 'item_name' => 'Kaca Spion Depan',             'standard' => 'Dapat melihat blank spot'],
            ['category' => 'Machine', 'item_number' => 23, 'item_name' => 'Horn (Klakson)',                'standard' => 'Berfungsi (Ada Bunyi)'],
            ['category' => 'Machine', 'item_number' => 24, 'item_name' => 'Initial LP',                    'standard' => 'Ada di kepala truck & wing box'],
            ['category' => 'Machine', 'item_number' => 25, 'item_name' => 'Sticker Reflector (Samping)',  'standard' => 'Tersedia (kanan kiri - kuning)'],
            ['category' => 'Machine', 'item_number' => 26, 'item_name' => 'Sticker Reflector (Belakang)', 'standard' => 'Tersedia (belakang - merah)'],
            // Material
            ['category' => 'Material', 'item_number' => 27, 'item_name' => 'Kotak P3K',                   'standard' => 'Min: betadine, hansaplast, kapas'],
            ['category' => 'Material', 'item_number' => 28, 'item_name' => 'Segitiga Pengaman',            'standard' => 'Wajib ada dan berfungsi'],
            ['category' => 'Material', 'item_number' => 29, 'item_name' => 'Alat Pemadam Kebakaran',       'standard' => 'Ada dan tidak kadaluwarsa'],
            ['category' => 'Material', 'item_number' => 30, 'item_name' => 'Tools (Dongkrak, Kunci)',      'standard' => 'Wajib ada dan berfungsi'],
            ['category' => 'Material', 'item_number' => 31, 'item_name' => 'Majun & Chemical MOP',         'standard' => 'Wajib ada di area cabin'],
            // Document Control
            ['category' => 'Document Control', 'item_number' => 32, 'item_name' => 'Maintenance/Service Terakhir', 'standard' => 'Ada dan Update'],
            ['category' => 'Document Control', 'item_number' => 33, 'item_name' => 'Checksheet Safety Armada',     'standard' => 'Ada dan Update'],
            ['category' => 'Document Control', 'item_number' => 34, 'item_name' => 'SIM (Surat Ijin Mengemudi)',   'standard' => 'Ada dan Update'],
            ['category' => 'Document Control', 'item_number' => 35, 'item_name' => 'Surat Kesehatan Driver',       'standard' => 'Ada dan Update'],
            ['category' => 'Document Control', 'item_number' => 36, 'item_name' => 'Uji KIR Truck',                'standard' => 'Ada dan Update'],
            ['category' => 'Document Control', 'item_number' => 37, 'item_name' => 'STNK',                         'standard' => 'Ada dan Update'],
            // Environment
            ['category' => 'Environment', 'item_number' => 38, 'item_name' => 'Kebersihan',                        'standard' => 'Kondisi armada bersih'],
            // Safety Warning
            ['category' => 'Safety Warning', 'item_number' => 39, 'item_name' => 'Stiker Awas Terjepit',           'standard' => 'Tempel di area wing samping/belakang Truck'],
            ['category' => 'Safety Warning', 'item_number' => 40, 'item_name' => 'Stiker 15 Yamaha Prinsip Safety','standard' => 'Tempel di area cabin driver & terlihat jelas'],
        ];

        foreach ($items as $item) {
            CheckItem::create([
                'category'    => $item['category'],
                'item_number' => $item['item_number'],
                'item_name'   => $item['item_name'],
                'standard'    => $item['standard'],
                'is_active'   => true,
                'sort_order'  => $item['item_number'],
            ]);
        }
    }
}