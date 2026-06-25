INSERT INTO products
(
    name,
    active_ingredient,
    manufacturer,
    strength,
    product_type,
    therapeutic_class,
    prescription_required,
    is_temperature_sensitive,
    purchase_price,
    selling_price,
    minimum_stock_level
)
VALUES
('Paracetamol', 'Paracetamol', NULL, '500mg', 'generic', 'Analgesic', 0, 0, 0, 0, 10),
('Paracetamol', 'Paracetamol', NULL, '1000mg', 'generic', 'Analgesic', 0, 0, 0, 0, 10),
('Ibuprofen', 'Ibuprofen', NULL, '200mg', 'generic', 'Analgesic', 0, 0, 0, 0, 10),
('Ibuprofen', 'Ibuprofen', NULL, '400mg', 'generic', 'Analgesic', 0, 0, 0, 0, 10),
('Ibuprofen', 'Ibuprofen', NULL, '600mg', 'generic', 'Analgesic', 0, 0, 0, 0, 10),
('Diclofenac', 'Diclofenac', NULL, '50mg', 'generic', 'Anti-inflammatory', 1, 0, 0, 0, 10),
('Diclofenac', 'Diclofenac', NULL, '75mg', 'generic', 'Anti-inflammatory', 1, 0, 0, 0, 10),
('Diclofenac', 'Diclofenac', NULL, '100mg', 'generic', 'Anti-inflammatory', 1, 0, 0, 0, 10),
('Ketoprofen', 'Ketoprofen', NULL, '100mg', 'generic', 'Anti-inflammatory', 1, 0, 0, 0, 10),
('Ketoprofen', 'Ketoprofen', NULL, '200mg', 'generic', 'Anti-inflammatory', 1, 0, 0, 0, 10),
('Naproxen', 'Naproxen', NULL, '250mg', 'generic', 'Anti-inflammatory', 1, 0, 0, 0, 10),
('Naproxen', 'Naproxen', NULL, '500mg', 'generic', 'Anti-inflammatory', 1, 0, 0, 0, 10),
('Aspirin', 'Acetylsalicylic Acid', NULL, '81mg', 'generic', 'Analgesic', 0, 0, 0, 0, 10),
('Aspirin', 'Acetylsalicylic Acid', NULL, '100mg', 'generic', 'Analgesic', 0, 0, 0, 0, 10),
('Aspirin', 'Acetylsalicylic Acid', NULL, '500mg', 'generic', 'Analgesic', 0, 0, 0, 0, 10),
('Tramadol', 'Tramadol', NULL, '50mg', 'generic', 'Analgesic', 1, 0, 0, 0, 10),
('Tramadol', 'Tramadol', NULL, '100mg', 'generic', 'Analgesic', 1, 0, 0, 0, 10),
('Codeine', 'Codeine', NULL, '30mg', 'generic', 'Analgesic', 1, 0, 0, 0, 10),
('Morphine', 'Morphine', NULL, '10mg', 'generic', 'Analgesic', 1, 0, 0, 0, 10),
('Morphine', 'Morphine', NULL, '30mg', 'generic', 'Analgesic', 1, 0, 0, 0, 10),
('Celecoxib', 'Celecoxib', NULL, '100mg', 'generic', 'Anti-inflammatory', 1, 0, 0, 0, 10),
('Celecoxib', 'Celecoxib', NULL, '200mg', 'generic', 'Anti-inflammatory', 1, 0, 0, 0, 10),
('Meloxicam', 'Meloxicam', NULL, '7.5mg', 'generic', 'Anti-inflammatory', 1, 0, 0, 0, 10),
('Meloxicam', 'Meloxicam', NULL, '15mg', 'generic', 'Anti-inflammatory', 1, 0, 0, 0, 10),
('Piroxicam', 'Piroxicam', NULL, '20mg', 'generic', 'Anti-inflammatory', 1, 0, 0, 0, 10),
('Indomethacin', 'Indomethacin', NULL, '25mg', 'generic', 'Anti-inflammatory', 1, 0, 0, 0, 10),
('Indomethacin', 'Indomethacin', NULL, '50mg', 'generic', 'Anti-inflammatory', 1, 0, 0, 0, 10),
('Acetaminophen', 'Paracetamol', NULL, '325mg', 'generic', 'Analgesic', 0, 0, 0, 0, 10),
('Acetaminophen', 'Paracetamol', NULL, '650mg', 'generic', 'Analgesic', 0, 0, 0, 0, 10),
('Metamizole', 'Metamizole Sodium', NULL, '500mg', 'generic', 'Analgesic', 1, 0, 0, 0, 10);
('Amoxicillin', 'Amoxicillin', NULL, '250mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Amoxicillin', 'Amoxicillin', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Amoxicillin', 'Amoxicillin', NULL, '875mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Ampicillin', 'Ampicillin', NULL, '250mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Ampicillin', 'Ampicillin', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Cloxacillin', 'Cloxacillin', NULL, '250mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Cloxacillin', 'Cloxacillin', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Flucloxacillin', 'Flucloxacillin', NULL, '250mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Flucloxacillin', 'Flucloxacillin', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Penicillin V', 'Phenoxymethylpenicillin', NULL, '250mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Penicillin V', 'Phenoxymethylpenicillin', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Azithromycin', 'Azithromycin', NULL, '250mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Azithromycin', 'Azithromycin', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Clarithromycin', 'Clarithromycin', NULL, '250mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Clarithromycin', 'Clarithromycin', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Erythromycin', 'Erythromycin', NULL, '250mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Erythromycin', 'Erythromycin', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Doxycycline', 'Doxycycline', NULL, '100mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Tetracycline', 'Tetracycline', NULL, '250mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Tetracycline', 'Tetracycline', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Ciprofloxacin', 'Ciprofloxacin', NULL, '250mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Ciprofloxacin', 'Ciprofloxacin', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Ciprofloxacin', 'Ciprofloxacin', NULL, '750mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Levofloxacin', 'Levofloxacin', NULL, '250mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Levofloxacin', 'Levofloxacin', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Ofloxacin', 'Ofloxacin', NULL, '200mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Ofloxacin', 'Ofloxacin', NULL, '400mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Metronidazole', 'Metronidazole', NULL, '250mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Metronidazole', 'Metronidazole', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Tinidazole', 'Tinidazole', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Cefalexin', 'Cephalexin', NULL, '250mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Cefalexin', 'Cephalexin', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Cefuroxime', 'Cefuroxime', NULL, '250mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Cefuroxime', 'Cefuroxime', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Cefixime', 'Cefixime', NULL, '200mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Cefixime', 'Cefixime', NULL, '400mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),

('Ceftriaxone', 'Ceftriaxone', NULL, '250mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Ceftriaxone', 'Ceftriaxone', NULL, '500mg', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Ceftriaxone', 'Ceftriaxone', NULL, '1g', 'generic', 'Antibiotic', 1, 0, 0, 0, 10),
('Ceftriaxone', 'Ceftriaxone', NULL, '2g', 'generic', 'Antibiotic', 1, 0, 0, 0, 10);

('Quinine', 'Quinine Sulfate', NULL, '300mg', 'generic', 'Antimalarial', 1, 0, 0, 0, 10),
('Quinine', 'Quinine Sulfate', NULL, '600mg', 'generic', 'Antimalarial', 1, 0, 0, 0, 10),

('Artemether', 'Artemether', NULL, '20mg', 'generic', 'Antimalarial', 1, 0, 0, 0, 10),
('Artemether', 'Artemether', NULL, '80mg', 'generic', 'Antimalarial', 1, 0, 0, 0, 10),

('Lumefantrine', 'Lumefantrine', NULL, '120mg', 'generic', 'Antimalarial', 1, 0, 0, 0, 10),

('Artemether + Lumefantrine', 'Artemether + Lumefantrine', NULL, '20mg/120mg', 'generic', 'Antimalarial', 1, 0, 0, 0, 10),
('Artemether + Lumefantrine', 'Artemether + Lumefantrine', NULL, '80mg/480mg', 'generic', 'Antimalarial', 1, 0, 0, 0, 10),

('Artesunate', 'Artesunate', NULL, '50mg', 'generic', 'Antimalarial', 1, 0, 0, 0, 10),
('Artesunate', 'Artesunate', NULL, '100mg', 'generic', 'Antimalarial', 1, 0, 0, 0, 10),
('Artesunate', 'Artesunate', NULL, '200mg', 'generic', 'Antimalarial', 1, 0, 0, 0, 10),

('Dihydroartemisinin + Piperaquine', 'Dihydroartemisinin + Piperaquine', NULL, '40mg/320mg', 'generic', 'Antimalarial', 1, 0, 0, 0, 10),

('Sulfadoxine + Pyrimethamine', 'Sulfadoxine + Pyrimethamine', NULL, '500mg/25mg', 'generic', 'Antimalarial', 1, 0, 0, 0, 10),

('Chloroquine', 'Chloroquine', NULL, '250mg', 'generic', 'Antimalarial', 1, 0, 0, 0, 10),

('Primaquine', 'Primaquine', NULL, '15mg', 'generic', 'Antimalarial', 1, 0, 0, 0, 10),

('Mefloquine', 'Mefloquine', NULL, '250mg', 'generic', 'Antimalarial', 1, 0, 0, 0, 10),

('Albendazole', 'Albendazole', NULL, '200mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),
('Albendazole', 'Albendazole', NULL, '400mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),

('Mebendazole', 'Mebendazole', NULL, '100mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),
('Mebendazole', 'Mebendazole', NULL, '500mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),

('Praziquantel', 'Praziquantel', NULL, '600mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),

('Ivermectin', 'Ivermectin', NULL, '3mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),
('Ivermectin', 'Ivermectin', NULL, '6mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),
('Ivermectin', 'Ivermectin', NULL, '12mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),

('Nitazoxanide', 'Nitazoxanide', NULL, '500mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),

('Metronidazole', 'Metronidazole', NULL, '500mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),

('Secnidazole', 'Secnidazole', NULL, '500mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),
('Secnidazole', 'Secnidazole', NULL, '1g', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),

('Tinidazole', 'Tinidazole', NULL, '500mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),

('Levamisole', 'Levamisole', NULL, '40mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),
('Levamisole', 'Levamisole', NULL, '80mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),

('Niclosamide', 'Niclosamide', NULL, '500mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10),

('Pyrantel', 'Pyrantel Pamoate', NULL, '250mg', 'generic', 'Antiparasitic', 1, 0, 0, 0, 10);