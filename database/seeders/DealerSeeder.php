<?php

namespace Database\Seeders;

use App\Models\Dealer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DealerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dealers = [
            ['dealer_code' => 'FAFA001', 'dealer_name' => 'SENTRAL YAMAHA MEDAN', 'area' => 'MEDAN'],
            ['dealer_code' => 'FAFA003', 'dealer_name' => 'PT. ALFA SCORPII - SETIA BUDI', 'area' => 'MEDAN'],
            ['dealer_code' => 'FAFA006', 'dealer_name' => 'PT. ALFA SCORPII - AR HAKIM', 'area' => 'MEDAN'],
            ['dealer_code' => 'FAFA008', 'dealer_name' => 'PT. ALFA SCORPII - BILAL', 'area' => 'MEDAN'],
            ['dealer_code' => 'FAFA009', 'dealer_name' => 'PT. ALFA SCORPII - MARELAN', 'area' => 'MEDAN'],
            ['dealer_code' => '9FM005', 'dealer_name' => 'PT. ALFA SCORPII - SM RAJA', 'area' => 'MEDAN'],
            ['dealer_code' => '9FM012', 'dealer_name' => 'PT. ALFA SCORPII - GATOT SUBROTO', 'area' => 'MEDAN'],
            ['dealer_code' => '9F0003', 'dealer_name' => 'PT. ALFA SCORPII - P. SIDEMPUAN', 'area' => 'SUMUT'],
            ['dealer_code' => '9F0006', 'dealer_name' => 'PT. ALFA SCORPII - SIANTAR', 'area' => 'SUMUT'],
            ['dealer_code' => '9FM002', 'dealer_name' => 'PT. ALFA SCORPII - KISARAN', 'area' => 'SUMUT'],
            ['dealer_code' => '9FM007', 'dealer_name' => 'PT. ALFA SCORPII - SIBOLGA', 'area' => 'SUMUT'],
            ['dealer_code' => 'FBFF001', 'dealer_name' => 'PT. ALFA SCORPII - RANTAU PRAPAT', 'area' => 'SUMUT'],
            ['dealer_code' => 'FBFF002', 'dealer_name' => 'PT. ALFA SCORPII - BINJAI', 'area' => 'SUMUT'],
            ['dealer_code' => 'FBFF004', 'dealer_name' => 'PT. ALFA SCORPII - TJ. MORAWA', 'area' => 'SUMUT'],
            ['dealer_code' => 'FBFF005', 'dealer_name' => 'PT. ALFA SCORPII - PERBAUNGAN', 'area' => 'SUMUT'],
            ['dealer_code' => 'FBFF006', 'dealer_name' => 'PT. ALFA SCORPII - AEK KANOPAN', 'area' => 'SUMUT'],
            ['dealer_code' => 'FBFF007', 'dealer_name' => 'PT. ALFA SCORPII - KOTA PINANG', 'area' => 'SUMUT'],
            ['dealer_code' => '9FM006', 'dealer_name' => 'PT. ALFA SCORPII - LHOKSEUMAWE', 'area' => 'NAD'],
            ['dealer_code' => '9FM009', 'dealer_name' => 'PT. ALFA SCORPII - SUSOH', 'area' => 'NAD'],
            ['dealer_code' => '9FM010', 'dealer_name' => 'PT. ALFA SCORPII - MEULABOH', 'area' => 'NAD'],
            ['dealer_code' => '9FM011', 'dealer_name' => 'PT. ALFA SCORPII - SUBULUSSALAM', 'area' => 'NAD'],
            ['dealer_code' => '9FM013', 'dealer_name' => 'PT. ALFA SCORPII - BIREUEN', 'area' => 'NAD'],
            ['dealer_code' => '9FM014', 'dealer_name' => 'PT. ALFA SCORPII - LANGSA', 'area' => 'NAD'],
            ['dealer_code' => 'FCFA003', 'dealer_name' => 'PT. ALFA SCORPII - JAMBOTAPE', 'area' => 'NAD'],
            ['dealer_code' => 'FCFB001', 'dealer_name' => 'PT. ALFA SCORPII - LAMBARO', 'area' => 'NAD'],
            ['dealer_code' => 'FCFB002', 'dealer_name' => 'PT. ALFA SCORPII - KUALA SIMPANG', 'area' => 'NAD'],
            ['dealer_code' => '9F0004', 'dealer_name' => 'PT. ALFA SCORPII - PANAM', 'area' => 'RIAU'],
            ['dealer_code' => '9FB001', 'dealer_name' => 'PT. ALFA SCORPII - BOTANIA', 'area' => 'RIAU'],
            ['dealer_code' => '9FB004', 'dealer_name' => 'PT. ALFA SCORPII - PASIR PUTIH', 'area' => 'RIAU'],
            ['dealer_code' => '9FB006', 'dealer_name' => 'PT. ALFA SCORPII - DURI', 'area' => 'RIAU'],
            ['dealer_code' => '9FB008', 'dealer_name' => 'PT. ALFA SCORPII - PASIR PENGARAIAN', 'area' => 'RIAU'],
            ['dealer_code' => '9FB009', 'dealer_name' => 'PT. ALFA SCORPII - TEMBILAHAN', 'area' => 'RIAU'],
            ['dealer_code' => '9FB010', 'dealer_name' => 'PT. ALFA SCORPII - NANGKA', 'area' => 'RIAU'],
            ['dealer_code' => '9FB012', 'dealer_name' => 'PT. ALFA SCORPII - TEMBESI', 'area' => 'RIAU'],
            ['dealer_code' => 'FD00301', 'dealer_name' => 'PT. ALFA SCORPII - SUDIRMAN', 'area' => 'RIAU'],
            ['dealer_code' => 'FD00303', 'dealer_name' => 'PT. ALFA SCORPII - FLAMBOYAN', 'area' => 'RIAU'],
            ['dealer_code' => 'FD00304', 'dealer_name' => 'PT. ALFA SCORPII - AIR TIRIS', 'area' => 'RIAU'],
            ['dealer_code' => 'FD00305', 'dealer_name' => 'PT. ALFA SCORPII - PMT. REBA', 'area' => 'RIAU'],
            ['dealer_code' => 'FD00306', 'dealer_name' => 'PT. ALFA SCORPII - BAGAN BATU', 'area' => 'RIAU'],
            ['dealer_code' => 'FD00307', 'dealer_name' => 'PT. ALFA SCORPII - TALUK KUANTAN', 'area' => 'RIAU'],
            ['dealer_code' => 'FD00308', 'dealer_name' => 'PT. ALFA SCORPII - UJUNG BATU', 'area' => 'RIAU'],
            ['dealer_code' => 'FD00309', 'dealer_name' => 'SENTRAL YAMAHA PEKANBARU', 'area' => 'RIAU'],
            ['dealer_code' => 'FEFC001', 'dealer_name' => 'PT. ALFA SCORPII - BENGKONG', 'area' => 'RIAU'],
            ['dealer_code' => 'FEFC002', 'dealer_name' => 'PT. ALFA SCORPII - BATAM CENTER', 'area' => 'RIAU'],
            ['dealer_code' => 'FA0601', 'dealer_name' => 'MAIN DEALER MEDAN', 'area' => 'HO'],
            ['dealer_code' => 'FD0601', 'dealer_name' => 'MAIN DEALER PEKANBARU', 'area' => 'HO'],
            ['dealer_code' => 'FE0601', 'dealer_name' => 'MAIN DEALER BATAM', 'area' => 'HO'],
        ];

        foreach ($dealers as $dealer) {
            Dealer::create($dealer);
        }
    }

    public static function getRandomDealerCode(): string
    {
        // Assuming you have a Dealer model
        $randomDealer = Dealer::inRandomOrder()->first();
        if ($randomDealer) {
            return $randomDealer->dealer_code;
        }

        // If no dealer found, you might want to handle this case accordingly.
        // You can throw an exception, return a default value, or handle it based on your application's logic.
        throw new \Exception('No dealers found.');
    }
}
