<?php

namespace Database\Seeders;

use App\Models\Medication;
use Illuminate\Database\Seeder;

class MedicationSeeder extends Seeder
{
    public function run(): void
    {
        $medications = [

            // ==================== 1. أدوية المعدة ====================
            // Omeprazole/Sodium Bicarbonate
            ['name_en' => 'Omecarbonate',     'generic_name' => 'Omeprazole / Sodium Bicarbonate',  'dosage_form' => 'capsule',  'description' => 'أدوية المعدة'],
            ['name_en' => 'Omeplus',          'generic_name' => 'Omeprazole / Sodium Bicarbonate',  'dosage_form' => 'capsule',  'description' => 'أدوية المعدة'],
            // Esomeprazole
            ['name_en' => 'Esocap',           'generic_name' => 'Esomeprazole',                     'dosage_form' => 'capsule',  'description' => 'أدوية المعدة'],
            ['name_en' => 'Emezole',          'generic_name' => 'Esomeprazole',                     'dosage_form' => 'capsule',  'description' => 'أدوية المعدة'],
            ['name_en' => 'Esomepral',        'generic_name' => 'Esomeprazole',                     'dosage_form' => 'capsule',  'description' => 'أدوية المعدة'],
            // Lansoprazole
            ['name_en' => 'Lanzogast',        'generic_name' => 'Lansoprazole',                     'dosage_form' => 'capsule',  'description' => 'أدوية المعدة'],
            ['name_en' => 'Lansopral',        'generic_name' => 'Lansoprazole',                     'dosage_form' => 'capsule',  'description' => 'أدوية المعدة'],
            ['name_en' => 'Lano',             'generic_name' => 'Lansoprazole',                     'dosage_form' => 'capsule',  'description' => 'أدوية المعدة'],
            // Pantoprazole
            ['name_en' => 'Penta',            'generic_name' => 'Pantoprazole',                     'dosage_form' => 'tablet',   'description' => 'أدوية المعدة'],
            ['name_en' => 'Protom',           'generic_name' => 'Pantoprazole',                     'dosage_form' => 'tablet',   'description' => 'أدوية المعدة'],
            // Dexlansoprazole
            ['name_en' => 'Delastom',         'generic_name' => 'Dexlansoprazole',                  'dosage_form' => 'capsule',  'description' => 'أدوية المعدة'],
            ['name_en' => 'Maxilans',         'generic_name' => 'Dexlansoprazole',                  'dosage_form' => 'capsule',  'description' => 'أدوية المعدة'],
            // Rabeprazole
            ['name_en' => 'Newprazole',       'generic_name' => 'Rabeprazole',                      'dosage_form' => 'tablet',   'description' => 'أدوية المعدة'],
            // Famotidine
            ['name_en' => 'Zedex',            'generic_name' => 'Famotidine',                       'dosage_form' => 'tablet',   'description' => 'أدوية المعدة'],
            // Sodium Alginate
            ['name_en' => 'Gavirol',          'generic_name' => 'Sodium Alginate',                  'dosage_form' => 'other', 'description' => 'أدوية المعدة'],
            ['name_en' => 'Maloscon',         'generic_name' => 'Sodium Alginate',                  'dosage_form' => 'other', 'description' => 'أدوية المعدة'],

            // ==================== 2. مضادات الإقياء ====================
            // Domperidone
            ['name_en' => 'Motalon',          'generic_name' => 'Domperidone',                      'dosage_form' => 'tablet',   'description' => 'مضادات الإقياء'],
            ['name_en' => 'Motin',            'generic_name' => 'Domperidone',                      'dosage_form' => 'tablet',   'description' => 'مضادات الإقياء'],
            // Ondansetron
            ['name_en' => 'Devomite',         'generic_name' => 'Ondansetron',                      'dosage_form' => 'tablet',   'description' => 'مضادات الإقياء'],
            ['name_en' => 'Cametron',         'generic_name' => 'Ondansetron',                      'dosage_form' => 'tablet',   'description' => 'مضادات الإقياء'],
            ['name_en' => 'Vomset',           'generic_name' => 'Ondansetron',                      'dosage_form' => 'tablet',   'description' => 'مضادات الإقياء'],
            // Metoclopramide
            ['name_en' => 'Metocal',          'generic_name' => 'Metoclopramide',                   'dosage_form' => 'tablet',   'description' => 'مضادات الإقياء'],

            // ==================== 3. مضادات التشنج ====================
            // Hyoscine / Paracetamol
            ['name_en' => 'Buscogold plus',   'generic_name' => 'Hyoscine / Paracetamol',           'dosage_form' => 'tablet',   'description' => 'مضادات التشنج'],
            ['name_en' => 'Dolobuscomed',     'generic_name' => 'Hyoscine / Paracetamol',           'dosage_form' => 'tablet',   'description' => 'مضادات التشنج'],
            ['name_en' => 'Doloscop',         'generic_name' => 'Hyoscine / Paracetamol',           'dosage_form' => 'tablet',   'description' => 'مضادات التشنج'],
            // Mebeverine
            ['name_en' => 'Duspalina',        'generic_name' => 'Mebeverine',                       'dosage_form' => 'tablet',   'description' => 'مضادات التشنج'],
            ['name_en' => 'Duspaphen',        'generic_name' => 'Mebeverine',                       'dosage_form' => 'tablet',   'description' => 'مضادات التشنج'],
            ['name_en' => 'Mebeverist',       'generic_name' => 'Mebeverine',                       'dosage_form' => 'tablet',   'description' => 'مضادات التشنج'],
            // Alverine
            ['name_en' => 'Zerospasm',        'generic_name' => 'Alverine',                         'dosage_form' => 'capsule',  'description' => 'مضادات التشنج'],
            // Alverine / Simethicone
            ['name_en' => 'Simverine',        'generic_name' => 'Alverine / Simethicone',           'dosage_form' => 'capsule',  'description' => 'مضادات التشنج'],
            ['name_en' => 'Alvethicone',      'generic_name' => 'Alverine / Simethicone',           'dosage_form' => 'capsule',  'description' => 'مضادات التشنج'],
            // Timonium
            ['name_en' => 'Visalgine',        'generic_name' => 'Timonium',                         'dosage_form' => 'tablet',   'description' => 'مضادات التشنج'],
            // Chlordiazepoxide / Clidinium
            ['name_en' => 'Libaxor',          'generic_name' => 'Chlordiazepoxide / Clidinium',     'dosage_form' => 'capsule',  'description' => 'مضادات التشنج'],
            ['name_en' => 'Ribax',            'generic_name' => 'Chlordiazepoxide / Clidinium',     'dosage_form' => 'capsule',  'description' => 'مضادات التشنج'],
            ['name_en' => 'Gastrox',          'generic_name' => 'Chlordiazepoxide / Clidinium',     'dosage_form' => 'capsule',  'description' => 'مضادات التشنج'],
            // Dicyclomine
            ['name_en' => 'Dilove',           'generic_name' => 'Dicyclomine',                      'dosage_form' => 'tablet',   'description' => 'مضادات التشنج'],

            // ==================== 4. المسكنات ====================
            // Paracetamol
            ['name_en' => 'Paradrine',        'generic_name' => 'Paracetamol',                      'dosage_form' => 'tablet',   'description' => 'المسكنات'],
            ['name_en' => 'Prodol',           'generic_name' => 'Paracetamol',                      'dosage_form' => 'tablet',   'description' => 'المسكنات'],
            ['name_en' => 'Unadol',           'generic_name' => 'Paracetamol',                      'dosage_form' => 'tablet',   'description' => 'المسكنات'],
            // Paracetamol / Diclofenac
            ['name_en' => 'Prodol Plus-K',    'generic_name' => 'Paracetamol / Diclofenac',         'dosage_form' => 'tablet',   'description' => 'المسكنات'],
            // Paracetamol / Tramadol
            ['name_en' => 'Prodol Strong',    'generic_name' => 'Paracetamol / Tramadol',           'dosage_form' => 'tablet',   'description' => 'المسكنات'],
            // Paracetamol / Codeine
            ['name_en' => 'Prodol Max',       'generic_name' => 'Paracetamol / Codeine',            'dosage_form' => 'tablet',   'description' => 'المسكنات'],
            ['name_en' => 'Paradrine Plus',   'generic_name' => 'Paracetamol / Codeine',            'dosage_form' => 'tablet',   'description' => 'المسكنات'],
            // Ibuprofen
            ['name_en' => 'Brufen',           'generic_name' => 'Ibuprofen',                        'dosage_form' => 'tablet',   'description' => 'المسكنات'],
            // Etoricoxib
            ['name_en' => 'Toricox',          'generic_name' => 'Etoricoxib',                       'dosage_form' => 'tablet',   'description' => 'المسكنات'],

            // ==================== 5. الملينات ====================
            // Lactitol
            ['name_en' => 'Laxivite',         'generic_name' => 'Lactitol',                         'dosage_form' => 'other',   'description' => 'الملينات'],
            ['name_en' => 'Lactitreat',       'generic_name' => 'Lactitol',                         'dosage_form' => 'other',   'description' => 'الملينات'],
            // Polyethylene Glycol
            ['name_en' => 'Bowel clean',      'generic_name' => 'Polyethylene Glycol',              'dosage_form' => 'other',   'description' => 'الملينات'],
            ['name_en' => 'Coloclean',        'generic_name' => 'Polyethylene Glycol',              'dosage_form' => 'other',   'description' => 'الملينات'],
            ['name_en' => 'Cololax',          'generic_name' => 'Polyethylene Glycol',              'dosage_form' => 'other',   'description' => 'الملينات'],
            // Bisacodyl
            ['name_en' => 'Laxine',           'generic_name' => 'Bisacodyl',                        'dosage_form' => 'tablet',   'description' => 'الملينات'],
            ['name_en' => 'Laxamed',          'generic_name' => 'Bisacodyl',                        'dosage_form' => 'tablet',   'description' => 'الملينات'],
            // Senna
            ['name_en' => 'Cennozid',         'generic_name' => 'Senna',                            'dosage_form' => 'tablet',   'description' => 'الملينات'],
            ['name_en' => 'Cennoz',           'generic_name' => 'Senna',                            'dosage_form' => 'tablet',   'description' => 'الملينات'],
            // Prucalopride
            ['name_en' => 'Motilax',          'generic_name' => 'Prucalopride',                     'dosage_form' => 'tablet',   'description' => 'الملينات'],
            ['name_en' => 'Ofoprucal',        'generic_name' => 'Prucalopride',                     'dosage_form' => 'tablet',   'description' => 'الملينات'],
            // Psyllium
            ['name_en' => 'Eklipsyllium',     'generic_name' => 'Psyllium',                         'dosage_form' => 'other',   'description' => 'الملينات'],
            // Glycerin
            ['name_en' => 'Glycerol',         'generic_name' => 'Glycerin',                         'dosage_form' => 'suppository', 'description' => 'الملينات'],
            // Sodium Phosphate
            ['name_en' => 'Easy enema',       'generic_name' => 'Sodium Phosphate',                 'dosage_form' => 'other',    'description' => 'الملينات'],
            ['name_en' => 'Osmolax',          'generic_name' => 'Sodium Phosphate',                 'dosage_form' => 'other',    'description' => 'الملينات'],

            // ==================== 6. مضادات الإسهال ====================
            // Loperamide
            ['name_en' => 'Idium',            'generic_name' => 'Loperamide',                       'dosage_form' => 'capsule',  'description' => 'مضادات الإسهال'],
            ['name_en' => 'Cloistop',         'generic_name' => 'Loperamide',                       'dosage_form' => 'capsule',  'description' => 'مضادات الإسهال'],
            // Racecadotril
            ['name_en' => 'Zasek',            'generic_name' => 'Racecadotril',                     'dosage_form' => 'capsule',  'description' => 'مضادات الإسهال'],

            // ==================== 7. الصادات الجرثومية ====================
            // Amoxicillin
            ['name_en' => 'Remox',            'generic_name' => 'Amoxicillin',                      'dosage_form' => 'capsule',  'description' => 'الصادات الجرثومية'],
            ['name_en' => 'Maxicillin',       'generic_name' => 'Amoxicillin',                      'dosage_form' => 'capsule',  'description' => 'الصادات الجرثومية'],
            // Amoxicillin / Clavulanate
            ['name_en' => 'Augmentin',        'generic_name' => 'Amoxicillin / Clavulanate',        'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            ['name_en' => 'Remoclav',         'generic_name' => 'Amoxicillin / Clavulanate',        'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            // Cefixime
            ['name_en' => 'Rivaxime',         'generic_name' => 'Cefixime',                         'dosage_form' => 'capsule',  'description' => 'الصادات الجرثومية'],
            ['name_en' => 'Cefix',            'generic_name' => 'Cefixime',                         'dosage_form' => 'capsule',  'description' => 'الصادات الجرثومية'],
            // Cefdinir
            ['name_en' => 'Omni',             'generic_name' => 'Cefdinir',                         'dosage_form' => 'capsule',  'description' => 'الصادات الجرثومية'],
            // Ceftriaxone
            ['name_en' => 'Ross',             'generic_name' => 'Ceftriaxone',                      'dosage_form' => 'injection','description' => 'الصادات الجرثومية'],
            // Vancomycin
            ['name_en' => 'Vancomycin',       'generic_name' => 'Vancomycin',                       'dosage_form' => 'injection','description' => 'الصادات الجرثومية'],
            // Linezolid
            ['name_en' => 'Zavox',            'generic_name' => 'Linezolid',                        'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            ['name_en' => 'Zyvolid',          'generic_name' => 'Linezolid',                        'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            // Ciprofloxacin
            ['name_en' => 'Ciplox',           'generic_name' => 'Ciprofloxacin',                    'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            ['name_en' => 'Tilacip',          'generic_name' => 'Ciprofloxacin',                    'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            ['name_en' => 'Sustendo',         'generic_name' => 'Ciprofloxacin',                    'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            // Levofloxacin
            ['name_en' => 'Teliv',            'generic_name' => 'Levofloxacin',                     'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            ['name_en' => 'Levox',            'generic_name' => 'Levofloxacin',                     'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            ['name_en' => 'Floxalive',        'generic_name' => 'Levofloxacin',                     'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            // Moxifloxacin
            ['name_en' => 'Movilox',          'generic_name' => 'Moxifloxacin',                     'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            // Trimethoprim / Sulfamethoxazole
            ['name_en' => 'Bactericept',      'generic_name' => 'Trimethoprim / Sulfamethoxazole',  'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            // Nitrofurantoin
            ['name_en' => 'Nirtomond',        'generic_name' => 'Nitrofurantoin',                   'dosage_form' => 'capsule',  'description' => 'الصادات الجرثومية'],
            ['name_en' => 'Septifura',        'generic_name' => 'Nitrofurantoin',                   'dosage_form' => 'capsule',  'description' => 'الصادات الجرثومية'],
            // Rifampicin
            ['name_en' => 'Rifampicin',       'generic_name' => 'Rifampicin',                       'dosage_form' => 'capsule',  'description' => 'الصادات الجرثومية'],
            // Metronidazole
            ['name_en' => 'Flagyl',           'generic_name' => 'Metronidazole',                    'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            ['name_en' => 'Metrozol',         'generic_name' => 'Metronidazole',                    'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            ['name_en' => 'Tronidaze',        'generic_name' => 'Metronidazole',                    'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            // Tinidazole
            ['name_en' => 'Fasigast',         'generic_name' => 'Tinidazole',                       'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            ['name_en' => 'Usigyn',           'generic_name' => 'Tinidazole',                       'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            // Metronidazole / Diloxanide
            ['name_en' => 'Diloxazol',        'generic_name' => 'Metronidazole / Diloxanide',       'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            ['name_en' => 'Dinidazol fort',   'generic_name' => 'Metronidazole / Diloxanide',       'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            // Nystatin
            ['name_en' => 'Eblastatin',       'generic_name' => 'Nystatin',                         'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            // Fluconazole
            ['name_en' => 'Defungo',          'generic_name' => 'Fluconazole',                      'dosage_form' => 'capsule',  'description' => 'الصادات الجرثومية'],
            // Albendazole
            ['name_en' => 'Didal',            'generic_name' => 'Albendazole',                      'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            // Mebendazole
            ['name_en' => 'Vermoxine',        'generic_name' => 'Mebendazole',                      'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],
            // Pyrantel Pamoate
            ['name_en' => 'Bantrin',          'generic_name' => 'Pyrantel Pamoate',                 'dosage_form' => 'tablet',   'description' => 'الصادات الجرثومية'],

            // ==================== 9. أدوية الداء المعوي الالتهابي ====================
            // Mesalamine
            ['name_en' => 'Mesacol',          'generic_name' => 'Mesalamine',                       'dosage_form' => 'tablet',   'description' => 'أدوية الداء المعوي الالتهابي'],
            ['name_en' => 'Ulceracol',        'generic_name' => 'Mesalamine',                       'dosage_form' => 'tablet',   'description' => 'أدوية الداء المعوي الالتهابي'],
            ['name_en' => 'Pentaza',          'generic_name' => 'Mesalamine',                       'dosage_form' => 'tablet',   'description' => 'أدوية الداء المعوي الالتهابي'],
            // Sulfasalazine
            ['name_en' => 'Salazopyrin',      'generic_name' => 'Sulfasalazine',                    'dosage_form' => 'tablet',   'description' => 'أدوية الداء المعوي الالتهابي'],
            // Azathioprine
            ['name_en' => 'Imuran',           'generic_name' => 'Azathioprine',                     'dosage_form' => 'tablet',   'description' => 'أدوية الداء المعوي الالتهابي'],
            // Budesonide
            ['name_en' => 'Bedicort',         'generic_name' => 'Budesonide',                       'dosage_form' => 'capsule',  'description' => 'أدوية الداء المعوي الالتهابي'],
            // Prednisolone
            ['name_en' => 'Pharmacort',       'generic_name' => 'Prednisolone',                     'dosage_form' => 'tablet',   'description' => 'أدوية الداء المعوي الالتهابي'],
            ['name_en' => 'Predlone',         'generic_name' => 'Prednisolone',                     'dosage_form' => 'tablet',   'description' => 'أدوية الداء المعوي الالتهابي'],
            // Methylprednisolone
            ['name_en' => 'Metrocort',        'generic_name' => 'Methylprednisolone',               'dosage_form' => 'tablet',   'description' => 'أدوية الداء المعوي الالتهابي'],
            // Infliximab
            ['name_en' => 'Remicade',         'generic_name' => 'Infliximab',                       'dosage_form' => 'injection','description' => 'أدوية الداء المعوي الالتهابي'],

            // ==================== 10. أدوية الكبد ====================
            // Ursodeoxycholic Acid
            ['name_en' => 'Ursorasha',        'generic_name' => 'Ursodeoxycholic Acid',             'dosage_form' => 'capsule',  'description' => 'أدوية الكبد'],
            ['name_en' => 'Ursofalk',         'generic_name' => 'Ursodeoxycholic Acid',             'dosage_form' => 'capsule',  'description' => 'أدوية الكبد'],
            ['name_en' => 'Ursostone',        'generic_name' => 'Ursodeoxycholic Acid',             'dosage_form' => 'capsule',  'description' => 'أدوية الكبد'],
            // Tenofovir
            ['name_en' => 'Tenofovir',        'generic_name' => 'Tenofovir',                        'dosage_form' => 'tablet',   'description' => 'أدوية الكبد'],
            // Entecavir
            ['name_en' => 'Enticavir',        'generic_name' => 'Entecavir',                        'dosage_form' => 'tablet',   'description' => 'أدوية الكبد'],
            // Sofosbuvir / Ledipasvir
            ['name_en' => 'Harvomed',         'generic_name' => 'Sofosbuvir / Ledipasvir',          'dosage_form' => 'tablet',   'description' => 'أدوية الكبد'],
            ['name_en' => 'Fosvaldi Plus',    'generic_name' => 'Sofosbuvir / Ledipasvir',          'dosage_form' => 'tablet',   'description' => 'أدوية الكبد'],
            // Rifaximin
            ['name_en' => 'Hepazeg',          'generic_name' => 'Rifaximin',                        'dosage_form' => 'tablet',   'description' => 'أدوية الكبد'],
            // Nadolol
            ['name_en' => 'Corga',            'generic_name' => 'Nadolol',                          'dosage_form' => 'tablet',   'description' => 'أدوية الكبد'],
            // Propranolol
            ['name_en' => 'Inderalamed',      'generic_name' => 'Propranolol',                      'dosage_form' => 'tablet',   'description' => 'أدوية الكبد'],
            ['name_en' => 'Vasolol',          'generic_name' => 'Propranolol',                      'dosage_form' => 'tablet',   'description' => 'أدوية الكبد'],
            // Carvedilol
            ['name_en' => 'Cardivol',         'generic_name' => 'Carvedilol',                       'dosage_form' => 'tablet',   'description' => 'أدوية الكبد'],
            // Furosemide
            ['name_en' => 'Unilasix',         'generic_name' => 'Furosemide',                       'dosage_form' => 'tablet',   'description' => 'أدوية الكبد'],
            // Torsemide / Spironolactone
            ['name_en' => 'Urerest',          'generic_name' => 'Torsemide / Spironolactone',       'dosage_form' => 'tablet',   'description' => 'أدوية الكبد'],
            // Spironolactone
            ['name_en' => 'Alctone',          'generic_name' => 'Spironolactone',                   'dosage_form' => 'tablet',   'description' => 'أدوية الكبد'],
            ['name_en' => 'Spiralac',         'generic_name' => 'Spironolactone',                   'dosage_form' => 'tablet',   'description' => 'أدوية الكبد'],
            // Penicillamine
            ['name_en' => 'Cillamine',        'generic_name' => 'Penicillamine',                    'dosage_form' => 'tablet',   'description' => 'أدوية الكبد'],

            // ==================== 11. أدوية عصبية ونفسية ====================
            // Amitriptyline
            ['name_en' => 'Tryptozor',        'generic_name' => 'Amitriptyline',                    'dosage_form' => 'tablet',   'description' => 'أدوية عصبية ونفسية'],
            ['name_en' => 'Tryptophen',       'generic_name' => 'Amitriptyline',                    'dosage_form' => 'tablet',   'description' => 'أدوية عصبية ونفسية'],
            // Nortriptyline
            ['name_en' => 'Nortival',         'generic_name' => 'Nortriptyline',                    'dosage_form' => 'tablet',   'description' => 'أدوية عصبية ونفسية'],
            ['name_en' => 'Pamonor',          'generic_name' => 'Nortriptyline',                    'dosage_form' => 'tablet',   'description' => 'أدوية عصبية ونفسية'],
            // Sertraline
            ['name_en' => 'Zolotral',         'generic_name' => 'Sertraline',                       'dosage_form' => 'tablet',   'description' => 'أدوية عصبية ونفسية'],
            // Duloxetine
            ['name_en' => 'Harmostar',        'generic_name' => 'Duloxetine',                       'dosage_form' => 'capsule',  'description' => 'أدوية عصبية ونفسية'],
            ['name_en' => 'DuloTrans',        'generic_name' => 'Duloxetine',                       'dosage_form' => 'capsule',  'description' => 'أدوية عصبية ونفسية'],
            // Clonazepam
            ['name_en' => 'Clonaril',         'generic_name' => 'Clonazepam',                       'dosage_form' => 'tablet',   'description' => 'أدوية عصبية ونفسية'],
            // Bromazepam
            ['name_en' => 'Lexozepam',        'generic_name' => 'Bromazepam',                       'dosage_form' => 'tablet',   'description' => 'أدوية عصبية ونفسية'],
            // Sulpiride
            ['name_en' => 'Damatil',          'generic_name' => 'Sulpiride',                        'dosage_form' => 'tablet',   'description' => 'أدوية عصبية ونفسية'],
            ['name_en' => 'L-sulpride',       'generic_name' => 'Sulpiride',                        'dosage_form' => 'tablet',   'description' => 'أدوية عصبية ونفسية'],
            ['name_en' => 'Colon-s',          'generic_name' => 'Sulpiride',                        'dosage_form' => 'tablet',   'description' => 'أدوية عصبية ونفسية'],
            // Melitracen / Flupentixol
            ['name_en' => 'Deanixit',         'generic_name' => 'Melitracen / Flupentixol',         'dosage_form' => 'tablet',   'description' => 'أدوية عصبية ونفسية'],
            ['name_en' => 'Anxitol',          'generic_name' => 'Melitracen / Flupentixol',         'dosage_form' => 'tablet',   'description' => 'أدوية عصبية ونفسية'],

            // ==================== 12. أدوية أخرى ====================
            // Probiotic
            ['name_en' => 'Probiotic Marinas','generic_name' => 'Probiotic',                        'dosage_form' => 'capsule',  'description' => 'أدوية أخرى'],
            ['name_en' => 'Probiotic FAM',    'generic_name' => 'Probiotic',                        'dosage_form' => 'capsule',  'description' => 'أدوية أخرى'],
            // Prebiotic
            ['name_en' => 'Prebiotic Fines',  'generic_name' => 'Prebiotic',                        'dosage_form' => 'other',   'description' => 'أدوية أخرى'],
            // خمائر هاضمة
            ['name_en' => 'Mephigastryl',     'generic_name' => 'Digestive Enzymes',                'dosage_form' => 'tablet',   'description' => 'أدوية أخرى'],
            ['name_en' => 'Unizeme fort',     'generic_name' => 'Digestive Enzymes',                'dosage_form' => 'capsule',  'description' => 'أدوية أخرى'],
            ['name_en' => 'Creon',            'generic_name' => 'Pancreatic Enzymes (Pancrelipase)','dosage_form' => 'capsule',  'description' => 'أدوية أخرى'],

            // ==================== 14. الفيتامينات ====================
            // الحديد
            ['name_en' => 'Glucofer',         'generic_name' => 'Iron (Ferrous Gluconate)',          'dosage_form' => 'tablet',   'description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'Polyfer',          'generic_name' => 'Iron (Ferrous Sulfate)',            'dosage_form' => 'tablet',   'description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'Venofer',          'generic_name' => 'Iron Sucrose (IV)',                 'dosage_form' => 'injection','description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'Ironglobin',       'generic_name' => 'Iron + Vitamin B12',               'dosage_form' => 'syrup',    'description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'Globivite Fort',   'generic_name' => 'Iron Complex',                     'dosage_form' => 'capsule',  'description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'Folic Mammy',      'generic_name' => 'Iron + Folic Acid',                'dosage_form' => 'tablet',   'description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'Iron Support fines','generic_name'=> 'Iron Complex',                     'dosage_form' => 'capsule',  'description' => 'الفيتامينات والمعادن'],
            // حمض الفوليك
            ['name_en' => 'Adafol',           'generic_name' => 'Folic Acid',                       'dosage_form' => 'tablet',   'description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'Humatal',          'generic_name' => 'Folic Acid',                       'dosage_form' => 'tablet',   'description' => 'الفيتامينات والمعادن'],
            // فيتامين B12
            ['name_en' => 'Naso B12',         'generic_name' => 'Vitamin B12 (Cyanocobalamin)',      'dosage_form' => 'tablet',   'description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'Metravit',         'generic_name' => 'Vitamin B12 (Methylcobalamin)',     'dosage_form' => 'tablet',   'description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'Cobamet',          'generic_name' => 'Vitamin B12 (Cyanocobalamin)',      'dosage_form' => 'injection','description' => 'الفيتامينات والمعادن'],
            // فيتامين D
            ['name_en' => 'Sterogyl',         'generic_name' => 'Vitamin D2 (Ergocalciferol)',       'dosage_form' => 'drops',    'description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'High D',           'generic_name' => 'Vitamin D3 (Cholecalciferol)',      'dosage_form' => 'capsule',  'description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'Sun D3',           'generic_name' => 'Vitamin D3 (Cholecalciferol)',      'dosage_form' => 'capsule',  'description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'Vit D3',           'generic_name' => 'Vitamin D3 (Cholecalciferol)',      'dosage_form' => 'capsule',  'description' => 'الفيتامينات والمعادن'],
            // الكالسيوم
            ['name_en' => 'Osteofix',         'generic_name' => 'Calcium + Vitamin D3',             'dosage_form' => 'tablet',   'description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'Biodical',         'generic_name' => 'Calcium Carbonate',                'dosage_form' => 'tablet',   'description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'Calcium Care',     'generic_name' => 'Calcium + Vitamin D3',             'dosage_form' => 'tablet',   'description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'CaVid MZ',         'generic_name' => 'Calcium + Vitamin D + Magnesium',  'dosage_form' => 'tablet',   'description' => 'الفيتامينات والمعادن'],
            // المغنيزيوم
            ['name_en' => 'Mg & B6',          'generic_name' => 'Magnesium + Vitamin B6',           'dosage_form' => 'tablet',   'description' => 'الفيتامينات والمعادن'],
            ['name_en' => 'Magnesium Glycinate','generic_name'=> 'Magnesium Glycinate',             'dosage_form' => 'tablet',   'description' => 'الفيتامينات والمعادن'],
            // فيتامين E
            ['name_en' => 'Vit E',            'generic_name' => 'Vitamin E (Tocopherol)',            'dosage_form' => 'capsule',  'description' => 'الفيتامينات والمعادن'],

            // ==================== 15. أدوية السكري والشحوم ====================
            // Metformin
            ['name_en' => 'Metforal',         'generic_name' => 'Metformin',                        'dosage_form' => 'tablet',   'description' => 'أدوية السكري والشحوم'],
            ['name_en' => 'Slofag',           'generic_name' => 'Metformin',                        'dosage_form' => 'tablet',   'description' => 'أدوية السكري والشحوم'],
            // Liraglutide
            ['name_en' => 'Fictoza',          'generic_name' => 'Liraglutide',                      'dosage_form' => 'injection','description' => 'أدوية السكري والشحوم'],
        ];

        foreach ($medications as $med) {
            Medication::create([
                'name_ar'      => $med['name_en'], // اسم التجاري كاسم عربي
                'name_en'      => $med['name_en'],
                'brand_name'   => $med['name_en'],
                'generic_name' => $med['generic_name'],
                'dosage_form'  => $med['dosage_form'],
                'description'  => $med['description'],
                'is_active'    => true,
                'common_dosage'=> 'حسب إرشادات الطبيب',
            ]);
        }
    }
}
