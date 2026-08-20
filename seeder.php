<?php
include('koneksi.php'); 

$kelompok_utama = [
    ['kode' => '1', 'keterangan' => 'PERLENGKAPAN UMUM/BHN BANGUNAN A'],
    ['kode' => '2', 'keterangan' => 'ALAT LISTRIK'],
    ['kode' => '3', 'keterangan' => 'SUKU CADANG DAN PERLENGKAPAN MESIN'],
    ['kode' => '4', 'keterangan' => 'KEND. BERMOTOR (UMUM)'],
    ['kode' => '5', 'keterangan' => 'ALAT PERTANIAN'],
    ['kode' => '6', 'keterangan' => 'BAHAN OPERASI'],
    ['kode' => '7', 'keterangan' => 'MESIN PABRIK'],
];

$data_sub_kelompok = [
    // --- D1 = 1 ---
    ['d1' => '1', 'd2' => '1', 'keterangan' => 'BAHAN CAT DAN PERALATAN CAT'],
    ['d1' => '1', 'd2' => '2', 'keterangan' => 'BAHAN BANGUNAN'],
    ['d1' => '1', 'd2' => '3', 'keterangan' => 'ALAT PERKAKAS'],
    ['d1' => '1', 'd2' => '4', 'keterangan' => 'BAHAN PERLENGKAPAN PABRIK'],
    ['d1' => '1', 'd2' => '5', 'keterangan' => 'BAHAN PERLENGKAPAN KANTOR'],
    ['d1' => '1', 'd2' => '6', 'keterangan' => 'BAHAN PAKAIAN'],
    ['d1' => '1', 'd2' => '7', 'keterangan' => 'BAHAN MAKANAN DAN MINUMAN'],
    ['d1' => '1', 'd2' => '8', 'keterangan' => 'BAHAN PERLENGKAPAN RMH TANGGA'],
    ['d1' => '1', 'd2' => '9', 'keterangan' => 'ALAT LABORATORIUM'],
    ['d1' => '1', 'd2' => 'Z', 'keterangan' => 'PERLENGKAPAN LAINNYA'],

    // --- D1 = 2 ---
    ['d1' => '2', 'd2' => '0', 'keterangan' => 'KABEL, PANEL & KONTROL UTAMA'], // Added for orphan parent
    ['d1' => '2', 'd2' => '1', 'keterangan' => 'LIGHTING (LAMPU, LED, TL)'],
    ['d1' => '2', 'd2' => '2', 'keterangan' => 'FITTING'],
    ['d1' => '2', 'd2' => '3', 'keterangan' => 'KABEL & WIRE'],
    ['d1' => '2', 'd2' => '4', 'keterangan' => 'KOOL BORSTEL & PENYAMBUNG KABEL'],
    ['d1' => '2', 'd2' => '5', 'keterangan' => 'ISOLASI'],
    ['d1' => '2', 'd2' => '6', 'keterangan' => 'SAKLAR & STOP KONTAK'],
    ['d1' => '2', 'd2' => '8', 'keterangan' => 'MOTOR & CONTROL (MOTOR, CONTACTOR, RELAY)'],
    ['d1' => '2', 'd2' => '9', 'keterangan' => 'PANEL & BOX'],
    ['d1' => '2', 'd2' => 'A', 'keterangan' => 'POWER EQUIPMENT (TRAFO, INVERTER)'],
    ['d1' => '2', 'd2' => 'Z', 'keterangan' => 'ALAT LISTRIK LAIN'],

    // --- D1 = 3 ---
    ['d1' => '3', 'd2' => '1', 'keterangan' => 'PERLENGKAPAN MESIN'],
    ['d1' => '3', 'd2' => '2', 'keterangan' => 'SEALING & PACKING'],
    ['d1' => '3', 'd2' => '3', 'keterangan' => 'FASTENER'],
    ['d1' => '3', 'd2' => '4', 'keterangan' => 'TRANSMISSION'],
    ['d1' => '3', 'd2' => '5', 'keterangan' => 'HYDRAULIC & PNEUMATIC'],
    ['d1' => '3', 'd2' => '6', 'keterangan' => 'VALVE & PIPING'],
    ['d1' => '3', 'd2' => '7', 'keterangan' => 'FILTER'],
    ['d1' => '3', 'd2' => '8', 'keterangan' => 'ELECTRICAL PART'],
    ['d1' => '3', 'd2' => '9', 'keterangan' => 'SPAREPART MEKANIKAL LAINNYA'], // Added for orphan parent
    ['d1' => '3', 'd2' => 'Z', 'keterangan' => 'SUKU CADANG LAINNYA'],

    // --- D1 = 4 ---
    ['d1' => '4', 'd2' => '1', 'keterangan' => 'MOBIL'],
    ['d1' => '4', 'd2' => '2', 'keterangan' => 'BUS'],
    ['d1' => '4', 'd2' => '3', 'keterangan' => 'SEPEDA MOTOR'],
    ['d1' => '4', 'd2' => '4', 'keterangan' => 'AMBULANCE'],
    ['d1' => '4', 'd2' => '5', 'keterangan' => 'DAMKAR'],
    ['d1' => '4', 'd2' => '6', 'keterangan' => 'TRAKTOR'],
    ['d1' => '4', 'd2' => '7', 'keterangan' => 'TRUCK'],

    // --- D1 = 5 ---
    ['d1' => '5', 'd2' => '1', 'keterangan' => 'ALAT PERTANIAN'],
    ['d1' => '5', 'd2' => '2', 'keterangan' => 'PERLENGKAPAN PERTANIAN'],
    ['d1' => '5', 'd2' => 'Z', 'keterangan' => 'ALAT PERTANIAN LAINNYA'],

    // --- D1 = 6 ---
    ['d1' => '6', 'd2' => '1', 'keterangan' => 'BAHAN OPERASI TANAMAN'],
    ['d1' => '6', 'd2' => '2', 'keterangan' => 'BAHAN BAKAR'],
    ['d1' => '6', 'd2' => '3', 'keterangan' => 'BAHAN PELUMAS'],
    ['d1' => '6', 'd2' => '4', 'keterangan' => 'BAHAN OPERASI PABRIKASI'],
    ['d1' => '6', 'd2' => '5', 'keterangan' => 'BAHAN PEMBERSIH'],
    ['d1' => '6', 'd2' => '6', 'keterangan' => 'LOGAM & PERLENGKAPAN LAS'], // Added for orphan parent
    ['d1' => '6', 'd2' => '9', 'keterangan' => 'BAHAN KIMIA & OPERASI LAINNYA'], // Added for orphan parent

    // --- D1 = 7 ---
    ['d1' => '7', 'd2' => '1', 'keterangan' => 'BOILER'],
    ['d1' => '7', 'd2' => '2', 'keterangan' => 'PUTERAN'],
    ['d1' => '7', 'd2' => '3', 'keterangan' => 'MESIN SARINGAN'],
    ['d1' => '7', 'd2' => '4', 'keterangan' => 'POMPA'],
    ['d1' => '7', 'd2' => '5', 'keterangan' => 'KOMPRESSOR'],
    ['d1' => '7', 'd2' => '6', 'keterangan' => 'GEARBOX'],
    ['d1' => '7', 'd2' => '7', 'keterangan' => 'TURBINE UAP'],
    ['d1' => '7', 'd2' => '8', 'keterangan' => 'GENERATOR DAN MOTOR LISTRIK'],
    ['d1' => '7', 'd2' => '9', 'keterangan' => 'GILINGIN'],
];

$data_kategori = [
    // --- D1 = 1 ---
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'keterangan' => 'CAT / COATING UTAMA'],
    ['d1' => '1', 'd2' => '1', 'd3' => '2', 'keterangan' => 'BAHAN DASAR CAT'],
    ['d1' => '1', 'd2' => '1', 'd3' => '3', 'keterangan' => 'THINNER / SOLVENT'],
    ['d1' => '1', 'd2' => '1', 'd3' => '4', 'keterangan' => 'KUAS / ROL / ALAT APLIKASI'],
    ['d1' => '1', 'd2' => '1', 'd3' => '5', 'keterangan' => 'KUAS DAN PERLENGKAPAN PENDUKUNG'], // Fixed orphan parent structure
    ['d1' => '1', 'd2' => '1', 'd3' => '6', 'keterangan' => 'AMPLAS / ABRASIVE'], // Fixed orphan parent structure
    ['d1' => '1', 'd2' => '1', 'd3' => '7', 'keterangan' => 'PUTTY / FILLER / DEMPUL'], // Fixed orphan parent structure
    ['d1' => '1', 'd2' => '1', 'd3' => '8', 'keterangan' => 'ADDITIVE / HARDENER'], // Fixed orphan parent structure
    ['d1' => '1', 'd2' => '1', 'd3' => 'Z', 'keterangan' => 'CAT LAINNYA'], // Fixed orphan parent structure

    ['d1' => '1', 'd2' => '2', 'd3' => '1', 'keterangan' => 'SEMEN & AGREGAT'],
    ['d1' => '1', 'd2' => '2', 'd3' => '2', 'keterangan' => 'BESI & BAJA'],
    ['d1' => '1', 'd2' => '2', 'd3' => '3', 'keterangan' => 'KAYU & PANEL'],
    ['d1' => '1', 'd2' => '2', 'd3' => '4', 'keterangan' => 'PIPA & FITTING'],
    ['d1' => '1', 'd2' => '2', 'd3' => '5', 'keterangan' => 'ATAP & PENUTUP'],
    ['d1' => '1', 'd2' => '2', 'd3' => '6', 'keterangan' => 'LANTAI & KERAMIK'],
    ['d1' => '1', 'd2' => '2', 'd3' => '7', 'keterangan' => 'FINISHING'],
    ['d1' => '1', 'd2' => '2', 'd3' => '8', 'keterangan' => 'KACA & AKSESORIS'],
    ['d1' => '1', 'd2' => '2', 'd3' => '9', 'keterangan' => 'LAINNYA'],
    ['d1' => '1', 'd2' => '2', 'd3' => 'Z', 'keterangan' => 'BAHAN BANGUNAN LAINNYA'],

    ['d1' => '1', 'd2' => '3', 'd3' => '1', 'keterangan' => 'ALAT PERKAKAS MANUAL'],
    ['d1' => '1', 'd2' => '3', 'd3' => '2', 'keterangan' => 'ALAT PERKAKAS MESIN/ELEKTRIK'],
    ['d1' => '1', 'd2' => '3', 'd3' => '6', 'keterangan' => 'ALAT PENGAMAN (K3)'],
    ['d1' => '1', 'd2' => '3', 'd3' => 'Z', 'keterangan' => 'ALAT LAIN-LAIN'],
    ['d1' => '1', 'd2' => '3', 'd3' => '9', 'keterangan' => '-'],

    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'keterangan' => 'ATK'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'keterangan' => 'FURNITURE'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'keterangan' => 'TEKNOLOGI DAN KOMUNIKASI'],

    ['d1' => '1', 'd2' => '6', 'd3' => '1', 'keterangan' => 'BAHAN / KAIN'],
    ['d1' => '1', 'd2' => '6', 'd3' => '2', 'keterangan' => 'KAOS / BAJU / JAS'],
    ['d1' => '1', 'd2' => '6', 'd3' => '3', 'keterangan' => 'AKSESORIS'],

    ['d1' => '1', 'd2' => '9', 'd3' => '1', 'keterangan' => 'ALAT PREPARASI'],
    ['d1' => '1', 'd2' => '9', 'd3' => '2', 'keterangan' => 'ALAT ANALISA'],

    // --- D1 = 2 ---
    ['d1' => '2', 'd2' => '0', 'd3' => '0', 'keterangan' => 'UTILITAS LISTRIK UTAMA'],
    ['d1' => '2', 'd2' => '0', 'd3' => 'A', 'keterangan' => 'KABEL & AKSESORIS'],
    ['d1' => '2', 'd2' => '0', 'd3' => 'B', 'keterangan' => 'PROTEKSI & SWITCHGEAR'],
    ['d1' => '2', 'd2' => '0', 'd3' => 'C', 'keterangan' => 'PENERANGAN'],
    ['d1' => '2', 'd2' => '0', 'd3' => 'D', 'keterangan' => 'PANEL & KONTROL'],
    ['d1' => '2', 'd2' => '0', 'd3' => 'E', 'keterangan' => 'MOTOR & DRIVE'],

    ['d1' => '2', 'd2' => '1', 'd3' => '1', 'keterangan' => 'LAMPU PIJAR (INCANDESCENT)'],
    ['d1' => '2', 'd2' => '1', 'd3' => '2', 'keterangan' => 'LAMPU NEON (FLUORESCENT)'],
    ['d1' => '2', 'd2' => '1', 'd3' => '3', 'keterangan' => 'LAMPU HALOGEN'],
    ['d1' => '2', 'd2' => '1', 'd3' => '4', 'keterangan' => 'LED (LIGHT EMITTING DIODE)'],
    ['d1' => '2', 'd2' => '1', 'd3' => '5', 'keterangan' => 'HID (HIGH INTENSITY DISCHARGE)'], // Fixed orphan parent structure

    ['d1' => '2', 'd2' => '2', 'd3' => '1', 'keterangan' => 'GANTUNG'],
    ['d1' => '2', 'd2' => '2', 'd3' => '2', 'keterangan' => 'TEMPEL'],
    ['d1' => '2', 'd2' => '2', 'd3' => '3', 'keterangan' => 'COLOK'],

    ['d1' => '2', 'd2' => '3', 'd3' => '1', 'keterangan' => 'KABEL LISTRIK'],
    ['d1' => '2', 'd2' => '3', 'd3' => '2', 'keterangan' => 'KABEL DATA & KOMUNIKASI'],
    ['d1' => '2', 'd2' => '3', 'd3' => '3', 'keterangan' => 'KABEL AUDIO & VIDEO'],
    ['d1' => '2', 'd2' => '3', 'd3' => '4', 'keterangan' => 'KABEL OTOMOTIF & INDUSTRI'],
    ['d1' => '2', 'd2' => '3', 'd3' => '5', 'keterangan' => 'KABEL TELEKOMUNIKASI'], // Fixed orphan parent structure
    ['d1' => '2', 'd2' => '3', 'd3' => '6', 'keterangan' => 'KABEL POWER'], // Fixed orphan parent structure

    ['d1' => '2', 'd2' => '5', 'd3' => '1', 'keterangan' => 'PVC (POLYVINYL CHLORIDE)'], // Fixed orphan parent structure
    ['d1' => '2', 'd2' => '5', 'd3' => '2', 'keterangan' => 'XLPE (CROSS LINKED POLYETHYLEN'], // Fixed orphan parent structure
    ['d1' => '2', 'd2' => '5', 'd3' => '3', 'keterangan' => 'PE (POLYETHYLENE)'], // Fixed orphan parent structure
    ['d1' => '2', 'd2' => '5', 'd3' => '4', 'keterangan' => 'RUBBER / KARET (EPR, EPDM, NEO'], // Fixed orphan parent structure
    ['d1' => '2', 'd2' => '5', 'd3' => '5', 'keterangan' => 'SILICONE RUBBER'], // Fixed orphan parent structure
    ['d1' => '2', 'd2' => '5', 'd3' => '6', 'keterangan' => 'TEFLON (PTFE / FEP)'], // Fixed orphan parent structure
    ['d1' => '2', 'd2' => '5', 'd3' => '7', 'keterangan' => 'PAPER (PILC)'], // Fixed orphan parent structure
    ['d1' => '2', 'd2' => '5', 'd3' => '8', 'keterangan' => 'MICA (MICA TAPE)'], // Fixed orphan parent structure
    ['d1' => '2', 'd2' => '5', 'd3' => '9', 'keterangan' => 'FIBERGLASS'], // Fixed orphan parent structure

    ['d1' => '2', 'd2' => '6', 'd3' => '1', 'keterangan' => 'SEKRING'],
    ['d1' => '2', 'd2' => '6', 'd3' => '2', 'keterangan' => 'SAKLAR'],

    ['d1' => '2', 'd2' => '8', 'd3' => '1', 'keterangan' => 'MOTOR LISTRIK'],
    ['d1' => '2', 'd2' => '8', 'd3' => '2', 'keterangan' => 'CONTACTOR'],
    ['d1' => '2', 'd2' => '8', 'd3' => '3', 'keterangan' => 'RELAY'],
    ['d1' => '2', 'd2' => '8', 'd3' => '4', 'keterangan' => 'BREAKER / SWITCHGEAR'],

    ['d1' => '2', 'd2' => 'Z', 'd3' => 'Z', 'keterangan' => 'ALAT LISTRIK LAINNYA'],

    ['d1' => '2', 'd2' => 'A', 'd3' => '2', 'keterangan' => 'POWER CONTROL / DRIVER'],

    // --- D1 = 3 ---
    ['d1' => '3', 'd2' => '1', 'd3' => '0', 'keterangan' => '-'], // Ini di excel digit 4 ada, di digit 3 tidak ada
    ['d1' => '3', 'd2' => '1', 'd3' => '1', 'keterangan' => 'SUKU CADANG PESAWAT PENGANGKAT'],
    ['d1' => '3', 'd2' => '1', 'd3' => '2', 'keterangan' => 'SUKU CADANG CARRIER CONVEYOR'],
    ['d1' => '3', 'd2' => '1', 'd3' => '3', 'keterangan' => 'SUKU CADANG CANE PREPARATION'],
    ['d1' => '3', 'd2' => '1', 'd3' => '4', 'keterangan' => 'SUKU CADANG GILINGAN'],
    ['d1' => '3', 'd2' => '1', 'd3' => '5', 'keterangan' => 'PESAWAT UAP'],
    ['d1' => '3', 'd2' => '1', 'd3' => '6', 'keterangan' => 'PUTERAN'],
    ['d1' => '3', 'd2' => '1', 'd3' => '7', 'keterangan' => 'MESIN SARINGAN'],
    ['d1' => '3', 'd2' => '1', 'd3' => '8', 'keterangan' => 'POMPA'],
    ['d1' => '3', 'd2' => '1', 'd3' => '9', 'keterangan' => 'KOMPRESSOR'],
    ['d1' => '3', 'd2' => '1', 'd3' => 'A', 'keterangan' => 'GEARBOX'],
    ['d1' => '3', 'd2' => '1', 'd3' => 'B', 'keterangan' => 'TURBINE UAP'],
    ['d1' => '3', 'd2' => '1', 'd3' => 'C', 'keterangan' => 'GENERATOR DAN MOTOR LISTRIK'],

    ['d1' => '3', 'd2' => '2', 'd3' => '0', 'keterangan' => '-'], // Ini di excel digit 4 ada, di digit 3 tidak ada
    ['d1' => '3', 'd2' => '2', 'd3' => '1', 'keterangan' => 'OIL SEAL'],
    ['d1' => '3', 'd2' => '2', 'd3' => '2', 'keterangan' => 'MECHANICAL SEAL'],
    ['d1' => '3', 'd2' => '2', 'd3' => '3', 'keterangan' => 'GASKET & PACKING'],
    
    ['d1' => '3', 'd2' => '3', 'd3' => '0', 'keterangan' => '-'], // Ini di excel digit 4 ada, di digit 3 tidak ada
    ['d1' => '3', 'd2' => '3', 'd3' => '1', 'keterangan' => 'BAUT / BOLT'],
    ['d1' => '3', 'd2' => '3', 'd3' => '2', 'keterangan' => 'MUR / NUT'],
    ['d1' => '3', 'd2' => '3', 'd3' => '3', 'keterangan' => 'SCREW / SKRUP'],

    ['d1' => '3', 'd2' => '4', 'd3' => 'D', 'keterangan' => 'STRUKTUR & FABRIKASI'],
    ['d1' => '3', 'd2' => '4', 'd3' => 'E', 'keterangan' => 'SUPPORT & HOLDER'],
    ['d1' => '3', 'd2' => '4', 'd3' => 'F', 'keterangan' => 'TRANSMISI RINGAN'],
    ['d1' => '3', 'd2' => '4', 'd3' => 'G', 'keterangan' => 'COVER & PROTEKSI'],
    ['d1' => '3', 'd2' => '4', 'd3' => 'H', 'keterangan' => 'PIN / KEY / BUSH'],
    ['d1' => '3', 'd2' => '4', 'd3' => 'I', 'keterangan' => 'PEGAS'],
    ['d1' => '3', 'd2' => '4', 'd3' => 'J', 'keterangan' => 'GENERAL MECHANICAL (GEAR, BELT, COUPLING)'],

    ['d1' => '3', 'd2' => '6', 'd3' => '0', 'keterangan' => '-'], // Ini di excel digit 4 ada, di digit 3 tidak ada
    ['d1' => '3', 'd2' => '6', 'd3' => 'J', 'keterangan' => 'VALVE & PIPING ACCESSORIES (KATUP/KRAN)'],

    ['d1' => '3', 'd2' => '7', 'd3' => '0', 'keterangan' => '-'], // Ini di excel digit 4 ada, di digit 3 tidak ada
    ['d1' => '3', 'd2' => '7', 'd3' => '1', 'keterangan' => 'FILTER CAIRAN (SOLAR/OLI/AIR)'],
    ['d1' => '3', 'd2' => '7', 'd3' => '2', 'keterangan' => 'SARINGAN / SCREEN / CLOTH'],

    ['d1' => '3', 'd2' => '9', 'd3' => 'Z', 'keterangan' => 'MECHANICAL SPAREPART LAINNYA'],

    // --- D1 = 4 ---
    ['d1' => '4', 'd2' => '1', 'd3' => '1', 'keterangan' => 'PICKUP'],
    ['d1' => '4', 'd2' => '1', 'd3' => '2', 'keterangan' => 'MOBIL PENUMPANG'],
    ['d1' => '4', 'd2' => '2', 'd3' => '1', 'keterangan' => 'BUS'],
    ['d1' => '4', 'd2' => '3', 'd3' => '1', 'keterangan' => 'SEPEDA MOTOR'],
    ['d1' => '4', 'd2' => '4', 'd3' => '1', 'keterangan' => 'AMBULANCE'],
    ['d1' => '4', 'd2' => '5', 'd3' => '1', 'keterangan' => 'DAMPAR'],
    ['d1' => '4', 'd2' => '6', 'd3' => '1', 'keterangan' => 'TRAKTOR'],
    ['d1' => '4', 'd2' => '7', 'd3' => '1', 'keterangan' => 'TRAKTOR'],

    // --- D1 = 5 ---
    ['d1' => '5', 'd2' => '1', 'd3' => '1', 'keterangan' => 'ALAT TANGAN (CANGKUL, ARIT, PARANG, DLL)'],
    ['d1' => '5', 'd2' => '1', 'd3' => '2', 'keterangan' => 'ALAT GALI (SEKOP, GARPU TANAH)'],
    ['d1' => '5', 'd2' => '1', 'd3' => '3', 'keterangan' => 'ALAT SEMPROT (SPRAYER, NOZZLE)'],
    ['d1' => '5', 'd2' => '1', 'd3' => '4', 'keterangan' => 'POMPA'],
    ['d1' => '5', 'd2' => '1', 'd3' => '5', 'keterangan' => 'TRAKTOR & CULTIVATOR'],
    ['d1' => '5', 'd2' => '1', 'd3' => '6', 'keterangan' => 'MESIN POTONG (BRUSH CUTTER, CHAINSAW)'],
    ['d1' => '5', 'd2' => '1', 'd3' => '7', 'keterangan' => 'SELANG & AKSESORINYA'],

    ['d1' => '5', 'd2' => '2', 'd3' => '1', 'keterangan' => 'S.C ALAT PEMBASMI HAMA'],
    ['d1' => '5', 'd2' => '2', 'd3' => '2', 'keterangan' => 'S.C ALAT PERL. PERTANIAN'],
    ['d1' => '5', 'd2' => '2', 'd3' => '2', 'keterangan' => 'S.C ALAT PERL. PERTANIAN'],

    // --- D1 = 6 ---
    ['d1' => '6', 'd2' => '1', 'd3' => '1', 'keterangan' => 'PUPUK TUNGGAL'],
    ['d1' => '6', 'd2' => '1', 'd3' => '2', 'keterangan' => 'PUPUK MAJEMUK'],
    ['d1' => '6', 'd2' => '1', 'd3' => '3', 'keterangan' => 'BAHAN PEMBASMI HAMA'],
    ['d1' => '6', 'd2' => '1', 'd3' => '4', 'keterangan' => 'BAHAN PEMBASMI RUMPUT'],
    ['d1' => '6', 'd2' => '1', 'd3' => 'Z', 'keterangan' => 'PELUMAS LAINNYA'],

    ['d1' => '6', 'd2' => '2', 'd3' => '0', 'keterangan' => '-'], // Ini di excel digit 4 ada, di digit 3 tidak ada
    ['d1' => '6', 'd2' => '2', 'd3' => '1', 'keterangan' => 'BAHAN BAKAR CAIR'],
    ['d1' => '6', 'd2' => '2', 'd3' => '2', 'keterangan' => 'BAHAN BAKAR AMPAS'],
    ['d1' => '6', 'd2' => '2', 'd3' => '3', 'keterangan' => 'BAHAN BAKAR KAYU'],
    ['d1' => '6', 'd2' => '2', 'd3' => '4', 'keterangan' => 'ARANG BAKAR'],
    ['d1' => '6', 'd2' => '2', 'd3' => '54', 'keterangan' => 'BAHAN BAKAR SEKAM'],

    ['d1' => '6', 'd2' => '3', 'd3' => '1', 'keterangan' => 'MINYAK PELUMAS'],
    ['d1' => '6', 'd2' => '3', 'd3' => '2', 'keterangan' => 'GEMUK GREASE'],

    ['d1' => '6', 'd2' => '4', 'd3' => '0', 'keterangan' => '-'], // Ini di excel digit 4 ada, di digit 3 tidak ada
    ['d1' => '6', 'd2' => '4', 'd3' => '1', 'keterangan' => 'BAHAN KIMIA UNTUK PROSES'],
    ['d1' => '6', 'd2' => '4', 'd3' => '2', 'keterangan' => 'BHN KIMIA U/LABORATORIUM'],
    ['d1' => '6', 'd2' => '4', 'd3' => '3', 'keterangan' => 'KARUNG DAN BENANG JAHIT'],
    ['d1' => '6', 'd2' => '4', 'd3' => '4', 'keterangan' => 'ALAT LABORATORIUM'],

    ['d1' => '6', 'd2' => '5', 'd3' => '1', 'keterangan' => 'CHEMICAL CLEANER'],
    ['d1' => '6', 'd2' => '5', 'd3' => '2', 'keterangan' => 'MECHANICAL CLEANER'],

    ['d1' => '6', 'd2' => '6', 'd3' => '0', 'keterangan' => '-'], // Ini di excel digit 4 ada, di digit 3 tidak ada

    ['d1' => '6', 'd2' => '9', 'd3' => '1', 'keterangan' => 'CHEMICALS / CAIRAN KIMIA'],
    ['d1' => '6', 'd2' => '9', 'd3' => 'z', 'keterangan' => 'BAHAN OPERASI LAINNYA'],
    
];

$data_sub_kategori = [
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '1', 'keterangan' => 'CAT BESI'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '2', 'keterangan' => 'CAT KAYU'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '3', 'keterangan' => 'CAT TEMBOK'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '4', 'keterangan' => 'CAT LANTAI'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '5', 'keterangan' => 'CAT GENTING'],
    ['d1' => '1', 'd2' => '1', 'd3' => '2', 'd4' => '1', 'keterangan' => 'MENI'],
    ['d1' => '1', 'd2' => '1', 'd3' => '2', 'd4' => '2', 'keterangan' => 'PLAMIR'],
    ['d1' => '1', 'd2' => '1', 'd3' => '2', 'd4' => '3', 'keterangan' => 'DEMPUL'],
    ['d1' => '1', 'd2' => '1', 'd3' => '3', 'd4' => '1', 'keterangan' => 'KERTAS GOSOK'],
    ['d1' => '1', 'd2' => '1', 'd3' => '3', 'd4' => '2', 'keterangan' => 'PENGENCER CAT'],
    ['d1' => '1', 'd2' => '1', 'd3' => '4', 'd4' => '1', 'keterangan' => 'KUAS'],
    ['d1' => '1', 'd2' => '1', 'd3' => '4', 'd4' => '2', 'keterangan' => 'KAPI'],
    ['d1' => '1', 'd2' => '1', 'd3' => '4', 'd4' => '3', 'keterangan' => 'SPRAYER'],
    ['d1' => '1', 'd2' => '1', 'd3' => '5', 'd4' => '1', 'keterangan' => 'LEM'],
    ['d1' => '1', 'd2' => '1', 'd3' => '5', 'd4' => '2', 'keterangan' => 'ISOLASI'],
    ['d1' => '1', 'd2' => '2', 'd3' => '1', 'd4' => '1', 'keterangan' => 'BAHAN ALAM'],
    ['d1' => '1', 'd2' => '2', 'd3' => '1', 'd4' => '2', 'keterangan' => 'BAHAN OLAHAN INDUSTRI'],
    ['d1' => '1', 'd2' => '2', 'd3' => '1', 'd4' => '3', 'keterangan' => 'BAHAN KHUSUS'],
    ['d1' => '1', 'd2' => '2', 'd3' => '2', 'd4' => '1', 'keterangan' => 'KAYU'],
    ['d1' => '1', 'd2' => '2', 'd3' => '2', 'd4' => '2', 'keterangan' => 'BESI'],
    ['d1' => '1', 'd2' => '2', 'd3' => '2', 'd4' => '3', 'keterangan' => 'PVC'],
    ['d1' => '1', 'd2' => '2', 'd3' => '2', 'd4' => '4', 'keterangan' => 'ALUMINIUM'],
    ['d1' => '1', 'd2' => '2', 'd3' => '2', 'd4' => '5', 'keterangan' => 'ASBES'],
    ['d1' => '1', 'd2' => '2', 'd3' => '2', 'd4' => '6', 'keterangan' => 'BETON'],
    ['d1' => '1', 'd2' => '2', 'd3' => '2', 'd4' => '7', 'keterangan' => 'TANAH LIAT'],
    ['d1' => '1', 'd2' => '2', 'd3' => '3', 'd4' => '1', 'keterangan' => 'BENING'],
    ['d1' => '1', 'd2' => '2', 'd3' => '3', 'd4' => '2', 'keterangan' => 'CERMIN'],
    ['d1' => '1', 'd2' => '2', 'd3' => '3', 'd4' => '3', 'keterangan' => 'MOTIF'],
    ['d1' => '1', 'd2' => '3', 'd3' => '1', 'd4' => '1', 'keterangan' => 'PEMOTONG'],
    ['d1' => '1', 'd2' => '3', 'd3' => '1', 'd4' => '2', 'keterangan' => 'PENJEPIT'],
    ['d1' => '1', 'd2' => '3', 'd3' => '1', 'd4' => '3', 'keterangan' => 'PELUBANG'],
    ['d1' => '1', 'd2' => '3', 'd3' => '1', 'd4' => '4', 'keterangan' => 'TAP ULIR'],
    ['d1' => '1', 'd2' => '3', 'd3' => '1', 'd4' => '6', 'keterangan' => 'LAINNYA'],
    ['d1' => '1', 'd2' => '3', 'd3' => '2', 'd4' => '1', 'keterangan' => 'PEMOTONG'],
    ['d1' => '1', 'd2' => '3', 'd3' => '2', 'd4' => '2', 'keterangan' => 'PENJEPIT'],
    ['d1' => '1', 'd2' => '3', 'd3' => '2', 'd4' => '3', 'keterangan' => 'PELUBANG'],
    ['d1' => '1', 'd2' => '3', 'd3' => '2', 'd4' => '4', 'keterangan' => 'TAP ULIR'],
    ['d1' => '1', 'd2' => '3', 'd3' => '2', 'd4' => '5', 'keterangan' => 'TRACKER'],
    ['d1' => '1', 'd2' => '3', 'd3' => '2', 'd4' => '6', 'keterangan' => 'LAINNYA'],
    ['d1' => '1', 'd2' => '3', 'd3' => '6', 'd4' => '1', 'keterangan' => 'PELINDUNG DIRI/BADAN'],
    ['d1' => '1', 'd2' => '3', 'd3' => '6', 'd4' => '2', 'keterangan' => 'PELINDUNG KETINGGIAN'],
    ['d1' => '1', 'd2' => '3', 'd3' => '9', 'd4' => '1', 'keterangan' => 'MANUAL'],
    ['d1' => '1', 'd2' => '3', 'd3' => '9', 'd4' => '2', 'keterangan' => 'ELEKTRIK'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '1', 'keterangan' => 'ALAT TULIS'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '2', 'keterangan' => 'PERLENGKAPAN KERTAS'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '3', 'keterangan' => 'PERLENGKAPAN PLASTIK'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '4', 'keterangan' => 'PENYIMPAN DOKUMEN'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '5', 'keterangan' => 'ALAT BANTU KANTOR'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '1', 'keterangan' => 'MEJA'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '2', 'keterangan' => 'KURSI'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '3', 'keterangan' => 'LEMARI'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '4', 'keterangan' => 'RAK'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '1', 'keterangan' => 'HARDWARE'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '2', 'keterangan' => 'NETWORK'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '3', 'keterangan' => 'PERLENGKAPAN LAINNYA'],
    ['d1' => '1', 'd2' => '6', 'd3' => '1', 'd4' => '1', 'keterangan' => 'KAIN KATON'],
    ['d1' => '1', 'd2' => '6', 'd3' => '1', 'd4' => '2', 'keterangan' => 'KAIN JEANS'],
    ['d1' => '1', 'd2' => '6', 'd3' => '1', 'd4' => '3', 'keterangan' => 'KAIN SEPATU'],
    ['d1' => '1', 'd2' => '6', 'd3' => '2', 'd4' => '1', 'keterangan' => 'BAJU HAZMAT'],
    ['d1' => '1', 'd2' => '6', 'd3' => '2', 'd4' => '2', 'keterangan' => 'JAS HUJAN'],
    ['d1' => '1', 'd2' => '6', 'd3' => '2', 'd4' => '3', 'keterangan' => 'KAOS OLAH RAGA'],
    ['d1' => '1', 'd2' => '6', 'd3' => '3', 'd4' => '1', 'keterangan' => 'MASKER MEDIS'],
    ['d1' => '1', 'd2' => '6', 'd3' => '3', 'd4' => '2', 'keterangan' => 'SARUNG TANGAN'],
    ['d1' => '1', 'd2' => '9', 'd3' => '1', 'd4' => '1', 'keterangan' => 'ELEKTRONIK'],
    ['d1' => '1', 'd2' => '9', 'd3' => '1', 'd4' => '2', 'keterangan' => 'ALAT GELAS'],
    ['d1' => '1', 'd2' => '9', 'd3' => '1', 'd4' => '3', 'keterangan' => 'LAINNYA'],
    ['d1' => '1', 'd2' => '9', 'd3' => '2', 'd4' => '1', 'keterangan' => 'ELEKTRONIK'],
    ['d1' => '1', 'd2' => '9', 'd3' => '2', 'd4' => '2', 'keterangan' => 'NON ELEKTRONIK'],
    
    // --- POTENSI ORPHAN KARENA D2=0, D3=0, D4=HURUF ---
    ['d1' => '2', 'd2' => '0', 'd3' => '0', 'd4' => 'A', 'keterangan' => 'KABEL DAYA'], // ORPHAN: Kategori 2.0.0 tidak umum, D4 berupa string huruf
    ['d1' => '2', 'd2' => '0', 'd3' => '0', 'd4' => 'B', 'keterangan' => 'PROTEKSI LISTRIK'], // ORPHAN: Kategori 2.0.0 tidak umum, D4 berupa string huruf
    ['d1' => '2', 'd2' => '0', 'd3' => '0', 'd4' => 'C', 'keterangan' => 'KONTROL & RELAY'], // ORPHAN: Kategori 2.0.0 tidak umum, D4 berupa string huruf
    ['d1' => '2', 'd2' => '0', 'd3' => '0', 'd4' => 'D', 'keterangan' => 'PENERANGAN'], // ORPHAN: Kategori 2.0.0 tidak umum, D4 berupa string huruf
    ['d1' => '2', 'd2' => '0', 'd3' => '0', 'd4' => 'E', 'keterangan' => 'PANEL & BOX'], // ORPHAN: Kategori 2.0.0 tidak umum, D4 berupa string huruf
    ['d1' => '2', 'd2' => '0', 'd3' => '0', 'd4' => 'F', 'keterangan' => 'MOTOR LISTRIK'], // ORPHAN: Kategori 2.0.0 tidak umum, D4 berupa string huruf
    
    ['d1' => '2', 'd2' => '1', 'd3' => '1', 'd4' => '1', 'keterangan' => 'BOHLAM BENING'],
    ['d1' => '2', 'd2' => '1', 'd3' => '1', 'd4' => '2', 'keterangan' => 'BOHLAM BURAM'],
    ['d1' => '2', 'd2' => '1', 'd3' => '1', 'd4' => '3', 'keterangan' => 'LAMPU DEKORASI'],
    ['d1' => '2', 'd2' => '1', 'd3' => '2', 'd4' => '1', 'keterangan' => 'TL (TUBE LAMP)'],
    ['d1' => '2', 'd2' => '1', 'd3' => '2', 'd4' => '2', 'keterangan' => 'FCL (FLUORECENT CYRCLE LAMP)'],
    ['d1' => '2', 'd2' => '1', 'd3' => '2', 'd4' => '3', 'keterangan' => 'CFL (COMPACT FLUORESCENT LAMP)'],
    
    // --- DATA INVALID / RUSAK ---
    ['d1' => '2', 'd2' => '1', 'd3' => '3', 'd4' => '0', 'keterangan' => ''], // ORPHAN / INVALID: Keterangan kosong & D4 bernilai 0
    
    ['d1' => '2', 'd2' => '1', 'd3' => '4', 'd4' => '1', 'keterangan' => 'LED BULK'],
    ['d1' => '2', 'd2' => '1', 'd3' => '4', 'd4' => '2', 'keterangan' => 'LED TUBE'],
    ['d1' => '2', 'd2' => '1', 'd3' => '4', 'd4' => '3', 'keterangan' => 'LED DOWNLIGHT'],
    ['d1' => '2', 'd2' => '1', 'd3' => '4', 'd4' => '4', 'keterangan' => 'LED SPOTLIGHT'],
    ['d1' => '2', 'd2' => '1', 'd3' => '4', 'd4' => '5', 'keterangan' => 'LED PANEL'],
    ['d1' => '2', 'd2' => '1', 'd3' => '5', 'd4' => '1', 'keterangan' => 'XENON'],
    ['d1' => '2', 'd2' => '1', 'd3' => '5', 'd4' => '2', 'keterangan' => 'MERKURI'],
    ['d1' => '2', 'd2' => '1', 'd3' => '5', 'd4' => '3', 'keterangan' => 'NATRIUM BERTEKANAN TINGGI (HPS)'],
    ['d1' => '2', 'd2' => '1', 'd3' => '5', 'd4' => '4', 'keterangan' => 'NATRIUM BERTEKANAN RENDAH (LPS)'],
    ['d1' => '2', 'd2' => '2', 'd3' => '1', 'd4' => '1', 'keterangan' => 'ULIR (STNDART)'],
    ['d1' => '2', 'd2' => '2', 'd3' => '1', 'd4' => '2', 'keterangan' => 'STRING LIGHT'],
    ['d1' => '2', 'd2' => '2', 'd3' => '1', 'd4' => '3', 'keterangan' => 'BAYONET'],
    ['d1' => '2', 'd2' => '2', 'd3' => '2', 'd4' => '1', 'keterangan' => 'BULAT'],
    ['d1' => '2', 'd2' => '2', 'd3' => '2', 'd4' => '2', 'keterangan' => 'SEGI EMPAT'],
    ['d1' => '2', 'd2' => '2', 'd3' => '2', 'd4' => '3', 'keterangan' => 'SEGI BANYAK'],
    ['d1' => '2', 'd2' => '2', 'd3' => '3', 'd4' => '1', 'keterangan' => 'STANDART'],
    ['d1' => '2', 'd2' => '2', 'd3' => '3', 'd4' => '2', 'keterangan' => 'KOMBINASI'],
    ['d1' => '2', 'd2' => '2', 'd3' => '3', 'd4' => '3', 'keterangan' => 'FLEKSIBEL'],
    ['d1' => '2', 'd2' => '3', 'd3' => '1', 'd4' => '1', 'keterangan' => 'NYA (SERABUT TUNGGAL)'],
    ['d1' => '2', 'd2' => '3', 'd3' => '1', 'd4' => '2', 'keterangan' => 'KABEL POWER NYM'],
    ['d1' => '2', 'd2' => '3', 'd3' => '1', 'd4' => '3', 'keterangan' => 'KABEL POWER NYA'],
    ['d1' => '2', 'd2' => '3', 'd3' => '2', 'd4' => '1', 'keterangan' => 'UTP (UNSHIELDED TWISTED PAIR)'],
    ['d1' => '2', 'd2' => '3', 'd3' => '2', 'd4' => '2', 'keterangan' => 'NYM (SERABUT GANDA)'],
    ['d1' => '2', 'd2' => '3', 'd3' => '2', 'd4' => '3', 'keterangan' => 'COAXIAL (KOAKSIAL)'],
    ['d1' => '2', 'd2' => '3', 'd3' => '2', 'd4' => '4', 'keterangan' => 'FIBER OPTIK'],
    ['d1' => '2', 'd2' => '3', 'd3' => '2', 'd4' => '5', 'keterangan' => 'USB CABLE'],
    ['d1' => '2', 'd2' => '3', 'd3' => '3', 'd4' => '1', 'keterangan' => 'RCA'],
    ['d1' => '2', 'd2' => '3', 'd3' => '3', 'd4' => '2', 'keterangan' => 'HDMI'],
    ['d1' => '2', 'd2' => '3', 'd3' => '3', 'd4' => '3', 'keterangan' => 'NYY (ISOLASI PVC)'],
    ['d1' => '2', 'd2' => '3', 'd3' => '3', 'd4' => '4', 'keterangan' => 'XLR'],
    ['d1' => '2', 'd2' => '3', 'd3' => '3', 'd4' => '5', 'keterangan' => 'OPTICAL (TOSLINK)'],
    ['d1' => '2', 'd2' => '3', 'd3' => '4', 'd4' => '1', 'keterangan' => 'KABEL BATTERY / WELDING CABLE'],
    ['d1' => '2', 'd2' => '3', 'd3' => '4', 'd4' => '2', 'keterangan' => 'KABEL SENSOR / INSTRUMENTASI'],
    ['d1' => '2', 'd2' => '3', 'd3' => '4', 'd4' => '3', 'keterangan' => 'KABEL SERVO / CONTROL CABLE'],
    ['d1' => '2', 'd2' => '3', 'd3' => '4', 'd4' => '4', 'keterangan' => 'NYAF (SERABUT FLEKSIBEL)'],
    ['d1' => '2', 'd2' => '3', 'd3' => '5', 'd4' => '1', 'keterangan' => 'KABEL TELEPON (4 CORE / 6 CORE)'],
    ['d1' => '2', 'd2' => '3', 'd3' => '5', 'd4' => '2', 'keterangan' => 'DROP CABLE (FIBER-TO-HOME)'],
    ['d1' => '2', 'd2' => '3', 'd3' => '5', 'd4' => '3', 'keterangan' => 'KABEL AERIAL / ADSS'],
    ['d1' => '2', 'd2' => '3', 'd3' => '5', 'd4' => '5', 'keterangan' => 'NYMHY (ISOLASI GANDA)'],
    ['d1' => '2', 'd2' => '3', 'd3' => '5', 'd4' => '6', 'keterangan' => 'KABEL FLEKSIBEL (SERABUT)'],
    
    // --- POTENSI ORPHAN KARENA D2 HASIL SKIP / TIDAK SEURUT KATEGORI SEBELUMNYA ---
    ['d1' => '2', 'd2' => '6', 'd3' => '2', 'd4' => '1', 'keterangan' => 'ALAT LISTRIK RINGAN'], // ORPHAN: Cek apakah Parent Kategori 2.6.2 ada di DB
    ['d1' => '2', 'd2' => '6', 'd3' => '2', 'd4' => '2', 'keterangan' => 'INDUSTRI'], // ORPHAN: Cek apakah Parent Kategori 2.6.2 ada di DB
    ['d1' => '2', 'd2' => '6', 'd3' => '2', 'd4' => '3', 'keterangan' => 'OTOMOTIF'], // ORPHAN: Cek apakah Parent Kategori 2.6.2 ada di DB
    ['d1' => '2', 'd2' => '6', 'd3' => '2', 'd4' => '4', 'keterangan' => 'ELEKTRONIK'], // ORPHAN: Cek apakah Parent Kategori 2.6.2 ada di DB
    ['d1' => '2', 'd2' => '6', 'd3' => '2', 'd4' => '5', 'keterangan' => 'OTOMASI'], // ORPHAN: Cek apakah Parent Kategori 2.6.2 ada di DB
    
    ['d1' => '2', 'd2' => '8', 'd3' => '1', 'd4' => '1', 'keterangan' => 'MOTOR AC 3 PHASE'], // ORPHAN: Cek Kategori 2.8.1
    ['d1' => '2', 'd2' => '8', 'd3' => '1', 'd4' => '2', 'keterangan' => 'MOTOR AC 1 PHASE'], // ORPHAN: Cek Kategori 2.8.1
    ['d1' => '2', 'd2' => '8', 'd3' => '1', 'd4' => '3', 'keterangan' => 'MOTOR DC'], // ORPHAN: Cek Kategori 2.8.1
    ['d1' => '2', 'd2' => '8', 'd3' => '4', 'd4' => '1', 'keterangan' => 'MCB'], // ORPHAN: Cek Kategori 2.8.4
    ['d1' => '2', 'd2' => '8', 'd3' => '4', 'd4' => '2', 'keterangan' => 'MCCB'], // ORPHAN: Cek Kategori 2.8.4
    ['d1' => '2', 'd2' => '8', 'd3' => '4', 'd4' => '3', 'keterangan' => 'ACB (AIR CIRCUIT BREAKER)'], // ORPHAN: Cek Kategori 2.8.4
    ['d1' => '2', 'd2' => '8', 'd3' => '4', 'd4' => '4', 'keterangan' => 'NFB (NO FUSE BREAKER)'], // ORPHAN: Cek Kategori 2.8.4
    
    // --- POTENSI ORPHAN KARENA D2 BERUPA HURUF ---
    ['d1' => '2', 'd2' => 'A', 'd3' => '2', 'd4' => '1', 'keterangan' => 'INVERTER VSD'], // ORPHAN: D2 menggunakan karakter 'A'
    ['d1' => '2', 'd2' => 'A', 'd3' => '2', 'd4' => '2', 'keterangan' => 'SOFT STARTER'], // ORPHAN: D2 menggunakan karakter 'A'
    
    // --- POTENSI ORPHAN KARENA D3 BER-KODE 0 (TIDAK MEMILIKI SPESIFIKASI KATEGORI) ---
    ['d1' => '3', 'd2' => '1', 'd3' => '0', 'd4' => '1', 'keterangan' => 'BALL BEARING'], // ORPHAN: Cek apakah Kategori 3.1.0 ada di DB
    ['d1' => '3', 'd2' => '1', 'd3' => '0', 'd4' => '2', 'keterangan' => 'ROLLER BEARING'], // ORPHAN: Cek apakah Kategori 3.1.0 ada di DB
    ['d1' => '3', 'd2' => '1', 'd3' => '0', 'd4' => '3', 'keterangan' => 'NEEDLE / BUSHING'], // ORPHAN: Cek apakah Kategori 3.1.0 ada di DB
    ['d1' => '3', 'd2' => '2', 'd3' => '0', 'd4' => '1', 'keterangan' => 'OIL SEAL'], // ORPHAN: Cek Kategori 3.2.0
    ['d1' => '3', 'd2' => '2', 'd3' => '0', 'd4' => '2', 'keterangan' => 'MECHANICAL SEAL'], // ORPHAN: Cek Kategori 3.2.0
    ['d1' => '3', 'd2' => '2', 'd3' => '0', 'd4' => '3', 'keterangan' => 'GASKET / PACKING'], // ORPHAN: Cek Kategori 3.2.0
    ['d1' => '3', 'd2' => '2', 'd3' => '0', 'd4' => '4', 'keterangan' => 'O-RING'], // ORPHAN: Cek Kategori 3.2.0
    ['d1' => '3', 'd2' => '3', 'd3' => '0', 'd4' => '1', 'keterangan' => 'BOLT / BAUT'], // ORPHAN: Cek Kategori 3.3.0
    ['d1' => '3', 'd2' => '3', 'd3' => '0', 'd4' => '2', 'keterangan' => 'NUT / MUR'], // ORPHAN: Cek Kategori 3.3.0
    ['d1' => '3', 'd2' => '3', 'd3' => '0', 'd4' => '3', 'keterangan' => 'SCREW / SEKRUP'], // ORPHAN: Cek Kategori 3.3.0
    ['d1' => '3', 'd2' => '3', 'd3' => '0', 'd4' => '4', 'keterangan' => 'RING / WASHER'], // ORPHAN: Cek Kategori 3.3.0
    ['d1' => '3', 'd2' => '3', 'd3' => '0', 'd4' => '5', 'keterangan' => 'STUD / ANGKUR / BAUT TANAM'], // ORPHAN: Cek Kategori 3.3.0
    ['d1' => '3', 'd2' => '6', 'd3' => '0', 'd4' => '1', 'keterangan' => 'GATE VALVE'], // ORPHAN: Cek Kategori 3.6.0
    ['d1' => '3', 'd2' => '6', 'd3' => '0', 'd4' => '2', 'keterangan' => 'GLOBE VALVE'], // ORPHAN: Cek Kategori 3.6.0
    ['d1' => '3', 'd2' => '6', 'd3' => '0', 'd4' => '3', 'keterangan' => 'BALL VALVE'], // ORPHAN: Cek Kategori 3.6.0
    ['d1' => '3', 'd2' => '6', 'd3' => '0', 'd4' => '4', 'keterangan' => 'BUTTERFLY VALVE'], // ORPHAN: Cek Kategori 3.6.0
    ['d1' => '3', 'd2' => '6', 'd3' => '0', 'd4' => '5', 'keterangan' => 'CHECK VALVE'], // ORPHAN: Cek Kategori 3.6.0
    ['d1' => '3', 'd2' => '7', 'd3' => '0', 'd4' => '1', 'keterangan' => 'FILTER OLI'], // ORPHAN: Cek Kategori 3.7.0
    ['d1' => '3', 'd2' => '7', 'd3' => '0', 'd4' => '2', 'keterangan' => 'FILTER SOLAR / FUEL'], // ORPHAN: Cek Kategori 3.7.0
    ['d1' => '3', 'd2' => '7', 'd3' => '0', 'd4' => '3', 'keterangan' => 'FILTER UDARA'], // ORPHAN: Cek Kategori 3.7.0
    ['d1' => '3', 'd2' => '7', 'd3' => '0', 'd4' => '4', 'keterangan' => 'FILTER AIR / WATER'], // ORPHAN: Cek Kategori 3.7.0
    
    // --- POTENSI ORPHAN DIGIT 1 UTAMA BARU ---
    ['d1' => '4', 'd2' => '1', 'd3' => '1', 'd4' => '1', 'keterangan' => 'ENGINE'], // ORPHAN: Cek Kategori 4.1.1
    ['d1' => '4', 'd2' => '1', 'd3' => '1', 'd4' => '2', 'keterangan' => 'SISTEM PENGGERAK & TRANSMISI'], // ORPHAN: Cek Kategori 4.1.1
    ['d1' => '4', 'd2' => '1', 'd3' => '1', 'd4' => '3', 'keterangan' => 'BODY'], // ORPHAN: Cek Kategori 4.1.1
    ['d1' => '4', 'd2' => '1', 'd3' => '1', 'd4' => '4', 'keterangan' => 'BAN & VELG'], // ORPHAN: Cek Kategori 4.1.1
    ['d1' => '4', 'd2' => '1', 'd3' => '1', 'd4' => '5', 'keterangan' => 'ELECTRICAL'], // ORPHAN: Cek Kategori 4.1.1
    ['d1' => '4', 'd2' => '1', 'd3' => '1', 'd4' => '6', 'keterangan' => 'FILTER & PELUMAS KENDARAAN'], // ORPHAN: Cek Kategori 4.1.1
    
    ['d1' => '5', 'd2' => '1', 'd3' => '3', 'd4' => '1', 'keterangan' => 'NOZZLE / TIP / SPUYER'], // ORPHAN: Cek Kategori 5.1.3
    ['d1' => '5', 'd2' => '1', 'd3' => '3', 'd4' => '2', 'keterangan' => 'VALVE / AFSLUITER'], // ORPHAN: Cek Kategori 5.1.3
    ['d1' => '5', 'd2' => '1', 'd3' => '5', 'd4' => '1', 'keterangan' => 'MESIN / ENGINE (TRAKTOR)'], // ORPHAN: Cek Kategori 5.1.5
    ['d1' => '5', 'd2' => '1', 'd3' => '5', 'd4' => '2', 'keterangan' => 'TRANSMISI / KOPLING (TRAKTOR)'], // ORPHAN: Cek Kategori 5.1.5
    ['d1' => '5', 'd2' => '1', 'd3' => '5', 'd4' => '3', 'keterangan' => 'HIDROLIK / ACTUATOR (TRAKTOR)'], // ORPHAN: Cek Kategori 5.1.5
    ['d1' => '5', 'd2' => '1', 'd3' => '5', 'd4' => '4', 'keterangan' => 'BODY / RANGKA (TRAKTOR)'], // ORPHAN: Cek Kategori 5.1.5
    
    ['d1' => '6', 'd2' => '2', 'd3' => '0', 'd4' => '1', 'keterangan' => 'BAHAN BAKAR PADAT (ARANG)'], // ORPHAN: Cek Kategori 6.2.0
    ['d1' => '6', 'd2' => '2', 'd3' => '0', 'd4' => '2', 'keterangan' => 'BAHAN BAKAR CAIR (BENSIN/SOLAR)'], // ORPHAN: Cek Kategori 6.2.0
    ['d1' => '6', 'd2' => '3', 'd3' => '1', 'd4' => '1', 'keterangan' => 'MINYAK PELUMAS (OIL)'],
    ['d1' => '6', 'd2' => '3', 'd3' => '1', 'd4' => '2', 'keterangan' => 'GEMUK (GREASE)'],
    ['d1' => '6', 'd2' => '4', 'd3' => '0', 'd4' => '1', 'keterangan' => 'KIMIA ASAM (ACID)'], // ORPHAN: Cek Kategori 6.4.0
    ['d1' => '6', 'd2' => '4', 'd3' => '0', 'd4' => '2', 'keterangan' => 'KIMIA BASA (ALKALI)'], // ORPHAN: Cek Kategori 6.4.0
    ['d1' => '6', 'd2' => '6', 'd3' => '0', 'd4' => '1', 'keterangan' => 'LOGAM BESI / BAJA'], // ORPHAN: Cek Kategori 6.6.0
    ['d1' => '6', 'd2' => '6', 'd3' => '0', 'd4' => '2', 'keterangan' => 'SELANG / HOSE'], // ORPHAN: Cek Kategori 6.6.0
    ['d1' => '6', 'd2' => '6', 'd3' => '0', 'd4' => '3', 'keterangan' => 'PERLENGKAPAN LAS'] // ORPHAN: Cek Kategori 6.6.0
];

$data_turunan_sub_kategori = [
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '1', 'd5' => '1', 'keterangan' => 'ENAMEL / MENGKILAP'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '1', 'd5' => '2', 'keterangan' => 'FOOD GRADE'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '1', 'd5' => '3', 'keterangan' => 'TAHAN PANAS'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '2', 'd5' => '1', 'keterangan' => 'MATTE (DATAR/DOFF)'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '2', 'd5' => '2', 'keterangan' => 'EGGSHELL (SATIN)'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '2', 'd5' => '3', 'keterangan' => 'SEMI-GLOSS'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '2', 'd5' => '4', 'keterangan' => 'GLOSS'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '3', 'd5' => '1', 'keterangan' => 'MATTE (DATAR/DOFF)'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '3', 'd5' => '2', 'keterangan' => 'EGGSHELL (SATIN)'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '3', 'd5' => '3', 'keterangan' => 'SEMI-GLOSS'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '3', 'd5' => '4', 'keterangan' => 'GLOSS'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '4', 'd5' => '1', 'keterangan' => 'EPOXY'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '4', 'd5' => '2', 'keterangan' => 'POLYURETHANE (PU)'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '4', 'd5' => '3', 'keterangan' => 'ACRYLIC'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '5', 'd5' => '1', 'keterangan' => 'STANDART'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '5', 'd5' => '2', 'keterangan' => 'WATER PROOF'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '5', 'd5' => '3', 'keterangan' => 'STYRENE ACRYLIC (TAH'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '5', 'd5' => '4', 'keterangan' => 'ALKYD SYNTHETIC (TAH'],
    ['d1' => '1', 'd2' => '1', 'd3' => '1', 'd4' => '5', 'd5' => '5', 'keterangan' => 'ZINC CHROMATE PRIMER'],
    ['d1' => '1', 'd2' => '1', 'd3' => '2', 'd4' => '1', 'd5' => '1', 'keterangan' => 'BESI'],
    ['d1' => '1', 'd2' => '1', 'd3' => '2', 'd4' => '1', 'd5' => '2', 'keterangan' => 'KAYU'],
    ['d1' => '1', 'd2' => '1', 'd3' => '2', 'd4' => '2', 'd5' => '1', 'keterangan' => 'AKRILIK'],
    ['d1' => '1', 'd2' => '1', 'd3' => '2', 'd4' => '2', 'd5' => '2', 'keterangan' => 'SEMEN PUTIH'],
    ['d1' => '1', 'd2' => '1', 'd3' => '2', 'd4' => '2', 'd5' => '3', 'keterangan' => 'INSTAN'],
    ['d1' => '1', 'd2' => '1', 'd3' => '2', 'd4' => '3', 'd5' => '1', 'keterangan' => 'BESI'],
    ['d1' => '1', 'd2' => '1', 'd3' => '2', 'd4' => '3', 'd5' => '2', 'keterangan' => 'KAYU'],
    ['d1' => '1', 'd2' => '1', 'd3' => '2', 'd4' => '3', 'd5' => '3', 'keterangan' => 'TEMBOK'],
    ['d1' => '1', 'd2' => '1', 'd3' => '3', 'd4' => '1', 'd5' => '1', 'keterangan' => 'KERING'],
    ['d1' => '1', 'd2' => '1', 'd3' => '3', 'd4' => '1', 'd5' => '2', 'keterangan' => 'BASAH'],
    ['d1' => '1', 'd2' => '1', 'd3' => '3', 'd4' => '1', 'd5' => '3', 'keterangan' => 'ROLL/GULUNGAN'],
    ['d1' => '1', 'd2' => '1', 'd3' => '3', 'd4' => '2', 'd5' => '1', 'keterangan' => 'THINNER A'],
    ['d1' => '1', 'd2' => '1', 'd3' => '3', 'd4' => '2', 'd5' => '2', 'keterangan' => 'THINNER B (CAT SINTE'],
    ['d1' => '1', 'd2' => '1', 'd3' => '3', 'd4' => '2', 'd5' => '3', 'keterangan' => 'THINNER MELAMINE (HI'],
    ['d1' => '1', 'd2' => '1', 'd3' => '3', 'd4' => '2', 'd5' => '4', 'keterangan' => 'THINNER NC (PERABOT'],
    ['d1' => '1', 'd2' => '1', 'd3' => '4', 'd4' => '1', 'd5' => '1', 'keterangan' => 'KUAS DATAR (FLAT BRU'],
    ['d1' => '1', 'd2' => '1', 'd3' => '4', 'd4' => '1', 'd5' => '2', 'keterangan' => 'KUAS ROLL'],
    ['d1' => '1', 'd2' => '1', 'd3' => '4', 'd4' => '1', 'd5' => '3', 'keterangan' => 'KUAS SUDUT (ANGLED B'],
    ['d1' => '1', 'd2' => '1', 'd3' => '4', 'd4' => '2', 'd5' => '1', 'keterangan' => 'KAPI CAT (SCRAPER)'],
    ['d1' => '1', 'd2' => '1', 'd3' => '4', 'd4' => '2', 'd5' => '2', 'keterangan' => 'KAPI DEMPUL'],
    ['d1' => '1', 'd2' => '1', 'd3' => '4', 'd4' => '2', 'd5' => '3', 'keterangan' => 'KAPI PLASTIK'],
    ['d1' => '1', 'd2' => '1', 'd3' => '4', 'd4' => '3', 'd5' => '1', 'keterangan' => 'SPRAYER ELEKTRIK'],
    ['d1' => '1', 'd2' => '1', 'd3' => '4', 'd4' => '3', 'd5' => '2', 'keterangan' => 'SPRAYER KOMPRESOR'],
    ['d1' => '1', 'd2' => '1', 'd3' => '4', 'd4' => '3', 'd5' => '3', 'keterangan' => 'SPRAYER MANUAL'],
    ['d1' => '1', 'd2' => '1', 'd3' => '4', 'd4' => '3', 'd5' => '4', 'keterangan' => 'AEROSOL BERTEKANAN'],
    ['d1' => '1', 'd2' => '1', 'd3' => '5', 'd4' => '1', 'd5' => '1', 'keterangan' => 'LEM PUTIH'],
    ['d1' => '1', 'd2' => '1', 'd3' => '5', 'd4' => '1', 'd5' => '2', 'keterangan' => 'LEM EPOKSI'],
    ['d1' => '1', 'd2' => '1', 'd3' => '5', 'd4' => '1', 'd5' => '3', 'keterangan' => 'LEM SUPER/KOREA'],
    ['d1' => '1', 'd2' => '1', 'd3' => '5', 'd4' => '1', 'd5' => '4', 'keterangan' => 'LEM PANAS (HOT GLUE)'],
    ['d1' => '1', 'd2' => '1', 'd3' => '5', 'd4' => '2', 'd5' => '1', 'keterangan' => 'ISOLASI LISTRIK'],
    ['d1' => '1', 'd2' => '1', 'd3' => '5', 'd4' => '2', 'd5' => '2', 'keterangan' => 'ISOLASI TERMAL/PANAS'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '1', 'd5' => '1', 'keterangan' => 'PULPEN'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '1', 'd5' => '2', 'keterangan' => 'PENSIL'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '1', 'd5' => '3', 'keterangan' => 'SPIDOL'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '1', 'd5' => '4', 'keterangan' => 'HIGHLIGHTER/STABILO'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '1', 'd5' => '5', 'keterangan' => 'PENGHAPUS'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '1', 'd5' => '6', 'keterangan' => 'CORRECTION TAPE/TIPE'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '2', 'd5' => '1', 'keterangan' => 'KERTAS POLOS'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '2', 'd5' => '2', 'keterangan' => 'KERTAS BERGARIS'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '2', 'd5' => '3', 'keterangan' => 'KARTON'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '2', 'd5' => '4', 'keterangan' => 'STOPMAP KERTAS'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '2', 'd5' => '5', 'keterangan' => 'SNELHECTER KERTAS'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '2', 'd5' => '6', 'keterangan' => 'BUKU TULIS'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '2', 'd5' => '7', 'keterangan' => 'AMPLOP'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '2', 'd5' => '8', 'keterangan' => 'STICKY NOTES'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '2', 'd5' => '9', 'keterangan' => 'KERTAS CETAKAN'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '3', 'd5' => '1', 'keterangan' => 'SAMPUL PLATIK'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '3', 'd5' => '2', 'keterangan' => 'STOPMAP PLASTIK'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '3', 'd5' => '3', 'keterangan' => 'SNELHECTER PLASTIK'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '3', 'd5' => '4', 'keterangan' => 'SHEET PROTECTOR'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '4', 'd5' => '1', 'keterangan' => 'DOCUMENT KEEPER'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '4', 'd5' => '2', 'keterangan' => 'ODNER'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '4', 'd5' => '3', 'keterangan' => 'BINDER'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '4', 'd5' => '4', 'keterangan' => 'BOX FILE'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '5', 'd5' => '1', 'keterangan' => 'STAPLES / ISINYA'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '5', 'd5' => '2', 'keterangan' => 'KLIP / PENJEPIT'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '5', 'd5' => '3', 'keterangan' => 'GUNTING / CUTTER'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '5', 'd5' => '4', 'keterangan' => 'PENGGARIS'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '5', 'd5' => '5', 'keterangan' => 'LAKBAN/SELOTIB/DOUBL'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '5', 'd5' => '6', 'keterangan' => 'PERFORATOR/PELUBANG'],
    ['d1' => '1', 'd2' => '5', 'd3' => '1', 'd4' => '5', 'd5' => '7', 'keterangan' => 'KALKULATOR'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '1', 'd5' => '1', 'keterangan' => 'MEJA RESEPSIONIS'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '1', 'd5' => '2', 'keterangan' => 'MEJA KERJA/TULIS'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '1', 'd5' => '3', 'keterangan' => 'MEJA KOMPUTER'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '1', 'd5' => '4', 'keterangan' => 'MEJA BILIK'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '1', 'd5' => '5', 'keterangan' => 'MEJA RAPAT'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '1', 'd5' => '6', 'keterangan' => 'MEJA EKSEKUTIF'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '2', 'd5' => '1', 'keterangan' => 'KURSI EKSEKUTIF'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '2', 'd5' => '2', 'keterangan' => 'KURSI STAF'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '2', 'd5' => '3', 'keterangan' => 'KURSI TAMU'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '2', 'd5' => '4', 'keterangan' => 'KURSI LIPAT'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '2', 'd5' => '5', 'keterangan' => 'KURSI JARING'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '3', 'd5' => '1', 'keterangan' => 'ARSIP'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '3', 'd5' => '2', 'keterangan' => 'FILLING CABINET'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '3', 'd5' => '3', 'keterangan' => 'LOKER'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '3', 'd5' => '4', 'keterangan' => 'BRANKAS'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '3', 'd5' => '5', 'keterangan' => 'MULTI FUNGSI'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '4', 'd5' => '1', 'keterangan' => 'RAK BESI'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '4', 'd5' => '2', 'keterangan' => 'RAK KAYU'],
    ['d1' => '1', 'd2' => '5', 'd3' => '2', 'd4' => '4', 'd5' => '3', 'keterangan' => 'RAK PLASTIK'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '1', 'd5' => '1', 'keterangan' => 'DESKTOP'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '1', 'd5' => '2', 'keterangan' => 'LAPTOP'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '1', 'd5' => '3', 'keterangan' => 'KEYBOARD'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '1', 'd5' => '4', 'keterangan' => 'MOUSE'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '1', 'd5' => '5', 'keterangan' => 'JOISTICK'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '1', 'd5' => '6', 'keterangan' => 'PRINTER'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '1', 'd5' => '7', 'keterangan' => 'SCANNER'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '1', 'd5' => '8', 'keterangan' => 'MONITOR'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '1', 'd5' => '9', 'keterangan' => 'SERVER'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '2', 'd5' => '1', 'keterangan' => 'ACCES POINT'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '2', 'd5' => '2', 'keterangan' => 'SWITCH'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '2', 'd5' => '3', 'keterangan' => 'ROUTER'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '2', 'd5' => '4', 'keterangan' => 'FIREWALL'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '2', 'd5' => '5', 'keterangan' => 'MODEM'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '3', 'd5' => '1', 'keterangan' => 'HARDDISK'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '3', 'd5' => '2', 'keterangan' => 'FLASHDISK'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '3', 'd5' => '3', 'keterangan' => 'BATTERY'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '3', 'd5' => '4', 'keterangan' => 'SWITCH HUB'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '3', 'd5' => '5', 'keterangan' => 'UPS'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '3', 'd5' => '6', 'keterangan' => 'KAMERA'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '3', 'd5' => '7', 'keterangan' => 'AUDIO'],
    ['d1' => '1', 'd2' => '5', 'd3' => '3', 'd4' => '3', 'd5' => '8', 'keterangan' => 'ASESSORIS LAIN'],
    ['d1' => '2', 'd2' => '3', 'd3' => '1', 'd4' => '1', 'd5' => '1', 'keterangan' => 'TEMBAGA (CU)'],
    ['d1' => '2', 'd2' => '3', 'd3' => '1', 'd4' => '1', 'd5' => '2', 'keterangan' => 'ALUMINIUM (AL)'],
    ['d1' => '2', 'd2' => '8', 'd3' => '1', 'd4' => '1', 'd5' => '1', 'keterangan' => 'LOW VOLTAGE (220/380V)'],
    ['d1' => '2', 'd2' => '8', 'd3' => '1', 'd4' => '1', 'd5' => '2', 'keterangan' => 'MEDIUM VOLTAGE'],
    ['d1' => '2', 'd2' => 'A', 'd3' => '2', 'd4' => '1', 'd5' => '1', 'keterangan' => 'HEAVY DUTY'],
    ['d1' => '2', 'd2' => 'A', 'd3' => '2', 'd4' => '1', 'd5' => '2', 'keterangan' => 'NORMAL DUTY'],
    ['d1' => '3', 'd2' => '1', 'd3' => '0', 'd4' => '1', 'd5' => '1', 'keterangan' => 'SINGLE ROW'],
    ['d1' => '3', 'd2' => '1', 'd3' => '0', 'd4' => '1', 'd5' => '2', 'keterangan' => 'DOUBLE ROW'],
    ['d1' => '3', 'd2' => '1', 'd3' => '0', 'd4' => '1', 'd5' => '3', 'keterangan' => 'SPHERICAL / SELF ALIGNING'],
    ['d1' => '3', 'd2' => '1', 'd3' => '0', 'd4' => '2', 'd5' => '1', 'keterangan' => 'CYLINDRICAL'],
    ['d1' => '3', 'd2' => '1', 'd3' => '0', 'd4' => '2', 'd5' => '2', 'keterangan' => 'TAPERED'],
    ['d1' => '3', 'd2' => '1', 'd3' => '0', 'd4' => '2', 'd5' => '3', 'keterangan' => 'SPHERICAL'],
    ['d1' => '3', 'd2' => '2', 'd3' => '0', 'd4' => '1', 'd5' => '1', 'keterangan' => 'RUBBER (NBR/VITON)'],
    ['d1' => '3', 'd2' => '2', 'd3' => '0', 'd4' => '1', 'd5' => '2', 'keterangan' => 'METAL CASE'],
    ['d1' => '3', 'd2' => '2', 'd3' => '0', 'd4' => '3', 'd5' => '1', 'keterangan' => 'KARET / RUBBER'],
    ['d1' => '3', 'd2' => '2', 'd3' => '0', 'd4' => '3', 'd5' => '2', 'keterangan' => 'ASBES / ASBESTOS'],
    ['d1' => '3', 'd2' => '2', 'd3' => '0', 'd4' => '3', 'd5' => '3', 'keterangan' => 'TEFLON / PTFE'],
    ['d1' => '3', 'd2' => '2', 'd3' => '0', 'd4' => '3', 'd5' => '4', 'keterangan' => 'GRAPHIT / CARBON'],
    ['d1' => '3', 'd2' => '3', 'd3' => '0', 'd4' => '1', 'd5' => '1', 'keterangan' => 'MILD STEEL'],
    ['d1' => '3', 'd2' => '3', 'd3' => '0', 'd4' => '1', 'd5' => '1', 'keterangan' => 'STAINLESS STEEL'],
    ['d1' => '3', 'd2' => '3', 'd3' => '0', 'd4' => '1', 'd5' => '2', 'keterangan' => 'STAINLESS STEEL (SUS)'],
    ['d1' => '3', 'd2' => '3', 'd3' => '0', 'd4' => '1', 'd5' => '2', 'keterangan' => 'HTS / BAJA'],
    ['d1' => '3', 'd2' => '6', 'd3' => '0', 'd4' => '1', 'd5' => '1', 'keterangan' => 'FLANGED'],
    ['d1' => '3', 'd2' => '6', 'd3' => '0', 'd4' => '1', 'd5' => '2', 'keterangan' => 'THREADED'],
    ['d1' => '5', 'd2' => '1', 'd3' => '3', 'd4' => '1', 'd5' => '1', 'keterangan' => 'MATERIAL STAINLESS STEEL (SCS)'],
    ['d1' => '5', 'd2' => '1', 'd3' => '3', 'd4' => '1', 'd5' => '2', 'keterangan' => 'MATERIAL KUNINGAN / BRASS'],
    ['d1' => '5', 'd2' => '1', 'd3' => '5', 'd4' => '1', 'd5' => '1', 'keterangan' => 'MODEL TS 6030'],
    ['d1' => '5', 'd2' => '1', 'd3' => '5', 'd4' => '1', 'd5' => '2', 'keterangan' => 'MODEL TS 6000'],
    ['d1' => '5', 'd2' => '1', 'd3' => '5', 'd4' => '1', 'd5' => '3', 'keterangan' => 'MODEL FORD / NEW HOLLAND'],
    ['d1' => '6', 'd2' => '3', 'd3' => '1', 'd4' => '1', 'd5' => '1', 'keterangan' => 'APLIKASI MESIN / DIESEL'],
    ['d1' => '6', 'd2' => '3', 'd3' => '1', 'd4' => '1', 'd5' => '2', 'keterangan' => 'APLIKASI HIDROLIK'],
    ['d1' => '6', 'd2' => '3', 'd3' => '1', 'd4' => '1', 'd5' => '3', 'keterangan' => 'APLIKASI GEAR / TRANSMISI'],
    ['d1' => '6', 'd2' => '6', 'd3' => '0', 'd4' => '1', 'd5' => '1', 'keterangan' => 'BENTUK PLAT (PLATE)'],
    ['d1' => '6', 'd2' => '6', 'd3' => '0', 'd4' => '1', 'd5' => '2', 'keterangan' => 'BENTUK AS / BATANG (ROUND BAR)'],
    ['d1' => '6', 'd2' => '6', 'd3' => '0', 'd4' => '2', 'd5' => '3', 'keterangan' => 'BENTUK SELANG / HOSE'],
];

function resetKelompokUtama($conn, $data)
{
    try {
        // 1. Matikan Foreign Key Check & Lakukan TRUNCATE
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0;");
        
        $truncateQuery = "TRUNCATE TABLE kelompok_utama";
        if (!mysqli_query($conn, $truncateQuery)) {
            throw new Exception("Gagal melakukan TRUNCATE: " . mysqli_error($conn));
        }

        // Aktifkan kembali Foreign Key Check
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");

        // 2. Susun Single Multi-Insert Query
        $values = [];
        foreach ($data as $row) {
            $kode       = mysqli_real_escape_string($conn, $row['kode']);
            $keterangan = mysqli_real_escape_string($conn, $row['keterangan']);

            $values[] = "('$kode', '$keterangan')";
        }

        if (!empty($values)) {
            $insertQuery = "INSERT INTO kelompok_utama (kode, keterangan) VALUES " . implode(', ', $values);
            
            if (mysqli_query($conn, $insertQuery)) {
                echo "<b>Berhasil!</b> Tabel <code>kelompok_utama</code> telah dikosongkan dan diisi ulang dengan " . count($values) . " data baru.";
                return true;
            } else {
                throw new Exception("Gagal insert data: " . mysqli_error($conn));
            }
        }

        return false;

    } catch (Exception $e) {
        // Memastikan FK Check selalu diaktifkan kembali jika terjadi error
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");
        echo "<b>Error:</b> " . $e->getMessage();
        return false;
    }
}

function resetSubKelompokUtama($conn, $data)
{
    try {
        // 1. Ambil Map/Mapping ID dari kelompok_utama berdasarkan kode
        $map_d1 = [];
        $res = mysqli_query($conn, "SELECT id, kode FROM kelompok_utama");
        while ($row = mysqli_fetch_assoc($res)) {
            $map_d1[$row['kode']] = $row['id'];
        }

        // 2. Matikan FK Check & Truncate tabel sub_kelompok_utama
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0;");
        if (!mysqli_query($conn, "TRUNCATE TABLE sub_kelompok_utama")) {
            throw new Exception("Gagal melakukan TRUNCATE: " . mysqli_error($conn));
        }
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");

        // 3. Susun Query Multi-Insert
        $values = [];
        foreach ($data as $item) {
            $d1 = $item['d1'];
            $d2 = $item['d2'];
            $ket = mysqli_real_escape_string($conn, $item['keterangan']);

            // Pastikan ID Kelompok Utama ditemukan
            $kelompok_utama_id = $map_d1[$d1];
            $gabungan = $d1 . $d2; // Kombinasi D1 + D2

            $values[] = "($kelompok_utama_id, '$d2', '$gabungan', '$ket')";
        }

        if (!empty($values)) {
            $sql = "INSERT INTO sub_kelompok_utama (kelompok_utama_id, kode, gabungan, keterangan) VALUES " . implode(', ', $values);
            
            if (mysqli_query($conn, $sql)) {
                echo "<b>Berhasil!</b> Tabel <code>sub_kelompok_utama</code> telah diisi ulang dengan " . count($values) . " data baru.";
                return true;
            } else {
                throw new Exception("Gagal insert: " . mysqli_error($conn));
            }
        }

        return false;

    } catch (Exception $e) {
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");
        echo "<b>Error:</b> " . $e->getMessage();
        return false;
    }
}

function resetKategori($conn, $data)
{
    try {
        // 1. Ambil Map ID dari kelompok_utama (Key = kode d1)
        $map_d1 = [];
        $res1 = mysqli_query($conn, "SELECT id, kode FROM kelompok_utama");
        while ($row = mysqli_fetch_assoc($res1)) {
            $map_d1[$row['kode']] = $row['id'];
        }

        // 2. Ambil Map ID dari sub_kelompok_utama 
        // KEY digabung: "kelompok_utama_id . '_' . kode_d2" agar pas dan unik!
        $map_d2 = [];
        $res2 = mysqli_query($conn, "SELECT id, kelompok_utama_id, kode FROM sub_kelompok_utama");
        while ($row = mysqli_fetch_assoc($res2)) {
            $key = $row['kelompok_utama_id'] . '_' . $row['kode'];
            $map_d2[$key] = $row['id'];
        }

        // 3. Matikan FK Check & Truncate tabel kategori
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0;");
        if (!mysqli_query($conn, "TRUNCATE TABLE kategori")) {
            throw new Exception("Gagal melakukan TRUNCATE: " . mysqli_error($conn));
        }
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");

        // 4. Susun Query Multi-Insert
        $values = [];
        $tanpa_parent = [];

        foreach ($data as $item) {
            $d1 = $item['d1'];
            $d2 = $item['d2'];
            $d3 = $item['d3'];
            $ket = mysqli_real_escape_string($conn, $item['keterangan']);

            // Step A: Cari ID Kelompok Utama dulu
            $kelompok_utama_id = $map_d1[$d1];

            // Step B: Cari ID Sub Kelompok Utama yang TEPAT sesuai kelompok_utama_id & kode d2-nya
            $key_sub = $kelompok_utama_id . '_' . $d2;

            $sub_kelompok_utama_id = $map_d2[$key_sub];

            $gabungan = $d1 . $d2 . $d3; // Kombinasi D1 + D2 + D3

            // Catatan: Untuk kolom 'kode' pada tabel kategori, biasanya diisi $d3
            $values[] = "($kelompok_utama_id, $sub_kelompok_utama_id, '$d3', '$gabungan', '$ket')";
        }

        // 5. Eksekusi Query Multi-Insert
        if (!empty($values)) {
            $sql = "INSERT INTO kategori (kelompok_utama_id, sub_kelompok_utama_id, kode, gabungan, keterangan) VALUES " . implode(', ', $values);
            
            if (mysqli_query($conn, $sql)) {
                echo "<b>Berhasil!</b> Tabel <code>kategori</code> telah diisi ulang dengan " . count($values) . " data baru.";
                return true;
            } else {
                throw new Exception("Gagal insert: " . mysqli_error($conn));
            }
        } else {
            echo "<b>Peringatan:</b> Tidak ada data valid yang dapat di-insert.";
        }

        return false;

    } catch (Exception $e) {
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");
        echo "<b>Error:</b> " . $e->getMessage();
        return false;
    }
}

function resetSubKategori($conn, $data)
{
    try {
        // 1. Ambil Map dari KATEGORI dengan key gabungan bertingkat "d1_d2_d3"
        // Mengambil ID Kategori sekaligus Parent ID di atasnya (sub_kelompok & kelompok_utama)
        $map_kategori = [];
        $sql = "SELECT k.id AS kategori_id, 
                       k.sub_kelompok_utama_id, 
                       k.kelompok_utama_id, 
                       ku.kode AS d1, 
                       sku.kode AS d2, 
                       k.kode AS d3 
                FROM kategori k
                JOIN sub_kelompok_utama sku ON k.sub_kelompok_utama_id = sku.id
                JOIN kelompok_utama ku ON k.kelompok_utama_id = ku.id";
        
        $res = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $key = $row['d1'] . '_' . $row['d2'] . '_' . $row['d3'];
            $map_kategori[$key] = [
                'kategori_id'           => $row['kategori_id'],
                'sub_kelompok_utama_id' => $row['sub_kelompok_utama_id'],
                'kelompok_utama_id'     => $row['kelompok_utama_id']
            ];
        }

        // 2. Matikan FK Check & Truncate tabel sub_kategori
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0;");
        if (!mysqli_query($conn, "TRUNCATE TABLE sub_kategori")) {
            throw new Exception("Gagal melakukan TRUNCATE sub_kategori: " . mysqli_error($conn));
        }
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");

        // 3. Susun Query Multi-Insert
        $values = [];
        $tanpa_parent = [];
        $seen_keys = []; // Anti-Duplikasi record yang sama

        foreach ($data as $item) {
            $d1 = trim($item['d1']);
            $d2 = trim($item['d2']);
            $d3 = trim($item['d3']);
            $d4 = trim($item['d4']);
            $ket = mysqli_real_escape_string($conn, trim($item['keterangan']));

            // Abaikan jika Keterangan atau D4 Kosong
            if (empty($ket) || $d4 === '' || $d4 === '0') {
                $tanpa_parent[] = array_merge($item, ['alasan' => 'Data / Kode D4 Tidak Valid']);
                continue;
            }

            $parent_key = $d1 . '_' . $d2 . '_' . $d3;

            // Cek Parent Kategori
            if (!isset($map_kategori[$parent_key])) {
                $tanpa_parent[] = array_merge($item, ['alasan' => "Kategori Parent ({$d1}.{$d2}.{$d3}) Tidak Ditemukan"]);
                continue;
            }

            // Mencegah Duplikasi Row
            $full_code = $d1 . $d2 . $d3 . $d4;
            if (isset($seen_keys[$full_code])) {
                continue; // Skip data duplikat
            }
            $seen_keys[$full_code] = true;

            $kategori_id           = $map_kategori[$parent_key]['kategori_id'];
            $sub_kelompok_utama_id = $map_kategori[$parent_key]['sub_kelompok_utama_id'];
            $kelompok_utama_id     = $map_kategori[$parent_key]['kelompok_utama_id'];

            // Query Insert menyertakan korelasi Hirarki Lengkap
            $values[] = "($kelompok_utama_id, $sub_kelompok_utama_id, $kategori_id, '$d4', '$full_code', '$ket')";
        }

        // 4. Eksekusi Multi-Insert
        if (!empty($values)) {
            $sql = "INSERT INTO sub_kategori (kelompok_utama_id, sub_kelompok_utama_id, kategori_id, kode, gabungan, keterangan) VALUES " . implode(', ', $values);
            
            if (!mysqli_query($conn, $sql)) {
                throw new Exception("Gagal insert ke sub_kategori: " . mysqli_error($conn));
            }
            echo "<b>Berhasil!</b> Tabel <code>sub_kategori</code> telah diisi dengan " . count($values) . " data baru.<br>";
        } else {
            echo "<b>Peringatan:</b> Tidak ada data valid yang bisa dimasukkan.<br>";
        }

        // 5. Cetak Laporan Data Orphan / Tanpa Parent
        if (!empty($tanpa_parent)) {
            echo "<br><h4 style='color: red;'>⚠️ Perhatian: Ada " . count($tanpa_parent) . " Data ORPHAN (Harus Diinput Manual/Dibenahi):</h4>";
            echo "<table border='1' cellpadding='6' cellspacing='0' style='border-collapse:collapse;'>";
            echo "<tr style='background-color:#f2f2f2;'><th>D1</th><th>D2</th><th>D3</th><th>D4</th><th>Keterangan</th><th>Penyebab Orphan</th></tr>";
            foreach ($tanpa_parent as $tp) {
                echo "<tr>";
                echo "<td>{$tp['d1']}</td><td>{$tp['d2']}</td><td>{$tp['d3']}</td><td>{$tp['d4']}</td>";
                echo "<td>{$tp['keterangan']}</td>";
                echo "<td style='color:red;'>{$tp['alasan']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }

        return true;

    } catch (Exception $e) {
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");
        echo "<b>Error:</b> " . $e->getMessage();
        return false;
    }
}

function resetTurunanSubKategori($conn, $data)
{
    try {
        // 1. Ambil Map dari SUB_KATEGORI dengan key gabungan bertingkat "d1_d2_d3_d4"
        // Mengambil ID Sub Kategori beserta seluruh Parent ID di atasnya
        $map_sub_kategori = [];
        $sql = "SELECT sk.id AS sub_kategori_id,
                       sk.kategori_id,
                       sk.sub_kelompok_utama_id,
                       sk.kelompok_utama_id,
                       ku.kode AS d1,
                       sku.kode AS d2,
                       k.kode AS d3,
                       sk.kode AS d4
                FROM sub_kategori sk
                JOIN kategori k ON sk.kategori_id = k.id
                JOIN sub_kelompok_utama sku ON sk.sub_kelompok_utama_id = sku.id
                JOIN kelompok_utama ku ON sk.kelompok_utama_id = ku.id";

        $res = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $key = $row['d1'] . '_' . $row['d2'] . '_' . $row['d3'] . '_' . $row['d4'];
            $map_sub_kategori[$key] = [
                'sub_kategori_id'       => $row['sub_kategori_id'],
                'kategori_id'           => $row['kategori_id'],
                'sub_kelompok_utama_id' => $row['sub_kelompok_utama_id'],
                'kelompok_utama_id'     => $row['kelompok_utama_id']
            ];
        }

        // 2. Matikan FK Check & Truncate tabel turunan_sub_kategori
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0;");
        if (!mysqli_query($conn, "TRUNCATE TABLE turunan_sub_kategori")) {
            throw new Exception("Gagal melakukan TRUNCATE turunan_sub_kategori: " . mysqli_error($conn));
        }
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");

        // 3. Susun Query Multi-Insert
        $values = [];
        $tanpa_parent = [];
        $seen_keys = []; // Anti-Duplikasi record yang sama

        foreach ($data as $item) {
            $d1 = trim($item['d1']);
            $d2 = trim($item['d2']);
            $d3 = trim($item['d3']);
            $d4 = trim($item['d4']);
            $d5 = trim($item['d5']);
            $ket = mysqli_real_escape_string($conn, trim($item['keterangan']));

            // Abaikan jika Keterangan atau D5 Kosong
            if (empty($ket) || $d5 === '' || $d5 === '0') {
                $tanpa_parent[] = array_merge($item, ['alasan' => 'Data / Kode D5 Tidak Valid']);
                continue;
            }

            $parent_key = $d1 . '_' . $d2 . '_' . $d3 . '_' . $d4;

            // Cek Parent Sub Kategori
            if (!isset($map_sub_kategori[$parent_key])) {
                $tanpa_parent[] = array_merge($item, ['alasan' => "Sub Kategori Parent ({$d1}.{$d2}.{$d3}.{$d4}) Tidak Ditemukan"]);
                continue;
            }

            // Mencegah Duplikasi Row (Berdasarkan gabungan kode d1 sampai d5)
            $full_code = $d1 . $d2 . $d3 . $d4 . $d5;
            if (isset($seen_keys[$full_code])) {
                continue; // Skip data duplikat
            }
            $seen_keys[$full_code] = true;

            $sub_kategori_id       = $map_sub_kategori[$parent_key]['sub_kategori_id'];
            $kategori_id           = $map_sub_kategori[$parent_key]['kategori_id'];
            $sub_kelompok_utama_id = $map_sub_kategori[$parent_key]['sub_kelompok_utama_id'];
            $kelompok_utama_id     = $map_sub_kategori[$parent_key]['kelompok_utama_id'];

            // Query Insert menyertakan korelasi Hirarki Lengkap ke turunan_sub_kategori
            $values[] = "($kelompok_utama_id, $sub_kelompok_utama_id, $kategori_id, $sub_kategori_id, '$d5', '$full_code', '$ket')";
        }

        // 4. Eksekusi Multi-Insert
        if (!empty($values)) {
            $sql = "INSERT INTO turunan_sub_kategori (kelompok_utama_id, sub_kelompok_utama_id, kategori_id, sub_kategori_id, kode, gabungan, keterangan) VALUES " . implode(', ', $values);

            if (!mysqli_query($conn, $sql)) {
                throw new Exception("Gagal insert ke turunan_sub_kategori: " . mysqli_error($conn));
            }
            echo "<b>Berhasil!</b> Tabel <code>turunan_sub_kategori</code> telah diisi dengan " . count($values) . " data baru.<br>";
        } else {
            echo "<b>Peringatan:</b> Tidak ada data valid yang bisa dimasukkan.<br>";
        }

        // 5. Cetak Laporan Data Orphan / Tanpa Parent
        if (!empty($tanpa_parent)) {
            echo "<br><h4 style='color: red;'>⚠️ Perhatian: Ada " . count($tanpa_parent) . " Data ORPHAN (Harus Diinput Manual/Dibenahi):</h4>";
            echo "<table border='1' cellpadding='6' cellspacing='0' style='border-collapse:collapse;'>";
            echo "<tr style='background-color:#f2f2f2;'><th>D1</th><th>D2</th><th>D3</th><th>D4</th><th>D5</th><th>Keterangan</th><th>Penyebab Orphan</th></tr>";
            foreach ($tanpa_parent as $tp) {
                echo "<tr>";
                echo "<td>{$tp['d1']}</td><td>{$tp['d2']}</td><td>{$tp['d3']}</td><td>{$tp['d4']}</td><td>{$tp['d5']}</td>";
                echo "<td>{$tp['keterangan']}</td>";
                echo "<td style='color:red;'>{$tp['alasan']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }

        return true;

    } catch (Exception $e) {
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");
        echo "<b>Error:</b> " . $e->getMessage();
        return false;
    }
}

// Panggil fungsi
resetKelompokUtama($conn, $kelompok_utama);
resetSubKelompokUtama($conn, $data_sub_kelompok);
resetKategori($conn, $data_kategori);
resetSubKategori($conn, $data_sub_kategori);
resetTurunanSubKategori($conn, $data_turunan_sub_kategori);

?>